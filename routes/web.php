<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ChatController;
use App\Events\WebsocketDemoEvent;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum','verified'])->get('/chat',function() {return Inertia\Inertia::render('Chat/container');})->name('chat');


Route::middleware('auth:sanctum')->get('/chat/rooms',[ChatController::class,'rooms']);
Route::middleware('auth:sanctum')->get('/chat/room/{roomId}/messages',[ChatController::class,'messages']);
Route::middleware('auth:sanctum')->post('/chat/room/{roomId}/message',[ChatController::class,'newMessage']);

Route::get('/',function(){
    return view('home');
});

Route::get('/dbconn',function(){
    return view('dbconn');
});










/*



Route::post('/oussema', function (Request $request) {
    // Accessing form data using the Request instance
    $name = $request->input('name');
    $email = $request->input('email');

    // Do something with the form data (e.g., save to database)

    // Redirect to a thank you page or any other response
    return redirect('/thank-you')->with('message', 'Form submitted successfully!');
});


*/