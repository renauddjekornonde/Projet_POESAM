<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = DB::table('evenements')
            ->where('organisation_id', $_COOKIE['user_id'])
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->titre,
                    'start' => $event->date_debut,
                    'end' => $event->date_fin,
                    'description' => $event->description,
                    'location' => $event->lieu,
                    'type' => $event->type,
                    'extendedProps' => [
                        'description' => $event->description,
                        'location' => $event->lieu,
                        'type' => $event->type
                    ]
                ];
            });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string|in:consultation,reunion,atelier,formation,autre'
        ]);

        try {
            $eventId = DB::table('evenements')->insertGetId([
                'titre' => $request->title,
                'description' => $request->description,
                'date_debut' => $request->start_date,
                'date_fin' => $request->end_date,
                'lieu' => $request->location,
                'type' => $request->type,
                'organisation_id' => $_COOKIE['user_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $event = DB::table('evenements')->find($eventId);

            return response()->json([
                'success' => true,
                'event' => [
                    'id' => $event->id,
                    'title' => $event->titre,
                    'start' => $event->date_debut,
                    'end' => $event->date_fin,
                    'description' => $event->description,
                    'location' => $event->lieu,
                    'type' => $event->type,
                    'extendedProps' => [
                        'description' => $event->description,
                        'location' => $event->lieu,
                        'type' => $event->type
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string|in:consultation,reunion,atelier,formation,autre'
        ]);

        try {
            $event = DB::table('evenements')
                ->where('id', $id)
                ->where('organisation_id', $_COOKIE['user_id'])
                ->first();

            if (!$event) {
                return response()->json([
                    'success' => false,
                    'error' => 'Événement non trouvé'
                ], 404);
            }

            DB::table('evenements')
                ->where('id', $id)
                ->update([
                    'titre' => $request->title,
                    'description' => $request->description,
                    'date_debut' => $request->start_date,
                    'date_fin' => $request->end_date,
                    'lieu' => $request->location,
                    'type' => $request->type,
                    'updated_at' => now()
                ]);

            $updatedEvent = DB::table('evenements')->find($id);

            return response()->json([
                'success' => true,
                'event' => [
                    'id' => $updatedEvent->id,
                    'title' => $updatedEvent->titre,
                    'start' => $updatedEvent->date_debut,
                    'end' => $updatedEvent->date_fin,
                    'description' => $updatedEvent->description,
                    'location' => $updatedEvent->lieu,
                    'type' => $updatedEvent->type,
                    'extendedProps' => [
                        'description' => $updatedEvent->description,
                        'location' => $updatedEvent->lieu,
                        'type' => $updatedEvent->type
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $event = DB::table('evenements')
                ->where('id', $id)
                ->where('organisation_id', $_COOKIE['user_id'])
                ->first();

            if (!$event) {
                return response()->json([
                    'success' => false,
                    'error' => 'Événement non trouvé'
                ], 404);
            }

            DB::table('evenements')
                ->where('id', $id)
                ->delete();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
