<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Contract;

class ContractRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'terms' => 'required|string',
            'status' => [ 'required',Rule::in(['new', 'in_progress' , 'terminated'])],
            'active' => 'boolean',
            'contractor_id' => 'required|string',
        ];
    }
}
