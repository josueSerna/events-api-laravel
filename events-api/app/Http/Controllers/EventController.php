<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::all());
    }

    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        return response()->json($event);
    }

    public function store(Request $request)
    {
        $userId = $request->header('user_id');
        $user = User::find($userId);

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado. Solo los administradores pueden crear eventos.'], 403);
        }

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'event_date' => 'required|date',
        ]);

        $event = Event::create($request->all());

        return response()->json($event, 201);
    }

    public function update(Request $request, $id)
    {
        $userId = $request->header('user_id');
        $user = User::find($userId);

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado. Solo los administradores pueden editar eventos.'], 403);
        }

        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy(Request $request, $id)
    {
        $userId = $request->header('user_id');
        $user = User::find($userId);

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado. Solo los administradores pueden eliminar eventos.'], 403);
        }

        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Evento eliminado correctamente']);
    }
}
