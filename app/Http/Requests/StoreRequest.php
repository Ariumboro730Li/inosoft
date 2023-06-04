<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\MessageTrait;
use App\Http\Requests\Traits\ErrorThrownTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use MessageTrait, ErrorThrownTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kendaraan_id' => 'required',
            'nama' => 'required',
            'jumlah' => 'required',
            'alamat' =>  'required',
        ];
    }

}
