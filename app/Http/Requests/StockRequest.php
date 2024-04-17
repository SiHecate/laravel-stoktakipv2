<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'unit_price' => ['required', 'numeric', 'min:0'], // Ürün birim fiyatı
            'description' => ['nullable', 'string'], // Ürün açıklaması (isteğe bağlı)
            'expiry_date' => ['nullable', 'date'], // Ürün son kullanma tarihi (isteğe bağlı)
        ];

    }
}
