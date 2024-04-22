<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Passager;
use App\Http\Requests\CreatePassagerRequest; 
use App\Http\Requests\EditPassagerRequest;  
use App\Http\Requests\LogPassagerRequest;  
use Illuminate\Foundation\Auth\AuthenticatesUsers; // Importez le trait AuthenticatesUsers
use Exception;

class PassagerController extends Controller
{

    use AuthenticatesUsers;

    public function register(CreatePassagerRequest $request){
        try {
            // Créez une nouvelle instance de Passager
            $passager = new Passager();
    
            // Attribuez les valeurs des champs du passager à partir des données de la requête
            $passager->nom = $request->nom;
            $passager->prenom = $request->prenom;
            $passager->email = $request->email;
            $passager->telephone = $request->telephone;
            $passager->date_de_naissance = $request->date_de_naissance;
            $passager->numero_de_CNI = $request->numero_de_CNI;
            $passager->sexe = $request->sexe;
    
            // Hasher le mot de passe
            $passager->mot_de_passe = Hash::make($request->mot_de_passe);
    
            // Enregistrez le passager dans la base de données
            $passager->save();
    
            // Créez un message de réussite
            $nomComplet = $passager->nom . ' ' . $passager->prenom;
            $message = 'Le passager ' . $nomComplet . ' a été ajouté';
    
            // Retournez une réponse JSON avec le statut de succès, le message et les données du passager
            return response()->json([
                'status_code' => 200,
                'status_message' => $message,
                'data' => $passager
            ]);
        } catch(Exception $e) {
            // En cas d'erreur, retournez une réponse JSON avec les détails de l'erreur
            return response()->json($e);
        }
    }
         
    public function login(LogPassagerRequest $request){

        $credentials = $request->only(['email', 'telephone', 'mot_de_passe']);
    
        $passager = Passager::where('email', $credentials['email'])
                            ->orWhere('telephone', $credentials['telephone'])
                            ->first();
    
        if($passager && Hash::check($credentials['mot_de_passe'], $passager->mot_de_passe)){
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
        
        /*if(auth()->attempt($request->only(['email', 'mot_de_passe']))){
            $passager = auth()->passager();
            dd($passager);
        }else{
            return response()->json([
                'status_code' => 403,
                'status_message' => 'INformation non valide',
            ]);
        }*/
    }

    public function update(EditPassagerRequest $request, Passager $passager){

        
        try{

            $passager->nom = $request->nom;
            $passager->prenom = $request->prenom;
            $passager->email = $request->email;
            $passager->telephone = $request->telephone;
            $passager->date_de_naissance = $request->date_de_naissance;
            $passager->numero_de_CNI = $request->numero_de_CNI;
            $passager->sexe = $request->sexe;
            $passager->mot_de_passe = Hash::make($request->mot_de_passe, [
                'rounds' => 12
            ]);
            $passager->save();

            $nomComplet = $passager->nom . ' ' . $passager->prenom;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le passager ' . $nomComplet . 'a été modifié',
                'data' => $passager
            ]);

        }catch(Exception $e){

            return response()->json($e);
        }

    }

    public function delete(Passager $passager){

        try{
            $nomComplet = $passager->nom . ' ' . $passager->prenom;
            
            $passager->delete();

            return response()->json([
                
                'status_code' => 200,
                'status_message' => 'Le passager ' . $nomComplet . ' a été supprimé',
                'data' => $passager
            ]);
        }catch(Exception $e){
            
            return response()->json($e);
        }
    }

    public function logout(Passager $passager){
        $this->guard()->logout(); // Utilisez la méthode logout() fournie par le trait AuthenticatesUsers
        $passager->session()->invalidate();

        return response()->json([
            'message' => 'Vous êtes déconnecté avec succès.',
        ]);
    }

    public function show(Passager $passager){
        try {
            // Récupérer les données du passager à partir de l'objet $passager
            $passagerData = $passager;
            
            // Retourner les données du passager sous forme de réponse JSON avec le code d'état 200
            return response()->json([
                'status_code' => 200,
                'data' => $passagerData
            ]);
        } catch(Exception $e) {
            // En cas d'erreur, retourner une réponse JSON avec les détails de l'erreur
            return response()->json($e);
        }
    }
    
}