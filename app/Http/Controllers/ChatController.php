<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Auth;

use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function start(Request $request)
    {
        $chat = new Chat();
        $chat->user_id = Auth::id();
        $chat->professional_id = $request->professional_id;
        $chat->save();

        return redirect()->route('chat.messages', ['chat' => $chat->id]);
    }

    public function send(Request $request)
    {
        $message = new Message();
        $message->chat_id = $request->chat_id;
        $message->user_id = Auth::id();
        $message->message = $request->message;
        $message->save();

        \Log::info('Broadcasting MessageSent event', ['message' => $message]);
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message, 'user_name' => $message->user->name]);

    }

    public function messages(Chat $chat)
    {
        $user = Auth::user();

        $isRelatedToProfessional = $chat->professional->users->contains($user->id);

        if ($user->id !== $chat->user_id && $user->id !== $chat->professional_id && !$isRelatedToProfessional) {
            abort(403, 'Unauthorized action.');
        }

        $messages = $chat->messages()->with('user')->get();
        return view('chat.messages', compact('chat', 'messages'));
    }
}
