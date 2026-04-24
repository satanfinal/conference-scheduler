<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Speaker;
use App\Models\Category;

class EventController extends Controller
{
    private function currentSpeakerProfile()
    {
        return Speaker::where('user_id', auth()->id())->first();
    }

    private function canManageEvent($event)
    {
        if (auth()->user()->is_admin) {
            return true;
        }

        $speakerProfile = $this->currentSpeakerProfile();

        return $speakerProfile && $event->speaker_id == $speakerProfile->id;
    }

    public function index()
    {
        $events = Event::with(['speaker', 'category'])
            ->orderBy('start_time', 'asc')
            ->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $speakerProfile = $this->currentSpeakerProfile();

        if (!auth()->user()->is_admin && !$speakerProfile) {
            abort(403, 'Only admins and speakers can create conference sessions.');
        }

        $speakers = auth()->user()->is_admin
            ? Speaker::all()
            : Speaker::where('id', $speakerProfile->id)->get();

        $categories = Category::all();

        return view('events.create', compact('speakers', 'categories'));
    }

    public function store(Request $req)
    {
        $speakerProfile = $this->currentSpeakerProfile();

        if (!auth()->user()->is_admin && !$speakerProfile) {
            abort(403, 'Only admins and speakers can create conference sessions.');
        }

        $req->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'meeting_link' => 'nullable|url',
            'speaker_id' => 'nullable',
            'category_id' => 'nullable',
        ]);

        $speakerId = auth()->user()->is_admin
            ? $req->speaker_id
            : $speakerProfile->id;

        Event::create([
            'title' => $req->title,
            'description' => $req->description,
            'start_time' => $req->start_time,
            'end_time' => $req->end_time,
            'meeting_link' => $req->meeting_link,
            'speaker_id' => $speakerId,
            'category_id' => $req->category_id,
            'user_id' => auth()->id(),
        ]);

        return redirect('/events')->with('msg', 'Conference session created successfully.');
    }

    public function show($id)
    {
        $event = Event::with(['speaker', 'category'])->findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        if (!$this->canManageEvent($event)) {
            abort(403, 'You can only edit sessions you manage.');
        }

        $speakerProfile = $this->currentSpeakerProfile();

        $speakers = auth()->user()->is_admin
            ? Speaker::all()
            : Speaker::where('id', $speakerProfile->id)->get();

        $categories = Category::all();

        return view('events.edit', compact('event', 'speakers', 'categories'));
    }

    public function update(Request $req, $id)
    {
        $event = Event::findOrFail($id);

        if (!$this->canManageEvent($event)) {
            abort(403, 'You can only update sessions you manage.');
        }

        $req->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'meeting_link' => 'nullable|url',
            'speaker_id' => 'nullable',
            'category_id' => 'nullable',
        ]);

        $speakerProfile = $this->currentSpeakerProfile();

        $speakerId = auth()->user()->is_admin
            ? $req->speaker_id
            : $speakerProfile->id;

        $event->update([
            'title' => $req->title,
            'description' => $req->description,
            'start_time' => $req->start_time,
            'end_time' => $req->end_time,
            'meeting_link' => $req->meeting_link,
            'speaker_id' => $speakerId,
            'category_id' => $req->category_id,
        ]);

        return redirect('/events/' . $event->id)->with('msg', 'Conference session updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if (!$this->canManageEvent($event)) {
            abort(403, 'You can only delete sessions you manage.');
        }

        $event->delete();

        return redirect('/events')->with('msg', 'Conference session deleted successfully.');
    }
}