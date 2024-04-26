<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Http\Requests\StoreContenuRequest;
use App\Http\Requests\UpdateContenuRequest;
use Illuminate\Http\Request;

class ContenuController extends Controller
{

    /*public function createContenu(Request $request)
{
    try {
        // Validation des données
        $validatedData = $request->validate([
            'nom_contenu' => 'required|string',
            'type_contenu' => 'required|string|in:texte,image,video,lien',
            'texte' => 'nullable|string', // Le texte est facultatif
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // L'image est facultative
            'video' => 'nullable|mimetypes:video/mp4|max:20000', // La vidéo est facultative
            'lien' => 'nullable|url', // Le lien est facultatif
        ]);

        // Vérifier si au moins un contenu est saisi
        if (empty($validatedData['texte']) && !$request->hasFile('image') && !$request->hasFile('video') && empty($validatedData['lien'])) {
            throw new \Exception("Vous devez saisir au moins un contenu.");
        }

        // Création d'un nouveau contenu
        $contenu = new Contenu();
        $contenu->nom_contenu = $validatedData['nom_contenu'];
        $contenu->type_contenu = $validatedData['type_contenu'];

        // Stockage du contenu en fonction du type
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images');
            $contenu->image_path = $imagePath;
        } elseif ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos');
            $contenu->video_path = $videoPath;
        } elseif (!empty($validatedData['lien'])) {
            $contenu->lien = $validatedData['lien'];
        } else {
            $contenu->texte = $validatedData['texte'] ?? '';
        }

        // Sauvegarde du contenu
        $contenu->save();

        return response()->json(['message' => 'Contenu créé avec succès'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erreur lors de la création du contenu', 'error' => $e->getMessage()], 500);
    }
}*/


    public function index()
    {
        //
    }

    public function show(Contenu $contenu)
    {
        //
    }


    public function destroy(Contenu $contenu)
    {
        //
    }
}