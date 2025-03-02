<?php

namespace App\Services;

use App\Models\Commentaire;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentaireService
{
    /**
     * Créer un Commentaire
     * 
     * @param array $data
     * @return Commentaire
     */
    public function create(array $data, $profil_id)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        $data['profil_id'] = $profil_id;
        $data['user_id'] = $user->id;
        $this->validateData($data);
        
        
        $Commentaire = [
            'content' => $data['content'],
            'profil_id' => $data['profil_id'],
            'user_id' => $data['user_id']
        ];

        // Créer le Commentaire dans la base de données
        $response = Commentaire::create($Commentaire);

        return $response;
    }

    /**
     * Valider les données
     * 
     * @param array $data
     * @throws ValidationException
     */
    private function validateData(array $data)
    {
        $validator = \Validator::make($data, [
            'content' => 'required|string',
            'profil_id' => 'required|exists:profils,id',
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attr, $value, $fail) use ($data)
                {
                    $exists = Commentaire::where('profil_id', $data['profil_id'])->where('user_id', $data['user_id'])->exists();
                    if($exists)
                        $fail('il existe déjà un commentaire de cet admin sur ce profil');
                }
            ]
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}