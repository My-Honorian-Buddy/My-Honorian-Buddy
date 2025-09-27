<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Detect if the request is from FullCalendar asking for events
        if ($request->has('start') && $request->has('end')) {
            $data = Event::where('user_id', Auth::id())
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'user_id', 'title', 'start', 'end']);
			
            return response()->json($data); 
        }

        return view('components.creating-calendar');
    }

    public function action(Request $request)
    {
		// adding of event, updating and deleting
        if ($request->ajax()) {
            if ($request->type == 'add') {
                $event = Event::create([
                    'user_id' => Auth::id(), 
                    'title' => $request->title,
                    'start' => $request->start,
                    'end'   => $request->end
                ]);
                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Event::where('id', $request->id)
                ->where('user_id', Auth::id()) // this will ensure users can only update their own events
                ->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end'   => $request->end
                ]);
                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Event::where('id',  $request->id)
                ->where('user_id', Auth::id()) // this will ensure users can only delete their own events
                ->delete();
                return response()->json($event);
            }
        }
    }
}
