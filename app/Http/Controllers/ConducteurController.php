<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Conducteur;
use App\Http\Requests\CreateConducteurRequest; 
use App\Http\Requests\EditConducteurRequest;
use App\Http\Requests\LogConducteurRequest;  
use Exception;

class ConducteurController extends Controller
{

    public function register(CreateConducteurRequest $request){

        try{
            $conducteur = new Conducteur();
    
            $conducteur->nom = $request->nom;
            $conducteur->prenom = $request->prenom;
            $conducteur->email = $request->email;
            $conducteur->telephone = $request->telephone;
            $conducteur->date_de_naissance = $request->date_de_naissance;
            $conducteur->numero_de_permis = $request->numero_de_permis;
            $conducteur->sexe = $request->sexe;
    
            // Hasher le mot de passe
            $conducteur->mot_de_passe = Hash::make($request->mot_de_passe);
    
            $conducteur->save();
    
            $nomComplet = $conducteur->nom . ' ' . $conducteur->prenom;
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le conducteur ' . $nomComplet . ' a été ajouté',
                'data' => $conducteur
            ]);
    
        }catch(Exception $e){
    
            return response()->json($e);
        }
    }

    public function login(LogConducteurRequest $request){

        $credentials = $request->only(['email', 'telephone', 'mot_de_passe']);
    
        $conducteur = Conducteur::where('email', $credentials['email'])
                                ->orWhere('telephone', $credentials['telephone'])
                                ->first();
    
        if($conducteur && Hash::check($credentials['mot_de_passe'], $conducteur->mot_de_passe)){
            // Les informations d'identification sont correctes, l'utilisateur est authentifié avec succès
            // Vous pouvez gérer la suite du processus d'authentification ici
            return "Authentification reussie";
        } else {
            // Si les informations ne correspondent à aucun utilisateur
            return response()->json([
                'status_code' => 403,
                'status_message' => 'Informations non valides'
            ]);
        }
    }
    
    public function update(EditConducteurRequest $request, Conducteur $conducteur){

        
        try{

            $conducteur->nom = $request->nom;
            $conducteur->prenom = $request->prenom;
            $conducteur->email = $request->email;
            $conducteur->telephone = $request->telephone;
            $conducteur->date_de_naissance = $request->date_de_naissance;
            $conducteur->numero_de_permis = $request->numero_de_permis;
            $conducteur->sexe = $request->sexe;
            $conducteur->mot_de_passe = Hash::make($request->mot_de_passe, [
                'rounds' => 12
            ]);
            $conducteur->save();

            $nomComplet = $conducteur->nom . ' ' . $conducteur->prenom;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le conducteur ' . $nomComplet . 'a été modifié',
                'data' => $conducteur
            ]);

        }catch(Exception $e){

            return response()->json($e);
        }

    }
    
    public function delete(Conducteur $conducteur){

        try{
            $nomComplet = $conducteur->nom . ' ' . $conducteur->prenom;
            
            $conducteur->delete();

            return response()->json([
                
                'status_code' => 200,
                'status_message' => 'Le conducteur ' . $nomComplet . ' a été supprimé',
                'data' => $conducteur
            ]);
        }catch(Exception $e){
            
            return response()->json($e);
        }
    }

    public function logout(Conducteur $conducteur){
        $this->guard()->logout(); // Utilisez la méthode logout() fournie par le trait AuthenticatesUsers
        $conducteur->session()->invalidate();

        return response()->json([
            'message' => 'Vous êtes déconnecté avec succès.',
        ]);
    }

    public function show(Conducteur $conducteur){
        try {
            // Récupérer les données du passager à partir de l'objet $passager
            $conducteurData = $conducteur;
            
            // Retourner les données du passager sous forme de réponse JSON avec le code d'état 200
            return response()->json([
                'status_code' => 200,
                'data' => $conducteurData
            ]);
        } catch(Exception $e) {
            // En cas d'erreur, retourner une réponse JSON avec les détails de l'erreur
            return response()->json($e);
        }
    }
}
