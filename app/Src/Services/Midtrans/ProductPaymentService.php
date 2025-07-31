<?php

namespace App\Src\Services\Midtrans;

use App\Models\Invoice;
use Midtrans\Snap;
use App\Models\Item;
use App\Models\Page;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use App\Src\Validators\PaymentValidator;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\SettingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductPaymentService extends Midtrans
{
    protected $modelItem;
    protected $modelPaymentMethod;
    protected $modelInvoice;
    protected $modelProduct;
    protected $validator;
    protected $modelPage;
    protected $modelUser;

    public function __construct(
        Item $modelItem, 
        PaymentMethod $modelPaymentMethod, 
        Invoice $modelInvoice, 
        Product $modelProduct,
        PaymentValidator $validator, 
        Page $modelPage, 
        User $modelUser
    ) {
        parent::__construct();
        $this->modelItem = $modelItem;
        $this->modelPaymentMethod = $modelPaymentMethod;
        $this->modelInvoice = $modelInvoice;
        $this->modelProduct = $modelProduct;
        $this->validator = $validator;
        $this->modelPage = $modelPage;
        $this->modelUser = $modelUser;
    }

    /**
     * Get Snap Token for Product Purchase
     */
    public function getProductSnapToken(array $data)
    {
        // Validate page URL
        $modelPage = $this->modelPage->where('page_url', $data['page_name'])->first();
        $modelUser = $this->modelUser->where('username', $data['page_name'])->first();

        $creator_id = $modelPage->user_id ?? $modelUser->id;
        $data['creator_id'] = $creator_id;
        
        // Use ProductPaymentValidator instead of PaymentValidator
        $productValidator = new \App\Src\Validators\ProductPaymentValidator();
        $productValidator->validateStore($data);

        // Get product details
        $product = $this->modelProduct->find($data['product_id']);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $gross_amount = $product->price * $data['quantity'];
        
        // Check maximum amount
        if ($gross_amount > 10000000) {
            return __("message.max_support");
        }

        // Generate order ID
        $order_id = 'PRODUCT-' . $creator_id . Str::random(10) . date('YmdHis');

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => (int) $gross_amount,
            ],
            'item_details' => [
                [
                    'id' => (string) $product->id,
                    'price' => (int) $product->price,
                    'quantity' => (int) $data['quantity'],
                    'name' => $product->name
                ]
            ],
            'customer_details' => [
                'first_name' => $data['buyer_name'],
                'email' => $data['buyer_email'],
                'address' => $data['buyer_address'] ?? '',
                'phone' => ''
            ],
            'enabled_payments' => [
                'credit_card', 'bca_va', 'bni_va', 'bri_va', 'mandiri_clickpay', 
                'cimb_clicks', 'bca_klikpay', 'bca_klikbca', 'bri_epay', 'echannel', 
                'permata_va', 'bca_va', 'bni_va', 'bri_va', 'other_va', 'gopay', 
                'indomaret', 'danamon_online', 'akulaku', 'shopeepay', 'kredivo'
            ]
        ];

        // Get Snap Token from Midtrans
        $snapToken = Snap::getSnapToken($params);
        $result = [
            'token' => $snapToken,
            'param' => $data
        ];

        unset($data['creator_id']);

        // Store temporary data
        DB::table('payment_temp')->insert([
            'order_id' => $order_id,
            'data' => json_encode($data)
        ]);

        return $result;
    }

    /**
     * Process Product Payment
     */
    public function processProductPayment(array $data)
    {
        // Check if invoice already exists
        if (!empty($this->modelInvoice->where("order_id", $data['snapresponse']['order_id'])->first())) {
            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
            ]);
        }

        if ($data['snapresponse']['status_code'] != 201 && $data['snapresponse']['status_code'] != 200) {
            return 'Failed create invoice!';
        }

        $settingService = SettingService::getInstance();
        $platform_fee = $settingService->get('platform_fee');

        // Calculate payment gateway fee
        if ($data['snapresponse']['payment_type'] == 'bank_transfer') {
            $pg_fee = $settingService->get('bank_transfer');
            $pg_amount = round($pg_fee + ($pg_fee * ($settingService->get('ppn') / 100)));
        } elseif ($data['snapresponse']['payment_type'] == 'credit_card') {
            $pg_fee = $settingService->get('cc_percent') . '% + ' . $settingService->get('cc_rp');
            $cc_percent = $settingService->get('cc_percent');
            $pg_amount = round((((float) $data['snapresponse']['gross_amount'] * (float) $cc_percent) / 100) + $settingService->get('cc_rp') + ((($data['snapresponse']['gross_amount'] * ($cc_percent / 100)) + $settingService->get('cc_rp')) * ($settingService->get('ppn') / 100)));
        } else {
            $pg_fee = $settingService->get($data['snapresponse']['payment_type']);
            $pg_amount = round((((float) $data['snapresponse']['gross_amount'] * (float) $pg_fee) / 100) + (($data['snapresponse']['gross_amount'] * ($pg_fee / 100)) * ($settingService->get('ppn') / 100)));
        }

        // Get creator ID
        $modelPage = $this->modelPage->where('page_url', $data['page_name'])->first();
        $modelUser = $this->modelUser->where('username', $data['page_name'])->first();
        $creator_id = $modelPage->user_id ?? $modelUser->id;

        // Create invoice
        $model = $this->modelInvoice;
        $model->transaction_id = $data['snapresponse']['transaction_id'];
        $model->order_id = $data['snapresponse']['order_id'];
        $model->user_id = null; // No user authentication required for product payment
        $model->gross_amount = (double) $data['snapresponse']['gross_amount'];
        $model->pg_fee = $pg_fee;
        $model->pg_amount = $pg_amount;
        $model->platform_fee = $platform_fee;
        $platform_amount = ((double) $data['snapresponse']['gross_amount'] * (double) $platform_fee) / 100;
        $model->platform_amount = $platform_amount;
        $model->creator_amount = (double) $data['snapresponse']['gross_amount'] - $pg_amount - $platform_amount;
        $model->email = $data['buyer_email'];
        $model->type = 1; // Product purchase type
        $model->notes = $data['buyer_message'] ?? 'Product Purchase';
        $model->payment_method_id = $data['payment_method_id'];
        $due_date = new \DateTime(date("Y-m-d H:i:s"));
        $due_date->modify('+1 hour');
        $model->due_date = $due_date;
        $model->status = $data['snapresponse']['transaction_status'];
        $model->payment_type = $data['snapresponse']['payment_type'];

        // Set payment information
        if (isset($data['snapresponse']['permata_va_number'])) {
            $model->information_id = $data['snapresponse']['permata_va_number'];
        } else if (isset($data['snapresponse']['bill_key'])) {
            $model->information_id = $data['snapresponse']['bill_key'];
        } else if (isset($data['snapresponse']['va_numbers'][0]['va_number'])) {
            $model->information_id = $data['snapresponse']['va_numbers'][0]['va_number'];
        }

        $model->save();

        // Delete temporary data
        $check_temp = DB::table('payment_temp')
            ->where('order_id', $data['snapresponse']['order_id'])
            ->first();
        if ($check_temp) {
            DB::table('payment_temp')->where('order_id', $data['snapresponse']['order_id'])->delete();
        }

        return ApiResponse::success([
            "message" => __("message.retrieve_success"),
        ]);
    }

    /**
     * Handle Product Payment Callback
     */
    public function handleProductCallback(array $data)
    {
        $order_id = $data['order_id'];

        $check_temp = DB::table('payment_temp')
            ->where('order_id', $order_id)
            ->first();

        if ($check_temp) {
            $snapresponse = [
                'payment_type' => $data['payment_type'],
                'gross_amount' => $data['gross_amount'],
                'status_code' => $data['status_code'],
                'transaction_id' => $data['transaction_id'],
                'order_id' => $data['order_id'],
                'transaction_status' => $data['transaction_status']
            ];

            $tmp = array_merge(['snapresponse' => $snapresponse], json_decode($check_temp->data, TRUE));
            $this->processProductPayment($tmp);
        }

        // Update existing invoice if needed
        $model = $this->modelInvoice->where("order_id", $order_id)->first();
        if ($model && $model->status != 'Success') {
            $model->status = $data['transaction_status'];
            if ($data['transaction_status'] == "settlement" || $data['transaction_status'] == "capture") {
                $model->status = "Success";
                $model->date_paid = $data['settlement_time'] ?? $data['transaction_time'];
                $model->save();
            }
        }

        return ['message' => 'Product payment processed successfully'];
    }
} 