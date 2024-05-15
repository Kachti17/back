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
    public function addRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:chat_rooms|max:255',
        ]);

        $chatRoom = ChatRoom::create($request->all());

        return response()->json(['chat_room' => $chatRoom, 'message' => 'Chat room created successfully.'], 201);
    }

    public function showAll()
{
    $chatRooms = ChatRoom::all();

    return response()->json(['message' => 'List of chat rooms', 'data' => $chatRooms], 200);
}
    public function destroy($id)
{
    $chatRoom = ChatRoom::find($id);
    if (!$chatRoom) {
        return response()->json(['message' => 'Chat room not found'], 404);
    }

    $chatRoom->delete();

    return response()->json(['message' => 'Chat room deleted successfully'], 200);
}
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
        return $newMessage;
    }
    public function deleteMessage($messageId){
        $message = Message::findOrFail($messageId);

        if (Auth::id() === $message->user_id || Auth::user()->role === 'admin') {
            $message->delete();
            return response()->json(['message' => 'Message successfully deleted'], 200);
        }

        return response()->json(['error' => 'Vous n\'êtes pas autorisé à supprimer ce message'], 403);
    }



}