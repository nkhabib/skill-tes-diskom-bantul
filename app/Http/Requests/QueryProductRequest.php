<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QueryProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|numeric',
            'supplier_id' => 'nullable|numeric',
            'min_price' => 'nullable',
            'max_price' => 'nullable',
            'product_name' => 'nullable|max:250|string',
            'sort_by' => 'nullable|in:product_name,unit_price,units_in_stock',
            'limit' => 'nullable|numeric',
            'page' => 'nullable|numeric'
        ];
    }
}
