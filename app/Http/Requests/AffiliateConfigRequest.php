<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AffiliateConfigRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:affiliate_configs,title,' . $this->id,
            'product_ids' => 'required|array',
            'plan_ids' => 'required|array',
            'affiliate_ids' => 'required|array',
            'commission_type' => 'required|integer|in:1,2',
            'commission_amount' => 'required|numeric|min:0',
            'recurring_commission_type' => 'required|integer|in:1,2',
            'recurring_commission_amount' => 'required|numeric|min:0',
        ];
    }


    public function messages()
    {
        return [
            'product_ids' => 'The product field is required.',
            'plan_ids' => 'The plan field is required.',
            'affiliate_ids' => 'The affiliate field is required.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if ($this->header('accept') == "application/json") {
            $error = '';
            if ($validator->fails()) {
                $error = $validator->errors()->first();
            }
            return $this->validationErrorApi($validator, $error);
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
