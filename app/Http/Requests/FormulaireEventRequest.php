<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormulaireEventRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette demande.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtient les règles de validation qui s'appliquent à la demande.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|string',
            'image' => 'nullable|string',
            'date_evenement' => 'required|date',
            'lieu_evenement' => 'required|string',
            'nbr_max' => 'nullable|integer',
        ];
    }
}