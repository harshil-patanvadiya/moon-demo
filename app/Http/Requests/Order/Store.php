<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'customer_name' => 'required',
            'products' => 'required|array',
            'products.*.name' => 'required',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.amount' => 'required|numeric|min:1',
            'products.*.total' => 'required|numeric|min:1',
        ];
    }
}
