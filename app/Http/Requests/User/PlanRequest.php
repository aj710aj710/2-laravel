<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
        if (isset($this->id)) {
            $rules = [
                "name" => 'bail|required|string|max:255|unique:plans,name,' . decrypt($this->id) . ',id,deleted_at,NULL',
                "code" => 'bail|required|unique:plans,code,' . decrypt($this->id) . ',id,deleted_at,NULL',
                "price" => 'bail|required',
                "due_day" => 'bail|required',
            ];
        } else {
            $rules = [
                "name" => 'bail|required|string|max:255|unique:plans,name,NULL,id,deleted_at,NULL',
                "code" => 'bail|required|unique:plans,code,NULL,id,deleted_at,NULL',
                "price" => 'bail|required',
                "due_day" => 'bail|required',
            ];
        }

        if ($this->billing_cycle == BILLING_CYCLE_AUTO_RENEW) {
            $rules = [
                "bill" => 'bail|required',
                "duration" => 'bail|required',
            ];
        } elseif ($this->billing_cycle == BILLING_CYCLE_EXPIRE_AFTER) {
            $rules = [
                "bill" => 'bail|required',
                "duration" => 'bail|required',
                "number_of_recurring_cycle" => 'bail|required',
            ];
        }

        return $rules;
    }
}
