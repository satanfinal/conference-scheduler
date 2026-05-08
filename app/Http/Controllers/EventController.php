<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Speaker;
use App\Models\Category;

class EventController extends Controller
{
    /**
     * Get the currently logged in speaker profile
     */
    private function currentSpeakerProfile()
    {
        return Speaker::where('user_id', auth()->id())->first();
    }

    /**
     * Check whether the current user can manage the event
     */
    private function canManageEvent(Event $event): bool
    {
        // Admin can manage all sessions
        if (auth()->user()->is_admin) {
            return true;
        }

        $speakerProfile = $this->currentSpeakerProfile();

        // Speakers can only manage their own sessions
        return $speakerProfile
            && $event->speaker_id == $speakerProfile->id;
    }

    /**
     * Shared validation rules for event forms
     */
    private function validationRules(): array
    {
        return [
            'title' => 'required|string|max:255',

            'description' => 'required|string',

            'start_time' => 'required|date',

            'end_time' => 'required|date|after:start_time',

            'meeting_link' => 'nullable|url',

            'speaker_id' => 'nullable',

            'category_id' => 'nullable',
        ];
    }

    /**
     * Get speakers list depending on role
     */
    private function availableSpeakers()
    {
        $speakerProfile = $this->currentSpeakerProfile();

        return auth()->user()->is_admin
            ? Speaker::all()
            : Speaker::where('id', $speakerProfile->id)->get();
    }

    /**
     * Display all conference sessions
     */
    public function index()
    {
        $events = Event::with([
                'speaker',
                'category'
            ])
            ->orderBy('start_time', 'asc')
            ->paginate(5);

        return view('events.index', compact('events'));
    }

    /**
     * Show create event form
     */
    public function create()
    {
        $speakerProfile = $this->currentSpeakerProfile();

        // Prevent attendees from creating sessions
        if (
            !auth()->user()->is_admin
            && !$speakerProfile
        ) {
            abort(
                403,
                'Only admins and speakers can create conference sessions.'
            );
        }

        $speakers = $this->availableSpeakers();

        $categories = Category::all();

        return view(
            'events.create',
            compact('speakers', 'categories')
        );
    }

    /**
     * Store a newly created session
     */
    public function store(Request $request)
    {
        $speakerProfile = $this->currentSpeakerProfile();

        // Prevent attendees from creating sessions
        if (
            !auth()->user()->is_admin
            && !$speakerProfile
        ) {
            abort(
                403,
                'Only admins and speakers can create conference sessions.'
            );
        }

        // Validate request data
        $validated = $request->validate(
            $this->validationRules()
        );

        // Admin can select speaker
        // Speaker users automatically become session owner
        $speakerId = auth()->user()->is_admin
            ? $request->speaker_id
            : $speakerProfile->id;

        Event::create([
            'title' => $validated['title'],

            'description' => $validated['description'],

            'start_time' => $validated['start_time'],

            'end_time' => $validated['end_time'],

            'meeting_link' => $validated['meeting_link'] ?? null,

            'speaker_id' => $speakerId,

            'category_id' => $validated['category_id'] ?? null,

            'user_id' => auth()->id(),
        ]);

        return redirect('/events')
            ->with(
                'msg',
                'Conference session created successfully.'
            );
    }

    /**
     * Display event details
     */
    public function show(Event $event)
    {
        $event->load([
            'speaker',
            'category'
        ]);

        return view(
            'events.show',
            compact('event')
        );
    }

    /**
     * Show edit session form
     */
    public function edit(Event $event)
    {
        // Authorization check
        if (!$this->canManageEvent($event)) {
            abort(
                403,
                'You can only edit sessions you manage.'
            );
        }

        $speakers = $this->availableSpeakers();

        $categories = Category::all();

        return view(
            'events.edit',
            compact(
                'event',
                'speakers',
                'categories'
            )
        );
    }

    /**
     * Update conference session
     */
    public function update(
        Request $request,
        Event $event
    ) {
        // Authorization check
        if (!$this->canManageEvent($event)) {
            abort(
                403,
                'You can only update sessions you manage.'
            );
        }

        // Validate request
        $validated = $request->validate(
            $this->validationRules()
        );

        $speakerProfile = $this->currentSpeakerProfile();

        // Admin can select speaker
        // Speaker users automatically become owner
        $speakerId = auth()->user()->is_admin
            ? $request->speaker_id
            : $speakerProfile->id;

        $event->update([
            'title' => $validated['title'],

            'description' => $validated['description'],

            'start_time' => $validated['start_time'],

            'end_time' => $validated['end_time'],

            'meeting_link' => $validated['meeting_link'] ?? null,

            'speaker_id' => $speakerId,

            'category_id' => $validated['category_id'] ?? null,
        ]);

        return redirect('/events/' . $event->id)
            ->with(
                'msg',
                'Conference session updated successfully.'
            );
    }

    /**
     * Delete conference session
     */
    public function destroy(Event $event)
    {
        // Authorization check
        if (!$this->canManageEvent($event)) {
            abort(
                403,
                'You can only delete sessions you manage.'
            );
        }

        $event->delete();

        return redirect('/events')
            ->with(
                'msg',
                'Conference session deleted successfully.'
            );
    }
}