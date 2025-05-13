<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ItemRequest extends FormRequest
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
        if ($this->isMethod('put')) {
            $id = $this->route('item');
            return [
                'name' => 'required|string',
                'sku' => 'required|string|unique:items,sku,' . $id,
                'unit' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
            ];
        }
        return [
            'name' => 'required|string',
            'sku' => 'required|string|unique:items',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
