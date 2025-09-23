<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Detect if the request is from FullCalendar asking for events
        if ($request->has('start') && $request->has('end')) {
            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
			
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
                    'title' => $request->title,
                    'start' => $request->start,
                    'end'   => $request->end
                ]);
                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end'   => $request->end
                ]);
                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Event::find($request->id)->delete();
                return response()->json($event);
            }
        }
    }
}
