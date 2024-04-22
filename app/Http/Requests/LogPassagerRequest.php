<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LogPassagerRequest extends FormRequest
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
            'email' => 'required|email|exists:passagers,email',
            'mot_de_passe' => 'required',
        ];
    }

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(response()->json([
            'success' => false,
            'status_code' => 422,
            'error' => true,
            'message' => 'Erreur de validation',
            'errorList' => $validator->errors()
        ]));
    }

    public function messages(){

        return [
            'email.required' => 'Email ou numero de telephone non fourni',
            'telephone.required' => 'Email ou numero de telephone non fourni',
            'email.required' => 'Email ou numero de telephone non fourni',
            'mot_de_passe.required' => 'Mot de passse non fourni',
            'email.email' => 'Adresse email ou numero de telephone non valide',
            'email.exists' => 'Cette adresse email ou ce numero de telephone n\'existe pas',
            'telephone.exists' => 'Cette adresse email ou ce numero de telephone n\'existe pas',
            'mot_de_passe.exists' => 'Mot de passe incorrect',
        ];
    }
}
