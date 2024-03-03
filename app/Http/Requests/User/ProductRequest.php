<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                "name" => 'bail|required|string|max:255|unique:products,name,' . decrypt($this->id) . ',id,deleted_at,NULL',
            ];
        } else {
            $rules = [
                "name" => 'bail|required|string|max:255|unique:products,name,NULL,id,deleted_at,NULL',
            ];
        }
        return $rules;
    }
}
