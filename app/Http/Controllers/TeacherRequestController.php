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
            'motivation' => 'required|string|min:100',
            'experience' => 'required|string|min:100',
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
        $request = TeacherRequest::where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('profile.teacher-request', compact('request'));
    }
}
