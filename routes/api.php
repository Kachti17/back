<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ChatController;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReactionPostController;
use App\Models\ReactionPost;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::middleware('auth:sanctum')->get('/user', 'App\Http\Controllers\UserController@getUserDetails');


Route::group(['middleware' => 'auth:sanctum'], function () {


    Route::get('/chat/rooms', [ChatController::class, 'rooms']);
    Route::get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
    Route::post('/chat/room/{roomId}/message', [ChatController::class, 'newMessage']);

    Route::get('/user', [UserController::class, 'getUserDetails']);




    Route::post('/creerEvent', [EvenementController::class, 'createEvent']);

    Route::post('/creerPublication', [PublicationController::class, 'createPublication']);
    Route::put('/modifierPublication/{id}', [PublicationController::class, 'updatePublication'])->name('publications.update');
    Route::delete('/supprimerPublication/{id}', [PublicationController::class, 'deletePublication'])->name('publications.delete');



    Route::post('/evenements/{id}/participer', [EvenementController::class, 'participerEvenement']);
    Route::post('/evenements/{id}/annuler-participation', [EvenementController::class, 'annulerParticipation']);

    Route::post('/commenter/{publication_id}', [CommentaireController::class ,'commenterPublication']);
    Route::put('/modifierCommentaire/{id}', [CommentaireController::class, 'editCommentaire']);
    Route::delete('/supprimerCommentaire/{id}', [CommentaireController::class, 'deleteCommentaire']);


    Route::post('/forgotPassword',[UserController::class, 'forgotPassword']);

    Route::get('/publications/filterByUserId', [PublicationController::class, 'filterByUserId']);

    Route::get('/usersList', [UserController::class, 'showUserList']);

    Route::post('/publication/{pub_id}/react', [ReactionPostController::class, 'react']);
    Route::delete('/publication/{pub_id}/unreact', [ReactionPostController::class, 'unreact']);
    Route::post('/publication/{pub_id}/react-or-unreact', [ReactionPostController::class, 'reactOrUnreact']);


    Route::get('/publication/{pub_id}', [ReactionPostController::class, 'checkUserReaction']);

    Route::put('/imgProfile', [UserController::class, 'updateProfileImage']);

    Route::post('/changer-mot-de-passe',[UserController::class, 'changerMotDePasse']);

});


// Route::get('/publication/{pub_id}/userReacted', [ReactionPostController::class, 'getUsersWhoReacted']);



Route::post('/profile/{id}', [UserController::class, 'update']);


Route::post('/publication/accepter/{id}', [UserController::class, 'acceptPublicationRequest']);
Route::delete('/publication/refuser/{id}', [UserController::class, 'rejectPublicationRequest']);
Route::post('/publication/{id}/reject-modification', [UserController::class, 'rejectModificationRequest']);
Route::put('/publications/{id}/accept-modification', [UserController::class, 'acceptModificationRequest']);


Route::post('/register', [RegisteredUserController::class, 'createUser']);
Route::post('/makePassword', [RegisteredUserController::class, 'makePassword']);//edheya ki tsir el creation d un user w bech ya3mel password

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout']);

Route::delete('/DeleteUser/{id}', [UserController::class, 'deleteUser']);





Route::get('/users/{id}', [UserController::class, 'showUserById']);
Route::get('/users', [UserController::class, 'showAllUsers']);

Route::get('/users/filter-by-name/{name}', [UserController::class, 'filterByName']);
Route::get('/users/filter-by-role/{role}', [UserController::class, 'filterByRole']);

Route::delete('/DeleteEvent/{id}', [EvenementController::class, 'deleteEvent']);
Route::post('/UpdateEvent/{id}', [EvenementController::class, 'updateEvent']);
Route::get('/events', [EvenementController::class, 'showEvents']);
Route::get('/events/{id}', [EvenementController::class, 'showEventsById']);
Route::get('/TodayEvent', [EvenementController::class, 'showTodayEvent']);
Route::post('/SearchEvent/byData', [EvenementController::class, 'searchEvent']);
Route::get('/events/data', [EvenementController::class, 'listEvent']);


Route::post('/creerContenu', [ContenuController::class, 'createContenu']);

Route::get('/publicationApprouvée', [PublicationController::class, 'viewApprovedPublications']);// admin
Route::get('/publicationNonApprouvée', [PublicationController::class, 'viewUnapprovedPublications']);// admin
Route::get('/publicationModification', [PublicationController::class, 'viewModificationRequests']);// admin
Route::get('/publicationPopulaire', [PublicationController::class, 'viewPublicationsByPopularity']); // admin
Route::get('/publications/filtrer-par-date', [PublicationController::class, 'filterPublications']) ;//admin

Route::get('/participants/filtrer-by-id/{id}', [ParticipantController::class, 'filtrerParticipantsParUtilisateur']);
Route::get('/participants/filtrer-by-event/{id}', [ParticipantController::class, 'filtrerParticipantsParEvenement']);


Route::get('/imgEvent', [EvenementController::class, 'getImageUrl']);


// Route::post('/permissions/create', [PermissionController::class, 'createPermission']);
// Route::put('/permissions/edit/{id}', [PermissionController::class, 'editPermission']);
// Route::delete('/permissions/delete/{id}', [PermissionController::class, 'deletePermission']);
// Route::get('/permissions', [PermissionController::class, 'showPermissions']);


// Route::post('/roles/create',[RoleController::class, 'createRole'] );
// Route::put('/roles/edit/{id}', [RoleController::class, 'editRole']);
// Route::delete('/roles/delete/{id}', [RoleController::class, 'deleteRole']);
// Route::get('/roles',[RoleController::class, 'createRoleshowRoles']);

// Route::post('give-permission-to-role',  [PermissionController::class, 'givePermissionToRole']);
// Route::post('remove-permission-from-role',  [PermissionController::class, 'removePermissionFromRole']);
// Route::get('filter-permissions-by-role-id/{roleId}', [PermissionController::class, 'filterPermissionsByRoleId']);


Route::get('/commentaires/{publication_id}', [CommentaireController::class, 'afficherCommentaires']);
Route::get('/load-comments/{publication_id}', [PublicationController::class, 'loadComments']);