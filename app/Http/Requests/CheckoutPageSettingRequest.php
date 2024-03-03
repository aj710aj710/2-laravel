<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutPageSettingRequest extends FormRequest
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
        $rules = [
            'step' => 'required'
        ];
        $rules = [
            'image' => 'nullable|mimes:png,jpg',
            'title' => 'required_if:step,1|max:100|string',
            'text_size' => 'nullable|max:100|string',
            'text_color' => 'nullable|max:100|string',
            'basic.type.*' => 'required_if:step,2|string',
            'basic.label.*' => 'required_if:step,2|string',
            'basic.placeholder.*' => 'required_if:step,2|string',
            'billing.type.*' => 'required_if:step,3|string',
            'billing.label.*' => 'required_if:step,3|string',
            'billing.placeholder.*' => 'required_if:step,3|string',
            'shipping.type.*' => 'required_if:step,4|string',
            'shipping.label.*' => 'required_if:step,4|string',
            'shipping.placeholder.*' => 'required_if:step,4|string',
            'gateways.*' => 'required_if:step,5',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'basic.type.*' => 'The type field is required.',
            'basic.label.*' => 'The label field is required.',
            'basic.placeholder.*' => 'The placeholder field is required.',
            'billing.type.*' => 'The type field is required.',
            'billing.label.*' => 'The label field is required.',
            'billing.placeholder.*' => 'The placeholder field is required.',
            'shipping.type.*' => 'The type field is required.',
            'shipping.label.*' => 'The label field is required.',
            'shipping.placeholder.*' => 'The placeholder field is required.',
        ];
    }
}
