<?php

namespace App\Models\Customers\Requests;

use App\Models\Base\BaseFormRequest;

class RegisterCustomerRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required'],
            'username'  => ['required', 'unique:customers,username'],
            'email'     => ['required', 'unique:customers,email'],
            'password'  => ['required', 'string', 'min:5', 'confirmed'],
        ];
    }
}
