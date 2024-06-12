<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $user_id = auth()->user()->id;
        if ($request->ajax()) {
            if (!empty($query)) {
                $events = Event::where('user_id', $user_id)->where('title', 'LIKE', "%{$query}%")->paginate(10);
            } else {
                $events = Event::where('user_id', $user_id)->paginate(10);
            }
            return view('event.partial.search', compact('events'))->render();
        }
        $events = Event::where('user_id', $user_id)->paginate(10);
        return view('event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        $event = new Event();
        $event->user_id = auth()->user()->id;
        $event->title = $request->title;
        $event->color = $request->color;
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        $event->title = $request->title;
        $event->color = $request->color;
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
