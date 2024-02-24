<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AtendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Atendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AtendeeController extends Controller
{
    use CanLoadRelationships;

    private array $relations = ['user'];

    public function __construct() {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'update']);
        $this->middleware('throttle:60')->only('store', 'destroy');
        $this->authorizeResource(Atendee::class, 'attendee');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $this->loadRelationships($event->attendees()->latest());

        return AtendeeResource::collection(
            $attendees->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $this->loadRelationships($event->attendees()->create([
            'user_id' => $request->user()->id,
        ]));

        return new AtendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Atendee $attendee)
    {

        return new AtendeeResource($this->loadRelationships($attendee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Atendee $attendee)
    {
        $attendee->delete();

        return response(status: 204);
    }
}
