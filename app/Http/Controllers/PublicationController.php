<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Contenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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

            return response()->json(['message' => 'Publication créée avec succès', 'publication' => $publication], 200);
        }


    public function createContenu(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'texte' => 'nullable|string', // Le texte est facultatif
                'image_path' => 'nullable|string', // L'image est facultative
                'video_path' => 'nullable|mimetypes:video/mp4|max:20000', // La vidéo est facultative
                'lien' => 'nullable|url', // Le lien est facultatif
            ]);

            $contenu = new Contenu();

                // $imagePath = $this->handleFileUpload($request->file('image_path'), 'images/evenements/');
                // $contenu->image_path = $imagePath;


                // $videoPath = $this->handleFileUpload($request->file('video_path'), 'images/evenements/');
                // $contenu->video_path = $videoPath;

                    $request['base64string'] = $this->handleFileUpload($request['image_path'], 'images/evenements/');
                    $contenu->image_path = $request['base64string'];


                // if (!empty($validatedData['image_path'])) {
                //     $contenu->image_path = $validatedData['image_path'];
                // }

                // if (!empty($validatedData['video_path'])) {
                //     $contenu->video_path = $validatedData['video_path'];
                // }
            if (!empty($validatedData['lien'])) {
                $contenu->lien = $validatedData['lien'];
            } if (!empty($validatedData['texte']))
                $contenu->texte = $validatedData['texte'] ?? '';


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
            if ($request->has('image_path')) {
                $base64string = $this->handleFileUpload($request->image_path, 'images/evenements/');

                $contenu->image_path = $base64string;
            }
            if ($request->has('video_path')) {
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



    public function handleFileUpload(string|null $file, string $path)
    {
        if (isset($file) && Str::contains($file, 'base64')) {


            $decodedFile = $this->decodedBase64File($file);
            $storePath = $path . $decodedFile['path'];

            $res = Storage::disk('public')->put($storePath,  $decodedFile['file']);


            if ($res) {
                return $storePath;
            }
        }

        return null;
    }

    public function decodedBase64File($file_64)
    {
        $extension = explode('/', explode(':', substr($file_64, 0, strpos($file_64, ';')))[1])[1];
        $replace = substr($file_64, 0, strpos($file_64, ',')+1);
        $file = str_replace($replace, '', $file_64);
        $decodedFile = str_replace(' ', '+', $file);
        $path =  Str::random(5) . time() .'.'. $extension;

        return [
            'path' => $path,
            'file' => base64_decode($decodedFile)
        ];
    }









    public function deletePublication($id)
    {
        try {
            // Récupérer la publication à supprimer
            $publication = Publication::findOrFail($id);

            // Vérifier si l'utilisateur connecté est l'auteur de la publication ou s'il est administrateur
            if ($publication->user_id !== auth()->user()->id && Auth::user()->role !== 'admin' ) {
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
public function viewApprovedPublications()
     {
         $approvedPublications = Publication::with(['contenu', 'user','commentaires'])
         ->where('isApproved', 1)
         ->join('contenus', 'publications.contenu_id', '=', 'contenus.id')
         ->orderBy('contenus.updated_at', 'desc')
         ->get();
         
         return response()->json($approvedPublications, 200);
     }
    // //  public function viewApprovedPublications()
    // //  {
    // //      $approvedPublications = Publication::with(['contenu', 'user'])
    // //      ->where('isApproved', 1)
    // //      ->join('contenus', 'publications.contenu_id', '=', 'contenus.id')
    // //      ->orderBy('contenus.updated_at', 'desc')
    // //      ->get();
    // //      foreach ($approvedPublications as $publication) {
    // //         $publication->load(['commentaires' => function ($query) {
    // //             $query->orderBy('updated_at', 'asc')->take(2); // Limiter le nombre de commentaires si nécessaire
    // //         }]);
    // //     }
    //      return response()->json($approvedPublications, 200);
    //  }
     public function loadComments(Publication $publication)
     {
         $additionalComments = $publication->commentaires()->orderBy('updated_at', 'asc')->skip(2)->take(2)->get();
         return response()->json($additionalComments, 200);
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

        $filteredPublications = Publication::with(['contenu', 'user' , 'commentaires'])
            ->where('user_id', $userId)
            ->where('isApproved', 1)
            ->join('contenus', 'publications.contenu_id', '=', 'contenus.id')
            ->orderBy('contenus.updated_at', 'desc')
            ->get();

        return response()->json($filteredPublications, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erreur lors du filtrage des publications par ID utilisateur', 'error' => $e->getMessage()], 500);
    }
}


}