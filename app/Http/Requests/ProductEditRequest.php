<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
            'description' => 'string',
            'purchase_price' => 'numeric',
            'rent_price' => 'numeric',
            'rent_option' => 'in:hour,day,month,year',
        ];
    }
}
