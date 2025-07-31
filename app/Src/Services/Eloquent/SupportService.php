<?php

namespace App\Src\Services\Eloquent;

use App\Models\Invoice;
use App\Models\Support;
use App\Src\Base\IBaseService;
use App\Src\Helpers\Utils;
use App\Src\Jobs\SendEmailInvoiceJob;
use App\Src\Services\JCrowe\FilterWord;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use App\Src\Exceptions\NotFoundException;

class SupportService implements IBaseService{
    
    protected $model;
    protected $modelInvoice;

    public function __construct(Support $model, Invoice $modelInvoice) {
        $this->model = $model;
        $this->modelInvoice = $modelInvoice;
    }

    public static function getInstance()
    {
        return new static(new Support(), new Invoice());
    }


    public function getbyuserid(int $userid, array $params) {
        $model = $this->model->select("id","creator_id", "name", "email", "message", "created_at")
                ->where("creator_id", $userid)
                ->with("details");
                if (isset($params['from_date']) && isset($params['to_date'])) {
                    $model->whereDate('created_at', '>=', $params['from_date']);
                    $model->whereDate('created_at', '<=', $params['to_date']);
                }else{
                    $model->whereMonth('created_at', now()->month);
                }
                $model->get();
        return $model;
    }

    public function getbyOrderid($order_id)
    {
        // $model = $this->model->select("id", "name", "email", "message", "status", "created_at")
        //         ->where("id", $id)
        //         ->with("details")
        //         ->first();
        // return $model;
        $query = $this->modelInvoice
                    ->select('id','order_id', 'payment_type', 'status', 'date_paid', 'due_date', 'user_id', 'email')
                    ->where("order_id", $order_id)
                    ->first();
        $check_temp_table = DB::table('payment_temp')
                                ->where('order_id', $order_id)
                                ->first();
                    if (!$query && $check_temp_table) {
                        return "Yout payment is processed, please check your email.";
                    }elseif (!$query && !$check_temp_table) {
                        throw new NotFoundException("Not Found", []);
                        
                    }
                   $support = $query->support;
                   //dd($support);
                   $page = PageService::getInstance()->getByUserId($support->creator_id);

                $email=preg_replace('/(?<=..).(?=..*@)/', '*', $support->email);
                $email=preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=.(?:[.]|$))/', '*', $email);
                   $items = [];
                   $totalsupport = 0;
                   foreach ($support->details as $key) {
                       $item = ItemService::getInstance()->getDetail($key->item_id);
                       $items[] = array(
                           "item" => $item['name'],
                           "price" => Utils::toIDR($key->price),
                           "qty" => $key->qty,
                           "total" => Utils::toIDR($key->total)
                       );
                       $totalsupport = $totalsupport + $key->total;
                   }
                $result = [
                    "order_id" => $query->order_id,
                    // "payment_status" => $query->status,
                    "status" => $support->status,
                    "due_date" => $query->due_date ? $query->due_date->format(Utils::defaultDateTimeFormat()) : null ,
                    "order_time" => $support->created_at->format(Utils::defaultDateTimeFormat()),
                    "payment_method" => $query->payment_type,
                    "creator_name" =>  $page['name'],
                    "creator_id" => $page['user_id'],
                    "creator_email" => $support->creator->email,
                    "page_url" => $page['page_url'],
                    "email" => $support->email,
                    'name' => $support->name,
                    "date_paid" => $query['date_paid'] ? $query['date_paid']->format(Utils::defaultDateTimeFormat()):null,
                    "items" => $items,
                    "total" => Utils::toIDR($totalsupport)
                ];

                $ceksupport =  $query->support->content->subscribe ?? null;
                if ($support->content_id) {
                    $ceksupport = $ceksupport->where('order_id', $query->order_id);
                    // if ($query->user_id) {
                    //     $ceksupport = $ceksupport->where('user_id', $query->user_id);
                    // }else{
                    //     $ceksupport->where('email', $query->email);
                    // }
                    // dd($ceksupport->all());
                    $ceksupport = $ceksupport->first();
                        $result['content_name'] = $ceksupport->content->title;
                        $result['start'] = Utils::formatDate($ceksupport->start, true);
                        $result['end'] = Utils::formatDate($ceksupport->end, true);
                    // dd($result);
                }

                if ($query->status == "settlement" || $query->status == "SUCCEEDED" || $query->status == "completed" || $query->status == "COMPLETED") {
                    $result['payment_status'] = 'Success';
                }else{
                    $result['payment_status'] = ucwords(strtolower($query->status));
                }

