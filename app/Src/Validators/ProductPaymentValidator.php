<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use Validator;

class ProductPaymentValidator {
    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'string|required|max:255',
            'email' => 'required|string|email|max:255',
            'buyer_name' => 'string|required|max:255',
            'buyer_email' => 'required|string|email|max:255',
            'buyer_address' => 'nullable|string|max:500',
            'buyer_message' => 'nullable|string|max:1000',
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
            'product_type' => 'required|string|in:buku,ebook,ecourse,digital',
            'page_name' => 'required|string|exists:pages,page_url',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
} 