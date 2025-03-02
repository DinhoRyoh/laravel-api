<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommentaireService;

class CommentaireController extends Controller
{
    protected $commentaireService;
    
    // Injection du service
    public function __construct(CommentaireService $commentaireService)
    {
        $this->commentaireService = $commentaireService;
    }

    public function create(Request $request, $profil_id) 
    {
        try {
            $commentaire = $this->commentaireService->create($request->all(), $profil_id);
            return response()->json([
                'message' => 'Commentaire créé avec succès',
                'Commentaire' => $commentaire
            ], 201);
        } catch (ValidationException $e) {
            // Retourne les erreurs de validation si elles existent
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }
}
