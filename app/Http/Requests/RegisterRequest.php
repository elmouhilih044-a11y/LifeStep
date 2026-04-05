<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:255'],

            'email' => ['required', 'email', 'unique:users,email'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'role' => ['required', 'in:user,owner'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.min' => 'Le nom doit comporter au moins :min caractères.',
            'name.max' => 'Le nom ne doit pas dépasser :max caractères.',

            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',

            'password.required' => 'Le mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit comporter au moins :min caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

            'role.required' => 'Le rôle est requis.',
            'role.in' => 'Le rôle doit être soit "user" soit "owner".',
        ];
    }
}
