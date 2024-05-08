<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /**
     * Handle an incoming login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validatedUser = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validatedUser)) {
            // Authentification réussie
            $user = Auth::user();

            $token = $user->createToken('api_token')->plainTextToken;
            return response()->json(["user" => $user, 'token' => $token], 200);
        }

        // Échec de l'authentification
        return response()->json(['login fail' => 'Invalid credentials'], 401);
    }
}




/*
    public function login2(Request $request)
{
    // Validation pour le login
    $validatedData = $request->validate([
        'email' => 'required',
        'password' => 'required_if:first_login,1', // requis seulement si c'est la première connexion
    ]);

    // Vérifie si l'utilisateur existe déjà
    $user = User::where('email', $validatedData['email'])->first();

    // Vérifie si c'est la première connexion
    if ($user && $user->first_login == 1) {
        // Vérifie si le mot de passe a été fourni
        if (!isset($validatedData['password'])) {
            return response()->json(['error' => 'Veuillez fournir un mot de passe'], 400);
        }

        // Mise à jour du mot de passe et de l'état de connexion
        $user->password = $validatedData['password'];
        //$user->password = Hash::make($validatedData['password']);
        $user->first_login = 0; // marque comme non première connexion
        $user->save();
    }

    // Authentification
    if (Auth::attempt($validatedData)) {
        // Génère le token
        $user = Auth::user();
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(["user" => $user , 'token' => $token], 200);
    }

    return response()->json(['login fail' => 'Invalid credentials'], 401);
}
}

*/