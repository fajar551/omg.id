<?php

namespace App\Src\Services\Midtrans;

use App\Models\Invoice;
use Midtrans\Snap;
use Midtrans\CoreApi;
use App\Models\Item;
use App\Models\Page;
use App\Models\PaymentMethod;
use App\Models\StreamKey;
use App\Models\Support;
use App\Models\SupportDetail;
use App\Models\User;
use App\Models\UserBalance;
use App\Src\Validators\PaymentValidator;
use App\Src\Helpers\ApiResponse;
use App\Src\Jobs\SendEmailInvoiceJob;
use App\Src\Services\Eloquent\ContentService;
use App\Src\Services\Eloquent\ContentSubscribeService;
use App\Src\Services\Eloquent\GoalService;
use App\Src\Services\Eloquent\ItemService;
use App\Src\Services\Eloquent\PageService;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Services\Eloquent\SupportService;
use App\Src\Services\Eloquent\WidgetService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService extends Midtrans
{
    protected $order;
    protected $modelItem;
    protected $modelPaymentMethod;
    protected $modelInvoice;
    protected $modelSupport;
    protected $modelSupportDetail;
    protected $modelUserBalance;
    protected $modelStreamKey;
    protected $validator;
    protected $modelPage;
    protected $modelUser;

    public function __construct(Item $modelItem, PaymentMethod $modelPaymentMethod, Invoice $modelInvoice, PaymentValidator $validator, Support $modelSupport, SupportDetail $modelSupportDetail, UserBalance $modelUserBalance, StreamKey $modelStreamKey, Page $modelPage, User $modelUser)
    {
        parent::__construct();
        $this->modelItem = $modelItem;
        $this->modelPaymentMethod = $modelPaymentMethod;
        $this->modelInvoice = $modelInvoice;
        $this->modelSupport = $modelSupport;
        $this->modelSupportDetail = $modelSupportDetail;
        $this->modelUserBalance = $modelUserBalance;
        $this->modelStreamKey = $modelStreamKey;
        $this->validator = $validator;
        $this->modelPage = $modelPage;
        $this->modelUser = $modelUser;
    }

    /**
     * Proses payment menggunakan midtrans.
     * 
     * Alurnya dimulai dengan mendapatkan token di function getSnapToken() untuk menampilan modal payment pada frontend.
     * 
     * Proses simpan data ke database ada di function snapcharge()
     */
    public function getSnapToken(array $data)
    {
        // validasi pageurl
        PageService::getInstance()->validatePageurl($data['page_url']);
        $modelPage = $this->modelPage->where('page_url', $data['page_url'])->first();
        $modelUser = $this->modelUser->where('username', $data['page_url'])->first();

        $creator_id = $modelPage->user_id ?? $modelUser->id;
        $data['creator_id'] = $creator_id;
        $this->validator->validateStore($data);

        $item_details = array();
        $gross_amount = 0;
        for ($i = 0; $i < count($data['items']); $i++) {
            $modelItem = $this->modelItem->find($data['items'][$i]['item_id']);
            $gross_amount = $gross_amount + ($modelItem->price * $data['items'][$i]['qty']);
            \array_push($item_details, array(
                'id' => $data['items'][$i]['item_id'],
                'price' => (int) $modelItem->price,
                'quantity' => $data['items'][$i]['qty'],
                'name' => $modelItem->name
            ));
        }

        if ($gross_amount > 10000000) {
            return __("message.max_support");
        }

        $content_subscribe = ContentSubscribeService::getInstance();
        if ($data['type'] == 2) {
            $content_subscribe->validate($data);
            $cek_konten = ContentService::getInstance()->show($data['content_id']);
            $item = ItemService::getInstance()->getActiveItems($creator_id)[0];
            $content_price = $cek_konten->qty * $item['price'];
            // dd($content_price);
            if ($gross_amount < $content_price) {
                return __("message.total_items_less");
            }
        }

        $order_id = 'PAYMENT-' . $creator_id . Str::random(10). date('YmdHis');

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $gross_amount,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => $data['name'],
                'email' => $data['email']
            ]
        ];

        // fungsi request token ke midtrans
        $snapToken = Snap::getSnapToken($params);
        $result = [
            'token' => $snapToken,
            'param' => $data
        ];
       // return $snapToken;
        unset($data['creator_id']);

        // insert data ke tabel payment temporary
        DB::table('payment_temp')->insert([
            'order_id' => $order_id,
            'data' => json_encode($data)
        ]);

        return $result;
    }

    /**
     * Get Snap Token untuk Product Payment
     */
    public function getSnapTokenForProduct(array $paymentData)
    {
        // Fungsi request token ke midtrans
        $snapToken = Snap::getSnapToken($paymentData);
        return $snapToken;
    }

    // function untuk insert data ke db
    public function snapcharge(array $data)
    {
        // \dd($data['snapresponse']['order_id']);
        if (!empty($this->modelInvoice->where("order_id", $data['snapresponse']['order_id'])->first())) {
            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                // "data" => $result,
            ]);
        }

        if ($data['snapresponse']['status_code']!=201 && $data['snapresponse']['status_code']!=200 ) {
            return 'Failed create invoice!';
        }

        $settingService = SettingService::getInstance();


        $platform_fee = $settingService->get('platform_fee');

        if ($data['snapresponse']['payment_type']=='bank_transfer') {
            $pg_fee = $settingService->get('bank_transfer');
            $pg_amount = round($pg_fee + ($pg_fee * ($settingService->get('ppn')/100)));
        } elseif ($data['snapresponse']['payment_type']=='credit_card') {
            $pg_fee = $settingService->get('cc_percent') . '% + ' .$settingService->get('cc_rp');
            $cc_percent = $settingService->get('cc_percent');
            $pg_amount = round((((float) $data['snapresponse']['gross_amount'] * (float) $cc_percent) / 100) + $settingService->get('cc_rp')  + ((($data['snapresponse']['gross_amount'] * ($cc_percent / 100)) + $settingService->get('cc_rp')) * ($settingService->get('ppn')/100)));
        } else {
            $pg_fee = $settingService->get($data['snapresponse']['payment_type']);
            $pg_amount = round((((float) $data['snapresponse']['gross_amount'] * (float) $pg_fee) / 100)  + (($data['snapresponse']['gross_amount'] * ($pg_fee / 100)) * ($settingService->get('ppn')/100)));
        }

        PageService::getInstance()->validatePageurl($data['page_url']);
        $modelPage = $this->modelPage->where('page_url', $data['page_url'])->first();
        $modelUser = $this->modelUser->where('username', $data['page_url'])->first();

        $creator_id = $modelPage->user_id ?? $modelUser->id;

        $model = $this->modelInvoice;
        $model->transaction_id =  $data['snapresponse']['transaction_id'];
        $model->order_id =  $data['snapresponse']['order_id'];
        $model->user_id =  @$data['supporter_id'];
        $model->gross_amount = (double) $data['snapresponse']['gross_amount'];
        $model->pg_fee = $pg_fee;
        $model->pg_amount = $pg_amount;
        $model->platform_fee = $platform_fee;
        $platform_amount = ((double) $data['snapresponse']['gross_amount'] * (double) $platform_fee)/100;
        $model->platform_amount = $platform_amount;
        $model->creator_amount = (double) $data['snapresponse']['gross_amount']-$pg_amount-$platform_amount;
        $model->email = $data['email'];
        $model->type = $data['type'];
        $model->notes = $data['message'];
        $model->payment_method_id = $data['payment_method_id'];
        $due_date = new \DateTime(date("Y-m-d H:i:s"));
        $due_date->modify('+1 hour');
        $model->due_date = $due_date;
        $model->status =  $data['snapresponse']['transaction_status'];
        $model->payment_type =  $data['snapresponse']['payment_type'];

        if (isset($data['snapresponse']['permata_va_number'])) {
            $model->information_id = $data['snapresponse']['permata_va_number'];
        } else if (isset($data['snapresponse']['bill_key'])) {
            $model->information_id = $data['snapresponse']['bill_key'];
        } else if (isset($data['snapresponse']['va_numbers'][0]['va_number'])) {
            $model->information_id = $data['snapresponse']['va_numbers'][0]['va_number'];
        }
        
        $content_subscribe = ContentSubscribeService::getInstance();
        if ($data['type'] == 2) {
            $paramsubs = array('supporter_id' => @$data['supporter_id'], 'content_id' => @$data['content_id'], 'email' => $data['email'], 'order_id' => $data['snapresponse']['order_id']);
            $content_subscribe->store($paramsubs);
        }
        
        $model->save();

        $invoice_id = $model->id;
        $goal = GoalService::getInstance()->getActiveGoals($creator_id);
        $support = $this->modelSupport;
        $support->creator_id = $creator_id;
        $support->supporter_id = @$data['supporter_id'];
        $support->content_id = @$data['content_id'];
        $support->invoice_id = $invoice_id;
        $support->goal_id = $goal['id'] ?? null;
        $support->name = $data['name'];
        $support->email = $data['email'];
        $support->message = $data['message'];
        $support->is_anonim = @$data['is_anonim'];
        $support->is_private = @$data['is_private'];
        $support->type = @$data['type'];
        if ($settingService->get('media_share', null, $creator_id) != null) {
            if ($settingService->get('media_share', null, $creator_id)->status == 1) {
                $support->media_share = isset($data['media_share']) ? $data['media_share'] : null;
            }
        }
        $support->save();

        $support_id = $support->id;

        $itemdetail = array();
        for ($i = 0; $i < count($data['items']); $i++) {
            $modelItem = $this->modelItem->find($data['items'][$i]['item_id']);
            \array_push($itemdetail, array(
                'support_id' => $support_id,
                'item_id' => $data['items'][$i]['item_id'],
                'price' => (int) $modelItem->price,
                'qty' => $data['items'][$i]['qty'],
                'total' => $modelItem->price * $data['items'][$i]['qty']
            ));
        }

        $this->modelSupportDetail->insert($itemdetail);

        // $detailemail = SupportService::getInstance()->getbyOrderid($data['snapresponse']['order_id']);
        // SendEmailInvoiceJob::dispatch(array('email' => $detailemail['email'], 'data' => $detailemail));

        // if ($data['snapresponse']['transaction_status'] == 'settlement') {
        //     $this->callback($data['snapresponse']);
        // }

        // Delete temp data
        $chek_temp = DB::table('payment_temp')
                ->where('order_id', $data['snapresponse']['order_id'])
                ->first();
        if ($chek_temp) {
            DB::table('payment_temp')->where('order_id', $data['snapresponse']['order_id'])->delete();
        }

        return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                // "data" => $result,
            ]);
    }


    public function callback(array $data)
    {

        $order_id = $data['order_id'];

        $chek_temp = DB::table('payment_temp')
                ->where('order_id', $order_id)
                ->first();

        if ($chek_temp) {

            $snapresponse = [
                'payment_type' => $data['payment_type'],
                'gross_amount' => $data['gross_amount'],
                'status_code' => $data['status_code'],
                'transaction_id' => $data['transaction_id'],
                'order_id' => $data['order_id'],
                'transaction_status' => $data['transaction_status']
            ];

            $tmp = array_merge(['snapresponse' => $snapresponse], json_decode($chek_temp->data, TRUE));
            $this->snapcharge($tmp);

            // return;
        }

        // TODO: Check this sometime thrown NPE from callback, check in the $model->id 
        $model = $this->modelInvoice->where("order_id", $order_id)->first();
        $support = $this->modelSupport->where("invoice_id", $model->id)->first();
    
        if ($support->status != 1) {
            $model->status = $data['transaction_status'];
            if ($data['transaction_status'] == "settlement" || $data['transaction_status'] == "capture") {
                $model->status = "Success";
                $model->date_paid = $data['settlement_time'] ?? $data['transaction_time'];
                $date_active = new \DateTime($model->date_paid);
                $date_active->modify('+3 day');
                $model->date_active = $date_active;
                $support->status = 1;
                if ($support->content_id != null) {
                    ContentSubscribeService::getInstance()->update(array('content_id' => $support->content_id, 'supporter_id' => $support->supporter_id, 'created' => $model->date_paid, 'email' => $support->email));
                }
                $modelUserBalance = $this->modelUserBalance->where("user_id", $support['creator_id'])->first();
                $modelUserBalance->pending = $modelUserBalance->pending + $model['creator_amount'];
                // \dd($modelUserBalance);
                $modelUserBalance->save();
                $support->save();
    
                $modelStreamKey = $this->modelStreamKey->where("user_id", $support['creator_id'])->first();
                if ($modelStreamKey != null) {
                    try {
                        $datas = [
                            "real_data" => true,
                            "key" => "notification",
                            "userid" => $support['creator_id'],
                            "streamKey" => $modelStreamKey->key,
                            "support_type" => $support->type,
                        ];
                        if (isset($support->supporter_id)) {
                            $datas['supporter_id'] = $support->supporter_id;
                        }else{
                            $datas['supporter_email'] = $model->email;
                        }
    
                        $wInstance = WidgetService::getInstance();
                        $wInstance->setWidgetType("overlay");
                        $wInstance->widgetShow($datas);
                    } catch (\Throwable $ex) {
                        activity()
                            ->inLog('Error Exception')
                            ->withProperties(['attributes' => [
                                "route" => 'Services/Midtrans',
                                "class" => PaymentService::class,
                                "function" => 'error',
                                "error" => $ex->getCode(),
                                "message" => $ex->getMessage(),
                                "params" => $data,
                                "trace" => strtok($ex->getTraceAsString(), '#1')
                                ]])
                                ->log($ex->getMessage());
                    }
                }
                $result = $model->save();
                
                $detailemail = SupportService::getInstance()->getbyOrderid($order_id);
                SendEmailInvoiceJob::dispatch(array('email' => $detailemail['email'], 'status' => $model->status, 'data' => $detailemail));
            }elseif ($data['transaction_status'] == 'expire') {
                $model->date_canceled = $data['transaction_time'];
                $model->status = 'Expired';
                $result = $model->save();
                $detailemail = SupportService::getInstance()->getbyOrderid($order_id);
                SendEmailInvoiceJob::dispatch(array('email' => $detailemail['email'], 'status'=> $model->status, 'data' => $detailemail));
            }else{
                $result = $model->save();
                $detailemail = SupportService::getInstance()->getbyOrderid($order_id);
                SendEmailInvoiceJob::dispatch(array('email' => $detailemail['email'], 'status'=> $model->status, 'data' => $detailemail));
            }
    
            return $result;
        } else {
            return ['message' => 'Already updated'];
        } 
        
    }
}
