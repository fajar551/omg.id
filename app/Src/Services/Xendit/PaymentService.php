<?php

namespace App\Src\Services\Xendit;

use Xendit\Xendit;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Page;
use App\Models\PaymentMethod;
use App\Models\StreamKey;
use App\Models\Support;
use App\Models\SupportDetail;
use App\Models\User;
use App\Models\UserBalance;
use App\Src\Jobs\SendEmailInvoiceJob;
use App\Src\Services\Eloquent\ContentService;
use App\Src\Services\Eloquent\ContentSubscribeService;
use App\Src\Services\Eloquent\GoalService;
use App\Src\Services\Eloquent\ItemService;
use App\Src\Services\Eloquent\PageService;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Services\Eloquent\SupportService;
use App\Src\Services\Eloquent\WidgetService;
use App\Src\Validators\PaymentValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentService extends Xendits
{
    protected $modelItem;
    protected $modelPaymentMethod;
    protected $modelInvoice;
    protected $modelSupport;
    protected $modelSupportDetail;
    protected $modelUserBalance;
    protected $modelStreamKey;
    protected $modelPage;
    protected $modelUser;
    protected $validator;

    public function __construct(Item $modelItem, PaymentMethod $modelPaymentMethod, Invoice $modelInvoice, Support $modelSupport, SupportDetail $modelSupportDetail, UserBalance $modelUserBalance, StreamKey $modelStreamKey, Page $modelPage, User $modelUser, PaymentValidator $validator)
    {
        parent::__construct();
        $this->modelItem = $modelItem;
        $this->modelPaymentMethod = $modelPaymentMethod;
        $this->modelInvoice = $modelInvoice;
        $this->modelSupport = $modelSupport;
        $this->modelSupportDetail = $modelSupportDetail;
        $this->modelUserBalance = $modelUserBalance;
        $this->modelStreamKey = $modelStreamKey;
        $this->modelPage = $modelPage;
        $this->modelUser = $modelUser;
        $this->validator = $validator;
    }

    public static function getInstance(){
        return new static(new Item(), new PaymentMethod(), new Invoice(), new Support(), new SupportDetail(), new UserBalance(), new StreamKey(), new Page(), new User(), new PaymentValidator());
    }

    /**
     * function ini digunakan untuk proses request payment ke xendit dan juga perhitungan fee. Terdapat banyak proses menyimpan data dan pengecekan pada function ini
     *
     **/

    public function paymentchargenew(array $data)
    {
        // mengecek pageurl atau page support apakah ada atau tidak
        PageService::getInstance()->validatePageurl($data['page_url']);
        $modelPage = $this->modelPage->where('page_url', $data['page_url'])->first();
        $modelUser = $this->modelUser->where('username', $data['page_url'])->first();

        $creator_id = $modelPage->user_id ?? $modelUser->id;
        $data['creator_id'] = $creator_id;
        
        $this->validator->validateStore($data);

        // mengecek id payment method tersedia atau tidak
        $paymentMethod = $this->modelPaymentMethod->find($data['payment_method_id']);

        // get setting fee
        $settingService = SettingService::getInstance();

        $platform_fee = $settingService->get('platform_fee');
        $item_details = array();
        $gross_amount = 0;

        /**
         * membuat list detail item, sebenarnya bisa tidak perlu menggunakan looping. namun karna sebelumnya saat support bisa memilih beberapa item sehingga harus menggunakan looping.
         * kelebihannya menggunakan looping bisa digunakan jika sewaktu-waktu ingin bisa mensupport dengan item yang berbeda
         */
        for ($i = 0; $i < count($data['items']); $i++) {
            $modelItem = $this->modelItem->find($data['items'][$i]['item_id']);
            $gross_amount = $gross_amount + ($modelItem->price * $data['items'][$i]['qty']);
            \array_push($item_details, array(
                'id' => (string) $data['items'][$i]['item_id'],
                'price' => (int) $modelItem->price,
                'quantity' => $data['items'][$i]['qty'],
                'name' => $modelItem->name
            ));
        }

        // pengecekan limit support tidak boleh lebih dari 10juta
        if ($gross_amount > 10000000) {
            return __("message.max_support");
        }

        $external_id = $data['order_id'] ?? 'PAYMENT-'. $creator_id . Str::random(10). date('YmdHis');
        $redirect_url = route('support.payment_status', ['page_name' => $data['page_url'], 'orderID' => $external_id]); //url('payment-status').'/'.$external_id;
        
        // pengecekan payment type apakah menggunakan ewallet atau bank transfer
        if ($paymentMethod->payment_type == 'bank_transfer') {
            $pg_fee = $settingService->get('bank_transfer');
            $pg_amount = round($pg_fee + ($pg_fee * ($settingService->get('ppn')/100)));
            // parameter yang dibutuhkan pada payment bank transfer, bisa dicek di dokumentasi xendit
            $params = [
                "external_id" => $external_id,
                "bank_code" => (string) strtoupper($paymentMethod->bank_name),
                "name" => (string) $data['name'],
                "is_closed" => true,
                "is_single_use" => true,
                "expected_amount" => (double) $gross_amount
            ];
        } else {
            $pg_fee = $settingService->get($paymentMethod->payment_type);
            // perhitungan fee
            $pg_amount = round(($gross_amount * ($pg_fee / 100)) + (($gross_amount * ($pg_fee / 100)) * ($settingService->get('ppn')/100)));
            // parameter yang dibutuhkan pada payment e-wallet, bisa dicek di dokumentasi xendit
            $params = [
                'reference_id' => $external_id,
                'currency' => 'IDR',
                'amount' => (float) $gross_amount,
                'checkout_method' => 'ONE_TIME_PAYMENT',
                'channel_code' => 'ID_'.strtoupper($paymentMethod->payment_type),
                'channel_properties' => [
                    'success_redirect_url' => $redirect_url,
                    'mobile_number' => $data['phone_number']
                ],
                'metadata' => [
                    'branch_code' => 'tree_branch'
                ]
            ];
        }


        try {

            // check tabel temporary berdasarkan order_id jika ada datanya maka akan menggunakan data tersebut, jika tidak maka akan request ke xendit. Ada pada bagian else

            $chek_temp = DB::table('payment_temp')
                ->where('order_id', $external_id)
                ->first();

            $result = '';
            if ($chek_temp) {
                $result = $data["result"];
            }else {
                
                $content_subscribe = ContentSubscribeService::getInstance();

                // proses subscribe content. Subscribe content ditandai dengan type nya bernilai 2. Jika support biasa nilainya 1
                if ($data['type'] == 2) {
                    $content_subscribe->validate($data);
                    $paramsubs = array('supporter_id' => @$data['supporter_id'], 'content_id' => @$data['content_id'], 'email' => $data['email'], 'order_id' => $external_id);
                    $cek_konten = ContentService::getInstance()->show($data['content_id']);
                    $item = ItemService::getInstance()->getActiveItems($creator_id)[0];
                    $content_price = $cek_konten->qty * $item['price'];
                    if ($gross_amount < $content_price) {
                        return __("message.total_items_less");
                    }
                    $content_subscribe->store($paramsubs);
                }
                
                // proses create request ke xendit berdasarkan payment_type bank_transfer atau ewallet
                if ($paymentMethod->payment_type == 'bank_transfer') {
                    $result = \Xendit\VirtualAccounts::create($params);
                } else {
                    $result = \Xendit\EWallets::createEWalletCharge($params);
                }
                
                // proses insert ke tabel payment temporary
                DB::table('payment_temp')->insert([
                    'order_id' => $external_id,
                    'data' => json_encode([
                        'data' => $data,
                        'result' => $result
                    ])
                ]);

                return $result;
            }
            

            // return $result;

            // Proses insert data ke tabel invoice
            $model = $this->modelInvoice;
            $model->payment_method_id = $data['payment_method_id'];
            $model->gross_amount = $gross_amount;
            $model->pg_fee = $pg_fee;
            $model->pg_amount = $pg_amount;
            $model->platform_fee = $platform_fee;
            $platform_amount = ($gross_amount * (double) $platform_fee)/100;
            $model->platform_amount = $platform_amount;
            $model->creator_amount = $gross_amount-$pg_amount-$platform_amount;
            $model->email = $data['email'];
            $model->type = $data['type'];
            $model->notes = $data['message'];
            $due_date = new \DateTime(date("Y-m-d H:i:s"));
            $due_date->modify('+1 hour');
            $model->due_date = $due_date;
            $model->status =  "PENDING";
            if ($paymentMethod->payment_type == 'bank_transfer') {
                $model->transaction_id =  $result['id'];
                $model->order_id =  $params['external_id'];
                $model->information_id = $result['account_number'];
                $model->payment_type =  $paymentMethod->name;
            } else {
                $model->transaction_id = $result['id'];
                $model->order_id =  $params['reference_id'];
                $model->information_id = $data['phone_number'];    
                $model->payment_type =  $paymentMethod->payment_type;            
            }

            $model->save();

        // Proses insert ke tabel support
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

        // proses insert ke tabel detail support
        $this->modelSupportDetail->insert($itemdetail);

        if ($chek_temp) {
            DB::table('payment_temp')->where('order_id', $external_id)->delete();
        }

        return $result;

        // handle jika terjadi error pada proses request
        } catch (\Xendit\Exceptions\ApiException $exception) {
            return $exception;
        }
    }

    /**
     * function ini digunakan untuk menerima callback dari xendit dengan payment_type ewallet
     */
    public function callbackewallet(array $data)
    {
        // Log::info($data);

        $order_id = $data['data']['reference_id'];
        // Cek data ke tabel temporary berdasarkan order id. Pada payload yang dikirim xendit namanya reference_id
        $chek_temp = DB::table('payment_temp')
                ->where('order_id', $order_id)
                ->first();

        if ($chek_temp) {
            // Jika data ada di tabel temporary, maka akan dieksekusi pada function paymentchargenew() untuk proses insert ke database
            $gettmp = json_decode($chek_temp->data, TRUE);
            $tmp = array_merge(
                $gettmp["data"],[
                'result' => $gettmp["result"],
                'order_id' => $chek_temp->order_id
            ]);
            $this->paymentchargenew($tmp);

            // return;
        }

        // get data dari tabel invoice dan support 
        $model = $this->modelInvoice->where("order_id", $order_id)->first();
        $support = $this->modelSupport->where("invoice_id", $model->id)->first();
        
        if ($model->status != 'SUCCEEDED') {
            $model->status = $data['data']['status'];
            // Proses update status di tabel invoice, support, content subscribe jika statusnya success
            if ($data['data']['status']== "SUCCEEDED") {
                $model->status = "Success";
                $model->date_paid = date("Y-m-d H:i:s", strtotime(strtok($data['created'], '.')));
                $date_active = new \DateTime(date("Y-m-d H:i:s", strtotime(strtok($data['created'], '.'))));
                $date_active->modify('+3 day');
                $model->date_active = $date_active;
                $support->status = 1;
                if ($support->content_id != null) {
                    ContentSubscribeService::getInstance()->update(array('content_id' => $support->content_id, 'supporter_id' => $support->supporter_id, 'created' => $model->date_paid, 'email' => $support->email, 'order_id' => $order_id));
                }

                // update nilai balance user
                $modelUserBalance = $this->modelUserBalance->where("user_id", $support['creator_id'])->first();
                $modelUserBalance->pending = $modelUserBalance->pending + $model['creator_amount'];
                $modelUserBalance->save();

                $support->save();

                // menampilan widget
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
                                "route" => 'Services/Xendit',
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
            }else{
                $model->date_canceled = date("Y-m-d H:i:s", strtotime($data['created']));
            }
            $result = $model->save();

            // send email invoice ke email
            $detailemail = SupportService::getInstance()->getbyOrderid($order_id);
            SendEmailInvoiceJob::dispatch(array('email' => $detailemail['email'], 'status'=> $model->status, 'data' => $detailemail));

            return $result;
        } else {
            return ['message' => 'Already updated'];
        }
        
    }

    /**
     * function ini digunakan untuk menerima callback dari xendit dengan payment_type bank virtual account.
     * 
     * Untuk proses didalamnya sama seperti di ewallet, yang membedakan adalah nama parameter yang dikirim dari payloadnya
     */
    public function callbackva(array $data)
    {
        if (isset($data['transaction_timestamp'])) {
            $order_id = $data['external_id'];
        
            $chek_temp = DB::table('payment_temp')
                    ->where('order_id', $order_id)
                    ->first();
    
            if ($chek_temp) {
    
                $gettmp = json_decode($chek_temp->data, TRUE);
                $tmp = array_merge(
                    $gettmp["data"],[
                    'result' => $gettmp["result"],
                    'order_id' => $chek_temp->order_id
                ]);
                $this->paymentchargenew($tmp);
            }
            
            $model = $this->modelInvoice->where("order_id", $order_id)->first();
            $support = $this->modelSupport->where("invoice_id", $model->id)->first();
            
            if ($model->status != 'COMPLETED') {
                $model->date_paid = date("Y-m-d H:i:s", strtotime(strtok($data['transaction_timestamp'], '.')));
                $date_active = new \DateTime(date("Y-m-d H:i:s", strtotime(strtok($data['transaction_timestamp'], '.'))));
                $date_active->modify('+3 day');
                $model->status = "COMPLETED";
                $model->date_active = $date_active;
                $support->status = 1;
                if ($support->content_id != null) {
                    ContentSubscribeService::getInstance()->update(array('content_id' => $support->content_id, 'supporter_id' => $support->supporter_id, 'created' => $data['created'], 'email' => $support->email, 'order_id' => $order_id));
                }
                $modelUserBalance = $this->modelUserBalance->where("user_id", $support['creator_id'])->first();
                $modelUserBalance->pending = $modelUserBalance->pending + $model['creator_amount'];
                // \dd($modelUserBalance);
                $modelUserBalance->save();
                $support->save();
                $result = $model->save();
                
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
                    } catch (\Throwable $th) {
                        // throw $th;
                    }
                }

                $detailemail = SupportService::getInstance()->getbyOrderid($order_id);
                SendEmailInvoiceJob::dispatch(array('email' => $detailemail['email'], 'data' => $detailemail));

                return $result;
            } else {
                return ['message' => 'Already updated'];
            }
            
            
        }
        
    }

    /**
     * check nilai balance dari dashboard xendit
     */
    public function check_balance()
    {
        $getBalance = \Xendit\Balance::getBalance('CASH');
        return $getBalance;
    }
}
