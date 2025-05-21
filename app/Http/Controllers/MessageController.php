<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Notifications\SendMessageNotificationNotification;
use App\Events\SendMessageEvent;
use Illuminate\Support\Facades\DB;


class MessageController extends Controller
{
    public function index()
    {

        $authId = Auth::id();

        // Fetch users except the current user
        $users = User::where('id', '!=', $authId)->get();

        $users = $users->map(function ($user) use ($authId) {
            $lastMessage = Message::where('sender_id', $user->id)
                ->where('receiver_id', $authId)
                ->latest('created_at')
                ->first();

            $user->last_message = $lastMessage ? $lastMessage->message : null;
            return $user;
        });


        return view('chat', compact('users'));
    }

    public function chatWith($id)
    {

        $authId = Auth::id();

        // Fetch users except the current user
        $users = User::where('id', '!=', $authId)->get();

        $users = $users->map(function ($user) use ($authId) {
            $lastMessage = Message::where('sender_id', $user->id)
                ->where('receiver_id', $authId)
                ->latest('created_at')
                ->first();

            $user->last_message = $lastMessage ? $lastMessage->message : null;
            return $user;
        });


        // Chat messages with selected user
        $messages = Message::where(function ($q) use ($id, $authId) {
            $q->where('sender_id', $authId)->where('receiver_id', $id);
        })
            ->orWhere(function ($q) use ($id, $authId) {
                $q->where('sender_id', $id)->where('receiver_id', $authId);
            })
            ->orderBy('created_at')
            ->get();


        // Change the user to chat wite
        $chatWith = User::findOrFail($id);

        // Mark the Notifications as Read
        auth()->user()->unreadNotifications()
            ->where('data->sender_id', $chatWith->id)
            ->get()
            ->each->markAsRead();


        return view('chat', compact('users', 'chatWith', 'messages'));
    }

    // SEND MESSAGE
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        $sender_id = Auth::id();

        // Broadcast Event
        SendMessageEvent::dispatch($request->message, $sender_id);


        $receiver = User::find($request->receiver_id);


        $receiver->notify(new SendMessageNotificationNotification($message, $sender_id));

        return response()->json($message, 201);
    }
}
