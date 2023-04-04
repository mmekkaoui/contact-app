<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "user.name" => 'required|string',
            "user.email" => 'required|email',
            "user.phone_numbers" => 'required|array',
            'user.phone_numbers.*.phone_type_id' => 'required',
            'user.phone_numbers.*.phone_number' => 'required|string',
            "user.addresses" => 'required|array',
            'user.addresses.*.address_line' => 'required|string',
            'user.addresses.*.pincode' => 'required',
        ];
    }
}
