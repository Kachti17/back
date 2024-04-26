<?php

namespace App\Http\Controllers;
use App\Models\Publication;

use App\Models\ReactionPost;
use App\Models\User;

use App\Http\Requests\StoreReactionRequest;
use App\Http\Requests\UpdateReactionRequest;
use Illuminate\Support\Facades\Auth;

class ReactionPostController extends Controller
{
    public function react($pub_id)
{
    $user_id = auth()->id();

    $existingReaction = ReactionPost::with('user','publication')
                                    ->where('pub_id', $pub_id)
                                    ->where('user_id', $user_id)
                                    ->first();

    if ($existingReaction) {
        return response()->json(['message' => 'Vous avez déjà réagi à cette publication.',$existingReaction]);
    }

    $post = Publication::find($pub_id);
    $post->nbr_react++;
    $post->save();

    ReactionPost::create([
        'pub_id' => $pub_id,
        'user_id' => $user_id,
        'hasReaction' => true,
    ]);

    return response()->json(['message' => 'Réaction enregistrée avec succès.', 'publication' => $post]);
}

public function unreact($pub_id)
{
    $user_id = auth()->id();

    $existingReaction = ReactionPost::with('user','publication')
                                    ->where('pub_id', $pub_id)
                                    ->where('user_id', $user_id)
                                    ->first();

    if (!$existingReaction) {
        return response()->json(['message' => 'Vous n\'avez pas encore réagi à cette publication.']);
    }

    $existingReaction->delete();

    $post = $existingReaction->publication;
    $post->nbr_react--;
    $post->save();


    return response()->json(['message' => 'Vous avez retiré votre réaction.', 'publication' => $post]);
}

public function checkUserReaction($pub_id)
{
    $reactions = ReactionPost::with('user')
                             ->where('pub_id', $pub_id)
                             ->where('user_id', Auth::id())
                             ->exists();


    return response()->json($reactions);
}

public function getUsersWhoReacted($pub_id)
{
    $reactions = ReactionPost::with('user')
                             ->where('pub_id', $pub_id)
                             ->get();

    $users = $reactions->pluck('user');

    return response()->json(['users' => $users]);
}




}