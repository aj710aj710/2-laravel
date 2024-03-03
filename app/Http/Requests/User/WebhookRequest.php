<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'webhook_name' => ['required', Rule::unique('webhooks')->ignore($this->id)->whereNull('deleted_at')],
            'product_id'   => 'required',
            'plan_id' => 'required',
            'webhook_url' => 'required',
        ];
        return $rules;
    }
}
