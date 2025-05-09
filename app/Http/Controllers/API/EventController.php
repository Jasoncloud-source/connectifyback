<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('community:id,name');
        
        // Filter by community if provided
        if ($request->has('community_id')) {
            $query->where('community_id', $request->community_id);
        }
        
        $events = $query->orderBy('date', 'asc')->get();
        
        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'community_id' => 'required|exists:communities,id',
        ]);

        // Check if user is a member of the community
        $community = Community::findOrFail($request->community_id);
        if (!$community->users()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'You must be a member of the community to create an event'], 403);
        }

        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'community_id' => $request->community_id,
        ]);

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        $event->load('community');
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        // Check if user is a member of the community
        $community = $event->community;
        if (!$community->users()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'You must be a member of the community to update an event'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $event->update($request->only(['name', 'description', 'date']));

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        // Check if user is the creator of the community or the event
        $community = $event->community;
        if ($community->created_by_user_id !== auth()->id()) {
            return response()->json(['message' => 'Only the community creator can delete events'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}