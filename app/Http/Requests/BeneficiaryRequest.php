<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeneficiaryRequest extends FormRequest
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
            "beneficiary_name" => ['required', 'string', 'max:191'],
            "type" => ['required'],
            "bank_name" => 'required_if:type,'.BENEFICIARY_BANK,
            "account_name" => 'required_if:type,'.BENEFICIARY_BANK,
            "bank_account_number" => 'required_if:type,'.BENEFICIARY_BANK,
            "bank_routing_number" => 'required_if:type,'.BENEFICIARY_BANK,
            "paypal_email" => 'required_if:type,'.BENEFICIARY_PAYPAL,
            "card_number" => 'required_if:type,'.BENEFICIARY_CARD,
            "card_holder_name" => 'required_if:type,'.BENEFICIARY_CARD,
            "expire_month" => 'required_if:type,'.BENEFICIARY_CARD,
            "expire_year" => 'required_if:type,'.BENEFICIARY_CARD,
        ];
        return $rules;
    }
}
