<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfilService;
use App\Models\Profil;

class ProfilController extends Controller
{
    protected $profilService;
    
    // Injection du service
    public function __construct(ProfilService $profilService)
    {
        $this->profilService = $profilService;
    }

    public function create(Request $request) 
    {
        try {
            $profil = $this->profilService->create($request->all());

            return response()->json([
                'message' => 'Profil créé avec succès',
                'profil' => $profil
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function show() 
    {
        $profils = Profil::where('status', 'actif');

        if (!auth()->check()) {
            $profils->each(function($profil) {
                $profil->makeHidden(['status']);
            });
        }

        return response()->json($profils->get());
    }

    public function update(Request $request, $profil_id) 
    {
        try {
            $profil = $this->profilService->update($request->all(), $profil_id);

            return response()->json([
                'message' => 'Profil modifié avec succès',
                'profil' => $profil
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function destroy($profil_id)
    {
        try {
            $this->profilService->delete($profil_id);

            return response()->json([
                'message' => 'Profil supprimé avec succès'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }
}
