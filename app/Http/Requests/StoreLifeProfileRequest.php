<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLifeProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_type' => ['required', 'in:etudiant,famille,couple'],
            'budget_min' => ['nullable', 'numeric', 'min:0'],
            'budget_max' => ['nullable', 'numeric', 'min:0', 'gte:budget_min'],
            'location' => ['nullable', 'string', 'max:255'],
            'search_type' => ['required', 'in:location,achat'],
        ];
    }

     public function messages(): array
    {
        return [
            'profile_type.required' => 'Le type de profil est obligatoire.',
            'profile_type.in' => 'Le type de profil sélectionné est invalide.',

            'budget_min.numeric' => 'Le budget minimum doit être un nombre.',
            'budget_min.min' => 'Le budget minimum doit être supérieur ou égal à 0.',

            'budget_max.numeric' => 'Le budget maximum doit être un nombre.',
            'budget_max.min' => 'Le budget maximum doit être supérieur ou égal à 0.',
            'budget_max.gte' => 'Le budget maximum doit être supérieur ou égal au budget minimum.',

            'location.string' => 'La localisation doit être une chaîne de caractères.',
            'location.max' => 'La localisation ne doit pas dépasser 255 caractères.',

            'search_type.required' => 'Le type de recherche est obligatoire.',
            'search_type.in' => 'Le type de recherche doit être location ou achat.',
        ];
    }
}
