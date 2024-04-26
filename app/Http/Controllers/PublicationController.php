<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Contenu;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class PublicationController extends Controller
{
    public function createPublication(Request $request)
    {

            // Création du contenu
            $contenuId = $this->createContenu($request);

            if (!$contenuId) {
                throw new \Exception("Échec lors de la création du contenu.");
            }

            // Récupération de l'utilisateur connecté
            $userId =Auth::id();

            // Création de la publication
            $publication = new Publication();
            $publication->date_pub = now();
            $publication->isApproved = 0;
            $publication->nbr_comm = 0;
            $publication->nbr_react = 0;
            $publication->contenu_id = $contenuId; // Attribuer l'ID du contenu
            $publication->user_id = $userId;
            $publication->save();

            return response()->json(['message' => 'Publication créée avec succès'], 200);
    }


    public function createContenu(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'texte' => 'nullable|string', // Le texte est facultatif
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // L'image est facultative
                'video' => 'nullable|mimetypes:video/mp4|max:20000', // La vidéo est facultative
                'lien' => 'nullable|url', // Le lien est facultatif
            ]);

            // Création d'un nouveau contenu
            $contenu = new Contenu();

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

            // Retourner l'ID du contenu nouvellement créé
            return $contenu->id;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la création du contenu: " . $e->getMessage());
        }
    }








    public function updatePublication(Request $request, $id)  //juste tbadel el isApproved ne9sa les donnees fel contenu
    {
         // Récupérer la publication à modifier
          $publication = Publication::findOrFail($id);
          $contenu = Contenu::findOrFail( $publication->contenu_id );

            // Vérifier si l'utilisateur connecté est l'auteur de la publication
            if ($publication->user_id !== auth()->user()->id) {
                return response()->json(['message' => "Vous n'êtes pas autorisé à modifier cette publication."]);
            }

            if ($request->has('texte')) {
                $contenu->texte = $request->texte;
            }
            if ($request->has('image')) {
                $contenu->image_path = $request->image;
            }
            if ($request->has('video')) {
                $contenu->video_path = $request->video;
            }
            if ($request->has('lien')) {
                $contenu->lien = $request->lien;
            }

            $contenu->save();

            $publication->isApproved = -1;
            $publication->save();

            $publication = Publication::findOrFail($id);

            return response()->json($publication);
    }



    public function deletePublication($id)
    {
        try {
            // Récupérer la publication à supprimer
            $publication = Publication::findOrFail($id);

            // Vérifier si l'utilisateur connecté est l'auteur de la publication ou s'il est administrateur
            if ($publication->user_id !== auth()->user()->id ) {
                throw new \Exception("Vous n'êtes pas autorisé à supprimer cette publication.");
            }

            $contenu = $publication->contenu;

        // Supprimer la publication
        $publication->delete();

        // Vérifier et supprimer le contenu associé s'il existe
        if ($contenu) {
            $contenu->delete();
        }
            return response()->json(['message' => 'Publication supprimée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de la publication', 'error' => $e->getMessage()], 500);
        }
    }




     // Consulter les publications non approuvées
     public function viewUnapprovedPublications()
{

        // Récupérer les publications non approuvées avec les détails du contenu associé
        $unapprovedPublications = Publication::with(['contenu', 'user'])
                                             ->where('isApproved', 0)
                                             ->get();


        // Retourner les publications non approuvées en JSON
        return response()->json($unapprovedPublications, 200);

}


     public function viewModificationRequests()
{
    $modificationRequests = Publication::with(['contenu', 'user'])
                                        ->where('isApproved', -1)
                                        ->get();
    return response()->json($modificationRequests, 200);
}


     // Consulter les publications approuvées
     public function viewApprovedPublications()
     {
         $approvedPublications = Publication::with(['contenu', 'user' , 'commentaires'])
         ->where('isApproved', 1)
         ->get();
         return response()->json($approvedPublications, 200);
     }


     public function viewPublicationsByPopularity()     //lel admin
     {
         $publications = Publication::orderBy('nbr_reaction', 'desc')->get();
         return response()->json($publications, 200);
     }



     public function filterPublications(Request $request)
{
    try {
        // Récupérer la date à filtrer
        $date = $request->input('date');

        // Vérifier si une date est fournie
        if (!$date) {
            throw new \Exception("Veuillez fournir une date valide pour filtrer les publications.");
        }

        // Filtrer les publications par la date de publication
        $filteredPublications = Publication::whereDate('date_pub', $date)->get();

        return response()->json($filteredPublications, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erreur lors du filtrage des publications par date', 'error' => $e->getMessage()], 500);
    }
}




public function filterByUserId(Request $request)
{
    try {
        $userId = Auth::id();

        if (!$userId) {
            throw new \Exception("L'utilisateur n'est pas connecté.");
        }

        $filteredPublications = Publication::where('user_id', $userId)
            ->where('isApproved', 1)
            ->get();

        return response()->json($filteredPublications, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erreur lors du filtrage des publications par ID utilisateur', 'error' => $e->getMessage()], 500);
    }
}


}
