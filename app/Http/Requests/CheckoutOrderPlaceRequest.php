<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutOrderPlaceRequest extends FormRequest
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
            'gateway' => 'required|string',
            'currency' => 'required|string',
            'basic_first_name' => 'required',
            'basic_last_name' => 'required',
            'basic_email' => 'required|email',
            'basic_phone' => 'required',
            'checkout_details' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'basic_first_name' => 'The name field is required',
            'basic_last_name' => 'The name field is required',
            'basic_email' => 'The email field is required',
            'checkout_details' => __(SOMETHING_WENT_WRONG),
        ];
    }
}
