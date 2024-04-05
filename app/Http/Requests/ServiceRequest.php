<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pmo' => 'required',
            'account_manager' => 'required',
            'short_code' => 'required',
            'subkeyword' => 'required',
            'servicename' => 'required',
            'operator' => 'required',
            'company' => 'required',
            'country' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'country.required' => '*Please select country ',
            'company.required' => '*Please select company ',
            'operator.required' => '*Please select operator ',
            'servicename.required' => '*Please enter service name ',
            'subkeyword.required' => '*Please enter subkeyword ',
            'short_code.required' => '*Please enter short code ',

            'account_manager.required' => '*Please select account manager ',
            'pmo.required' => '*Please select PMO ',
        ];
    }
}