        return $result;
    }

    public function historypage(int $userid)
    {
        $setting = SettingService::getInstance();
        $customBadWords = [];
        $filterBySystem = $setting->get("profanity_by_system", null, $userid);
        if (!$filterBySystem) {
            $customBadWords = $setting->get("profanity_custom_filter", null, $userid);
            $customBadWords = array_map('trim', explode(";", $customBadWords));
        }
        $supportsQ = Support::select("id", "creator_id", "supporter_id", "name", "message", "email", "status", "created_at")
        ->where("creator_id", $userid)
            ->paidSuccess()
            ->with([
                'supporter' => function ($q) {
                    $q->select("id", "name", "username", "email");
                },
                'details' => function ($q) {
                    $q->select("id", "support_id", "item_id", "price", "qty", "total");
                },
                'details.item' => function ($q) {
                    $q->select("id", "name");
                },
            ])
            ->latest()
            ->paginate(10);
            $meta_data = [
                "current_page" => $supportsQ->currentPage(),
                "last_page" =>  $supportsQ->lastPage(),
                "per_page" => $supportsQ->perPage(),
                "total_page" => $supportsQ->total(),
                "next_page_url" => $supportsQ->nextPageUrl(),
                "links" => $supportsQ->render(),
            ];

        if ($supportsQ) {
            $newTip = [];
            $templateMessage = __("message.default_page_support_message");
            foreach ($supportsQ as $a) {
                $items = [];
                $amount = 0;
                foreach ($a->details as $key => $detail) {

                    $items[] = $detail->qty.' '. ($detail->item->name ?? "Item");

                    $amount += $detail->total;
                }

                $newTip[] = [
                    "support" => str_replace(["{supporter}", "{items}"], [$a->name ?? __("message.people"), implode(__("message.conjunction"), $items)], $templateMessage),
                    "message" => FilterWord::getInstance()->filter($a->message, $customBadWords, $filterBySystem),
                    'date' => $a->created_at->diffForHumans()
                ];
            }
            return ["data" => $newTip, "pagging" => $meta_data];
        }else{
            return "You not have any supports";
        }
    }

    public function amountpermonth(int $creator_id)
    {
        $model = $this->model
                    ->where('creator_id', $creator_id)
                    ->where('status', 1)
                    ->whereMonth('created_at', date('m'))
                    ->get()
                    ->map(function($model) {
                        return $model->invoice()
                        ->sum('creator_amount');
                    })->toArray();
                    
        return array_sum($model);
    }

    public function totalsupport(int $creator_id = null)
    {
        $model = $this->model;
                    if (isset($creator_id)) {
                        $model = $model->where('creator_id', $creator_id);
                    }
                    $model = $model->where('status', 1)
                    ->get()
                    ->count();
                    // dd($model);
        return $model;
    }

    public function total_support_today($params = null)
    {
        $model = $this->model;
                    if (isset($params['today'])) {
                        $model = $model->whereDate('created_at', $params['today']);
                    }
                    $model = $model->where('status', 1)
                    ->get()
                    ->count();
                    // dd($model);
        return $model;
    }

    public function updateexpiredpayment()
    {
        $check = $this->modelInvoice
                        ->whereNull('date_paid')
                        ->whereRaw('LOWER(status) = ?', ['pending'])
                        ->where(Invoice::raw("(DATE_FORMAT(due_date,'%Y-%m-%d %H:%i'))"), '<=', now()->format('Y-m-d H:i'))
                        ->get();
                        
        foreach ($check as $a) {
            $invoice = $this->modelInvoice->where('id', $a->id)->first();
            $invoice->status = 'Expired';
            $invoice->date_canceled = now()->format('Y-m-d H:i:s');
            $invoice->save();

            try {
                $detailemail = $this->getbyOrderid($invoice->order_id);
                SendEmailInvoiceJob::dispatch(array('email' => $invoice->email,'status'=> 'Expired', 'data' => $detailemail));
            } catch (\Throwable $ex) {
                activity()
                    ->inLog('updateexpiredpayment')
                    ->withProperties(['attributes' => [
                        "class" => SupportService::class,
                        "function" => 'updateexpiredpayment',
                        "error" => $ex->getCode(),
                        "message" => $ex->getMessage(),
                        "trace" => strtok($ex->getTraceAsString(), '#1')
                    ]])
                    ->log('SendEmailInvoiceJob: ' .$ex->getMessage());
            }

        }
    }

    public function getPageData($params, $type = 'creator_page') // $type = creator_page or support_page
    {
        $pages = PageService::getInstance()->getPage($params["page_name"], $params["supporter_id"]);
        $userid = $pages['user_id'];

        /* get user profile */
        $userProfile = $params["supporter_id"] ? UserService::getInstance()->show($params["supporter_id"]) : null;
        
        /* get sosial */
        $social_links = SocialLinkService::getInstance()->getSocialLink($userid);

        /* get user item */
        $item = ItemService::getInstance()->getActiveItems($userid);

        /* get payment method */
        $paymentMethod = PaymentMethodService::getInstance()->getList();

        /* get user content */
        $userContent = ContentService::getInstance()->getContents($userid);
        
        // Media share setting this can be null at first time. 
        // or if not null please check the status field 0 or 1
        $mediaShare = SettingService::getInstance()->get('media_share', null, $userid);

        /* Get Creator Goal */
        $goalService = GoalService::getInstance();
        $creatorGoal = $goalService->getActiveGoals($userid);
        if ($creatorGoal) {
            if ($creatorGoal['visibility'] != 2) {      // != Private
                $creatorGoal = [
                    'goal' => $creatorGoal,
                    'goalProgress' => $goalService->getGoalProgress($creatorGoal["id"]),
                ];
            } else {
                $creatorGoal = [];
            }
        }

        $data = [
            "pageName" => $params["page_name"],
            "social_links" => $social_links['social_links'],
            "item"  => $item,
            "payment" => $paymentMethod,
            'page' => $pages,
            'user'  => $userProfile,
            'mediaShare' => $mediaShare,
            'supporter_id' => $params["supporter_id"],
            'creatorGoal' => $creatorGoal,
            'userContent' => $userContent,
        ];

        return $data;
    }

    public function formatResult($model)
    {
        return [
            "item_name" => $model->id

        ];
    }

    public function support_history(int $user_id, $status = null)
    {
        if ($status == 'success') {
            $where = "WHERE supporter_id = ". $user_id ." AND invoices.status = 'success' OR supporter_id = ". $user_id ." AND invoices.status = 'settlement' OR supporter_id = ". $user_id ." AND invoices.status = 'SUCCEEDED' OR supporter_id = ". $user_id ." AND invoices.status = 'completed' OR supporter_id = ". $user_id ." AND invoices.status = 'COMPLETED'";
        }else {
            $where = "WHERE supporter_id = ". $user_id ." AND invoices.status = '".$status."'";
        }
        DB::statement("SET sql_mode = '' ");
        $query = DB::select("SELECT supports.id, creator_id, supporter_id, invoices.gross_amount amount, invoices.order_id external_id, supports.created_at, invoices.status, message, payment_type FROM supports INNER JOIN invoices ON invoices.id = supports.invoice_id
                    $where
                    ORDER BY created_at DESC");

        return datatables()->of($query)
        ->addIndexColumn()
        ->addColumn('creator_name', function($row) {
            $page = PageService::getInstance()->getByUserId($row->creator_id);
            return $page['name'];
        })
        ->editColumn('status', function($row) {
            if ($row->status == "settlement" || $row->status == "SUCCEEDED" || $row->status == "completed" || $row->status == "COMPLETED") {
                $status = "Success";
            }else {
                $status = ucwords(strtolower($row->status));
            }
            return $status;
        })
        ->editColumn('created_at', function($row) {
            return Utils::formatDate($row->created_at, false);
        })
        ->editColumn('amount', function($row) {
            return Utils::toIDR($row->amount);
        })
        ->editColumn('message', function($row) {
            return $row->message ?? 'N/A';
        })
        ->addColumn('actions', function($row) {
            $page = PageService::getInstance()->getByUserId($row->creator_id);
            $actions = '<a href="'. route('support.payment_status', ['page_name' => $page['page_url'], 'orderID' => $row->external_id]) .'" target="_blank" class="btn btn-primary rounded-pill btn-sm d-none d-md-none d-lg-block w-100">Lihat Invoice</a>';
            $actions .= '<a href="'. route('support.payment_status', ['page_name' => $page['page_url'], 'orderID' => $row->external_id]) .'" target="_blank" class="btn btn-primary rounded-pill btn-sm d-block d-md-block d-lg-none w-100"><i class="fa fa-search"></i></a>';

            return $actions;
        })
        ->rawColumns(['actions','fee'])
        ->toJson();
    }

}
