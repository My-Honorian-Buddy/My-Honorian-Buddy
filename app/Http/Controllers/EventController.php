<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\bookedSession;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Detect if the request is from FullCalendar asking for events
        if ($request->has('start') && $request->has('end')) {
            $userId = Auth::id();
            $userRole = Auth::user()->role; 
            
            
            $events = Event::where('user_id', $userId)
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->where(function($query) use ($userRole, $userId) {
                    
                    $query->whereNull('booked_session_id')
                        
                        ->orWhereHas('bookedSession', function($q) use ($userRole, $userId) {
                            $q->whereNull('deleted_at');
                            
                            
                            if ($userRole === 'Student') {
                                $q->where('student_id', $userId);
                            } elseif ($userRole === 'Tutor') {
                                $q->where('tutor_id', $userId);
                            }
                        });
                })
                ->get(['id', 'user_id', 'title', 'start', 'end', 'description', 'event_type', 'session_number', 'booked_session_id']);
            
            // Format events for FullCalendar with different colors for different types
            $formattedEvents = $events->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                    'description' => $event->description,
                    'eventType' => $event->event_type,
                    'sessionNumber' => $event->session_number,
                    'bookedSessionId' => $event->booked_session_id,
                    // Different styling for booked sessions
                    'backgroundColor' => $event->event_type === 'booked_session' ? '#10b981' : '#550000',
                    'borderColor' => $event->event_type === 'booked_session' ? '#059669' : '#550000',
                    'textColor' => '#FFD95C',
                    'editable' => $event->event_type === 'manual', // Only manual events can be edited
                ];
            });
			
            return response()->json($formattedEvents); 
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
                    'end'   => $request->end,
                    'event_type' => 'manual' // Mark as manual event
                ]);
                return response()->json($event);
            }

            if ($request->type == 'update') {
                // Only allow updating manual events
                $event = Event::where('id', $request->id)
                    ->where('user_id', Auth::id())
                    ->where('event_type', 'manual') // Prevent editing booked session events
                    ->update([
                        'title' => $request->title,
                        'start' => $request->start,
                        'end'   => $request->end
                    ]);
                return response()->json($event);
            }

            if ($request->type == 'delete') {
                // Only allow deleting manual events
                $event = Event::where('id',  $request->id)
                    ->where('user_id', Auth::id())
                    ->where('event_type', 'manual') // Prevent deleting booked session events
                    ->delete();
                return response()->json($event);
            }
        }
    }
}
