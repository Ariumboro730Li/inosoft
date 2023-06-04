<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\MessageTrait;
use App\Http\Requests\Traits\ErrorThrownTrait;

class UserRequest extends FormRequest
{

    use ErrorThrownTrait, MessageTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            "limit" => "required|integer",
        ];
    }
}
