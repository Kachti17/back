<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;


class ChatController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function rooms(Request $request){
        return ChatRoom::all();
    }
    public function messages(Request $request, $roomId){
        return Message::with('user')
            ->where('chat_room_id', $roomId)
            ->orderBy('created_at', 'ASC')
            ->get();
    }
    public function newMessage(Request $request, $roomId){
        $validatedData = $request->validate([
            'corps' => 'required|string'
        ]);
        $user = User::find(Auth::id());
        $newMessage=new Message;
        $newMessage->user_id=Auth::id();
        $newMessage->chat_room_id=$roomId;
        $newMessage->corps=$validatedData['corps'];
        $newMessage->save();
        event(new NewChatMessage($newMessage));
       // broadcast(new NewChatMessage($newMessage))->toOthers();
        return $newMessage;
    }
    // public function send(Request $request){
    //     return $request->all();
    //     $user = User::find(Auth::id());
    //     event(new NewChatMessage($request->message,$user));

    // }
}
