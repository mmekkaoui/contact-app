<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "user.name" => 'required|string',
            "user.email" => 'required|email',
            "user.phone_numbers" => 'required|array',
            'user.phone_numbers.*.id' => 'required',
            'user.phone_numbers.*.phone_type_id' => 'required',
            'user.phone_numbers.*.phone_number' => 'required|string',
            "user.addresses" => 'required|array',
            'user.addresses.*.id' => 'required',
            'user.addresses.*.address_line' => 'required|string',
            'user.addresses.*.pincode' => 'required',
        ];
    }
}
