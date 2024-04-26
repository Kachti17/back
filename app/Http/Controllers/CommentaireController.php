<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Http\Requests\StoreCommentaireRequest;
use App\Http\Requests\UpdateCommentaireRequest;
use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class CommentaireController extends Controller
{

    public function commenterPublication(Request $request, $id)
    {
        try {
            // Récupérer l'utilisateur actuel
            $user = auth()->user();

            // Récupérer la publication spécifiée
            $publication = Publication::findOrFail($id);

            // Validation des données du commentaire
            $validatedData = $request->validate([
                'contenu_comm' => 'required|string|max:255', // Exemple de règle de validation pour le contenu du commentaire
            ]);

            // Création d'un nouveau commentaire
            $commentaire = new Commentaire();
            $commentaire->contenu_comm = $validatedData['contenu_comm'];
            $commentaire->user_id = $user->id;
            $commentaire->pub_id = $publication->id;
            $commentaire->date_comm = now();

            $commentaire->save();

            $publication->nbr_comm += 1; // Incrémenter le nombre de commentaires
            $publication->save();

            return response()->json(['message' => 'Commentaire ajouté avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'ajout du commentaire', 'error' => $e->getMessage()], 500);
        }
    }


    public function afficherCommentaires($postId)
{
    $post = Publication::where('id', $postId)->where('isApproved', 1)->first();

    if (!$post) {
        return response()->json(['message' => 'Post non trouvé ou non approuvé'], 404);
    }

    $commentaires = Commentaire::where('pub_id', $postId)->get();

    return response()->json([
        'commentaires' => $commentaires,
    ]);
}




public function editCommentaire(Request $request, $id)
{
    $validatedData = $request->validate([
        'contenu_comm' => 'required|string|max:255',
    ]);

    $commentaire = Commentaire::findOrFail($id);
    if ($commentaire->user_id !== Auth::id()) {
        return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire');
    }

    $commentaire->contenu_comm = $validatedData['contenu_comm'];

    $commentaire->save();

    $commentaire = Commentaire::findOrFail($id);


    return response()->json($commentaire);
}




public function deleteCommentaire($id)
{
    $commentaire = Commentaire::findOrFail($id);

    if ($commentaire->user_id !== Auth::id()) {
        return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire');
    }
    $publication = Publication::findOrFail($commentaire->pub_id);
    $publication->decrement('nbr_comm', 1);
    $commentaire->delete();

    return response()->json(['message' => 'Commentaire supprimée avec succès'], 200);
}



public function afficherCommentaire($idCommentaire)
{
    $commentaire = Commentaire::find($idCommentaire);

    if ($commentaire) {
        return response()->json(['commentaire' => $commentaire], 200);
    } else {
        return response()->json(['message' => 'Commentaire non trouvé.'], 404);
    }
}

}