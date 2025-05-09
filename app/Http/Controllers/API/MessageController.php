<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Community $community)
    {
        // Check if user is a member of the community
        if (!$community->users()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'You must be a member of the community to view messages'], 403);
        }

        $messages = $community->messages()
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json($messages->reverse());
    }

    public function store(Request $request, Community $community)
    {
        // Check if user is a member of the community
        if (!$community->users()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'You must be a member of the community to send messages'], 403);
        }

        $request->validate([
            'text' => 'required|string',
        ]);

        $message = Message::create([
            'text' => $request->text,
            'user_id' => auth()->id(),
            'community_id' => $community->id,
        ]);

        // Load the user relation for the response
        $message->load('user:id,name');

        return response()->json($message, 201);
    }
}