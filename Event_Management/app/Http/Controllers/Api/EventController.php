<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(['index', 'show']);
    }

    public function index()
    {

        $query = Event::query();
        $relations = ['user', 'attendees', 'attendees.user'];
        foreach ($relations as $relation) {
            $query->when(
                $this->shouldIncludeRelation($relation),
                fn($q) => $q->with($relation)
            );
        }
        return EventResource::collection($query->latest()->paginate());

    }

    private function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include');
        if (!$include) {
            return false;
        }
        $relations = array_map('trim', explode(',', $include));
        return in_array($relation, $relations);

    }

    public function store(Request $request)
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ]),
            'user_id' => 1
        ]);
        //return $event;
        return new EventResource($event);
    }


    public function show(Event $event)
    {
        //return $event;
        return new EventResource($event);
    }


    public function update(Request $request, Event $event)
    {
        $event->update([
            ...$request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time'
            ])
        ]);
        //return $event;
        return new EventResource($event);
    }


    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event has been deleted succesfully.']);
    }
}
