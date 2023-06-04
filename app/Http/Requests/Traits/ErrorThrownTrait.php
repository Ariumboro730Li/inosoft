<?php

namespace App\Http\Requests\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;

trait ErrorThrownTrait {

    public function failedValidation(Validator $validator)
    {
        // Log::channel('validation')->error($validator->errors());
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 400));
    }
}
