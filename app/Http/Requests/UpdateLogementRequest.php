<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLogementRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
 return [
        'title' => 'required|string|max:255',
        'type' => 'required|string|max:100',
        'price' => 'required|numeric|min:0',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'bathrooms' => 'required|integer|min:0',
        'bedrooms' => 'required|integer|min:0',
        'status' => 'required|in:available,reserved,rented,sold',
        'description' => 'nullable|string',
        'phone' => 'required|string|max:20',
        'surface' => 'required|numeric|min:0',
    ];
    }
}
