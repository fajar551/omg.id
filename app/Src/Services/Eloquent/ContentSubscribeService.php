<?php

namespace App\Src\Services\Eloquent;

use App\Models\ContentSubscribe;
use App\Models\Invoice;
use App\Models\Support;
use App\Src\Validators\ContentSubscribeValidator;

class ContentSubscribeService {

    protected $model;
    protected $modelInvoice;
    protected $modelSupport;
    protected $validator;

    public function __construct(ContentSubscribe $model, Invoice $modelInvoice, Support $modelSupport,  ContentSubscribeValidator $validator) {
        $this->model = $model;
        $this->modelInvoice = $modelInvoice;
        $this->modelSupport = $modelSupport;
        $this->validator = $validator;
    }

    public static function getInstance(){
        return new static(new ContentSubscribe(), new Invoice(), new Support(), new ContentSubscribeValidator());
    }

    public function store (array $data)
    {
        $this->validator->validateStore($data);
        $model = $this->model;
        if ($data['supporter_id']) {
            $model->user_id = $data['supporter_id'];
        } else {
            $model->email = $data['email'];
        }
        $model->content_id = $data["content_id"];
        $model->order_id = $data["order_id"];
        
        return $model->save();
    }

    public function update(array $data)
    {
        // dd(date("Y-m-d H:i:s", strtotime($data['created'])));
        // if ($data['supporter_id']) {
        //     $model = $this->model->where('order_id', $data['order_id'])->first();
        // } else {
            $model = $this->model->where('order_id', $data['order_id'])->first();
        // }
        
        $model->start = date("Y-m-d H:i:s", strtotime($data['created']));
        $end = new \DateTime(date("Y-m-d H:i:s", strtotime($data['created'])));
        $end->modify('+30 day');
        $model->end = $end;
        $model->status = 1;
        return $model->save();
    }

    public function updatestatus()
    {
        // TODO: Check this query if content subscribe has implemented 
        $check = $this->model
                        ->where('status', 1)
                        ->whereNotNull('end')
                        ->where(ContentSubscribe::raw("(DATE_FORMAT(end,'%Y-%m-%d %H:%i'))"), '<=', now()->format('Y-m-d H:i'))
                        ->update(['status' => 0]);

        // foreach ($check as $a) {
        //     $model = $this->model->where('id', $a->id)->first();
        //     $model->status = 0;
        //     $model->save();
        // }
    }

    /**
     * Check if any user have access to contents.
     *
     * @param int $user_id
     * @param int $content_id
     * @return void
     */
    public function checkaccess(int $user_id, int $content_id)
    {
        // TODO: Check this if user subscribe the content for more than one
        return $this->model->where([
            'user_id' => $user_id, 
            'content_id' => $content_id, 
            'status' => 1
        ])->first();
    }

    
    public function subscribeedlist(int $user_id, $limit = null)
    {
        // TODO: Check this if user subscribe the content for more than one
        $query = [];
        $no = 0;
        $content = $this->model->where([
            'user_id' => $user_id, 
            'status' => 1
        ])->latest()->paginate($limit ?? 10);
        $meta_data = [
            "current_page" => $content->currentPage(),
            "last_page" =>  $content->lastPage(),
            "per_page" => $content->perPage(),
            "total_page" => $content->total(),
            "next_page_url" => $content->nextPageUrl(),
            "links" => (string) $content->links(),
        ];
        foreach ($content as $key) {
                $page = PageService::getInstance()->getByUserId($key->user_id);
                $query[$no] = ContentService::getInstance()->getReturnedValue($key->content);
                $query[$no]['akses'] = 'Paid';
                $query[$no]['pageName'] = $page['page_url'];
            $no++;
        }
        return ['data' => $query, "pagging" => $meta_data];
    }

    public function validate(array $data)
    {
        return $this->validator->validateStore($data);
    }

    public function checkEmailGuest($email, $user_id)
    {
        $this->model->where('email', $email)->whereNull('user_id')->update(['user_id'=> $user_id]);
        $this->modelInvoice->where('email', $email)->whereNull('user_id')->update(['user_id'=> $user_id]);
        $this->modelSupport->where('email', $email)->whereNull('supporter_id')->update(['supporter_id'=> $user_id]);
    }
    
}
