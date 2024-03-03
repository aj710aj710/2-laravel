<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LicenseRequest extends FormRequest
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
                "name" => 'bail|required|string|max:255|unique:licenses,name,' . decrypt($this->id) . ',id,deleted_at,NULL',
                "code" => 'bail|required|unique:licenses,code,' . decrypt($this->id) . ',id,deleted_at,NULL',
                "status" => 'bail|required',
                "product_plan" => 'bail|required',
            ];
        } else {
            $rules = [
                "name" => 'bail|required|string|max:255|unique:licenses,name,NULL,id,deleted_at,NULL',
                "code" => 'bail|required|unique:licenses,code,NULL,id,deleted_at,NULL',
                "status" => 'bail|required',
                "product_plan" => 'bail|required',
            ];
        }

        return $rules;
    }
}
