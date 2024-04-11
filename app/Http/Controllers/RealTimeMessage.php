<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\Chat;
use App\Models\ChatUsers;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RealTimeMessage extends Controller
{
    public function index(Request $request)
    {
        SendMessage::dispatch();
        dd('Event Fired 3');
    }

    public function messages(): JsonResponse {
        $messages = Message::with('user')->get()->append('time');

        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse {

        $chatId = $request->get('chat_id') ?? Chat::create([
            'name'=>$request->get('chat_name')
        ])->id;

        $message = Message::create([
            'chat_id' => $chatId,
            'user_id' => auth()->id(),
            'text' => $request->get('text'),
        ]);

        $chatUsers1 = ChatUsers::create([
            'chat_id'=>$chatId,
            'user_id'=>auth()->id()
        ]);

        $chatUsers2 = ChatUsers::create([
            'chat_id'=>$chatId,
            'user_id'=>$request->user_id
        ]);


        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
