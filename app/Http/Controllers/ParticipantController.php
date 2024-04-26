<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;

class ParticipantController extends Controller
{
    public function filtrerParticipantsParUtilisateur($userId)
    {
        // Filtrer les participants par ID d'utilisateur
        $participants = Participant::where('user_id', $userId)
            ->get();

        return $participants;
    }
    public function filtrerParticipantsParEvenement($evenementId)
    {
        // Filtrer les participants par ID d'événement avec les détails du utilisateur
        $participants = Participant::with('user')->where('evenement_id', $evenementId)->get();

        return $participants;
    }

}