<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EditConducteurRequest extends FormRequest
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
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required|max:10|unique:conducteurs,telephone',
            'mot_de_passe' => 'required|min:8',
            'email' => 'unique:conducteurs,email',
            'date_de_naissance' => 'required|date',
            'numero_de_permis' => 'required',
            'sexe' => 'required',
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
            'nom.required' => 'Entrez votre nom',
            'prenom.required' => 'Entrez votre prenom',
            'telephone.required' => 'Entrez votre numero de telephone',
            'telephone.max' => 'Numero de telephone trop long',
            'telephone.unique' => 'Ce numero de telephone est deja utilisé',
            'email.unique' => 'Cette adresse mail est deja utilisée',
            'email.email' => 'Cette adresse email n\'est pas valable',
            'numero_de_permis.required' => 'Entrez numero de permis de conduire',
            'mot_de_passe.required' => 'Entrez un mot de passe',
            'mot_de_passe.min' => 'Mot de passe court',
            'sexe.required' => 'Entrez votre sexe ( masculin | feminin)',
            'date_de_naissance.required' => 'Entrez votre date de naissance',
            'date_de_naissance.date' => 'Date de naissance invalide,',
        ];
    }
}
