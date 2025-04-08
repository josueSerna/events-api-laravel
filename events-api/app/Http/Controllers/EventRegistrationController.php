<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Event;

class EventRegistrationController extends Controller
{
    public function register($id, Request $request)
    {
        $userId = $request->header('X-USER-ID');

        if (!$userId) {
            return response()->json(['error' => 'ID de usuario no proporcionado'], 401);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 401);
        }

        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Evento no encontrado'], 404);
        }

        if ($user->events()->where('event_id', $id)->exists()) {
            return response()->json(['error' => 'Ya estás inscrito en este evento'], 400);
        }

        if ($user->events()->count() >= 3) {
            return response()->json(['error' => 'No puedes inscribirte en más de 3 eventos'], 400);
        }

        $user->events()->attach($id);

        return response()->json(['message' => 'Inscripción exitosa']);
    }


    public function userEvents(Request $request)
    {
        $userId = $request->header('user_id');

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user->events()->get());
    }


    public function cancel(Request $request, $eventId)
{
    $userId = $request->header('user_id');

    $user = User::find($userId);
    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    $event = Event::find($eventId);
    if (!$event) {
        return response()->json(['message' => 'Evento no encontrado'], 404);
    }

    
    if (!$user->events->contains($eventId)) {
        return response()->json(['message' => 'El usuario no está inscrito en este evento'], 400);
    }

    $user->events()->detach($eventId);

    return response()->json(['message' => 'Inscripción cancelada correctamente']);
}

}
