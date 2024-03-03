<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            'name' => 'required|unique:packages,name,' . $this->id,
            'customer_limit_type' => 'required|integer',
            'customer_limit' => 'required_if:customer_limit_type,1|integer',
            'product_limit_type' => 'required|integer',
            'product_limit' => 'required_if:product_limit_type,1|integer',
            'subscription_limit_type' => 'required|integer',
            'subscription_limit' => 'required_if:subscription_limit_type,1|integer',
            'monthly_price' => 'required|numeric',
            'yearly_price' => 'required|numeric',
            'icon' => 'nullable|mimes:png,jpg,jpeg'
        ];
    }
}
