<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Enviar email solo a la dirección configurada en MAIL_FROM_ADDRESS
        Mail::to(config('mail.from.address'))->send(new ContactFormMail($validated));

        return redirect()->back()->with('success', '¡Gracias por tu mensaje! Te responderemos pronto.');
    }
} 