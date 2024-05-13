<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('chat', 'AuthController@authenticate');

Broadcast::routes();

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('chat', function ($user) {

    return Auth::check();
    // if (Auth::check() && $user->id === Auth::user()->id) {
    //     return ['id' => $user->id, 'nom' => $user->nom];
    // }
});
// Broadcast::channel('chat.{roomId}', function ($user, $roomId) {

//     if (Auth::check() && $user->id === Auth::user()->id) {
//         return ['id' => $user->id, 'nom' => $user->nom];
//     }
// });
// Broadcast::channel('chat', function () {

//         return true;

// });
