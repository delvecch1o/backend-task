<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description'  => 'required|string',
            'price'  => 'required|numeric',
            'paid' => 'boolean',
            'payment_date' => 'date',
            'contract_id' => 'required|string',
        ];
    }
}
