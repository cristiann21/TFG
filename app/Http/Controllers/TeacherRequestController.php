<?php

namespace App\Http\Controllers;

use App\Models\TeacherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeacherRequestNotification;

class TeacherRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'motivation' => 'required|string',
            'experience' => 'required|string',
        ]);

        // Verificar si ya existe una solicitud pendiente
        $existingRequest = TeacherRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'Ya tienes una solicitud pendiente de revisión.');
        }

        // Crear la solicitud
        $teacherRequest = TeacherRequest::create([
            'user_id' => auth()->id(),
            'motivation' => $request->motivation,
            'experience' => $request->experience,
            'status' => 'pending'
        ]);

        // Enviar correo de notificación
        Mail::to(config('mail.from.address'))->send(new TeacherRequestNotification($teacherRequest));

        return back()->with('success', 'Tu solicitud ha sido enviada. Te notificaremos cuando sea revisada.');
    }

    public function show()
    {
        // Verificar si el usuario ya es profesor
        if (auth()->user()->isTeacher()) {
            return redirect()->route('profile.index')->with('info', 'Ya tienes el rol de profesor.');
        }

        $request = TeacherRequest::where('user_id', auth()->id())
            ->latest()
            ->first();

        // Si no hay solicitud, inicializar como null
        if (!$request) {
            $request = null;
        }

        return view('profile.teacher-request', compact('request'));
    }

    public function approve(TeacherRequest $teacherRequest)
    {
        // Verificar que el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($teacherRequest->user_id !== auth()->id()) {
            return redirect()->route('home')->with('error', 'No tienes permiso para acceder a esta solicitud.');
        }

        // Verificar si el usuario ya es profesor
        if (auth()->user()->isTeacher()) {
            return redirect()->route('profile.index')->with('info', 'Ya tienes el rol de profesor.');
        }

        // Actualizar el estado de la solicitud
        $teacherRequest->update([
            'status' => 'approved'
        ]);

        // Convertir al usuario en profesor
        $user = auth()->user();
        $user->update([
            'role' => 'teacher'
        ]);

        return redirect()->route('profile.index')->with('success', '¡Felicidades! Ahora eres profesor en PinCode.');
    }
}
