<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display events list for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $events = Event::where('user_id', $user_id)->get();
        $calendarData = Calendar::where('user_id', Auth::id())->get();

        // Return JSON data
        if (request()->wantsJson()) {
            return response()->json($calendarData);
        }

        return view('calendar.index', compact('events'));
    }

    public function store(Request $request)
    {
        Calendar::create([
            'event_id'  => $request->event_id,
            'date'      => $request->date,
            'user_id'   => Auth::id(),
        ]);


        return response()->json(['success' => true], 200);
    }

    public function fetch()
    {
        $calendars = Calendar::where('user_id', Auth::id())->get();

        $formattedEvents = $calendars->map(function ($calendar) {
            return [
                'id' => $calendar->id,
                'title' => $calendar->event->title,
                'start' => $calendar->date,
                'color' => $calendar->event->color
            ];
        });

        return response()->json($formattedEvents);
    }

    public function destroy($id)
    {
        Calendar::findOrFail($id)->delete();
    }
}
