<?php

namespace App\Services;

use App\Models\Profil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProfilService
{
    /**
     * Créer un profil
     * 
     * @param array $data
     * @return Profil
     */
    public function create(array $data)
    {
        $this->validateData($data);
        
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        
        $profil = [
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'user_id' => $user->id,
            'image' => isset($data['image']) ? $data['image']->store('images', 'public') : 'default.png',
            'status' => $data['status'],
        ];

        // Créer le profil dans la base de données
        $response = Profil::create($profil);

        return $response;
    }

    public function update(array $data, $profil_id)
    {
        $this->validateData($data);

        $profil = Profil::findOrFail($profil_id);
        $profil->update([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'image' => isset($data['image']) ? $data['image']->store('images', 'public') : $profil->image,
            'status' => $data['status']
           
        ]);
        return $profil;

    }

    public function delete($profil_id)
    {
        $profil = Profil::findOrFail($profil_id);
        $profil->delete();
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
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:inactif,en attente,actif',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}