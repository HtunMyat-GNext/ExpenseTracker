<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $events = Event::where('user_id', $user_id)->get();
        return view('calendar.index', compact('events'));
    }
}
