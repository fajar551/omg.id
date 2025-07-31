<?php

namespace App\Src\Validators;

use Validator;

class ExploreValidator {

    /**
     * Validate query params.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateParam(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'nullable|numeric|exists:users,id',
            'category_id' => @$data['category_id'] > 0 ? 'numeric|required|exists:pages_categories,id' : 'numeric|required|in:0',
            'keywords' => 'nullable|string',
        ])->validate();
    }

}