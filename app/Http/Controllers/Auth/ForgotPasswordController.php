<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);
        
        // Elimina tokens antiguos
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        // Genera token seguro
        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        
        // Construye la URL de restablecimiento
        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $request->email
        ], false));
        
        // Envía correo
        Mail::send('auth.email-forgot', ['token' => $token, 'email' => $request->email, 'resetUrl' => $resetUrl], function($message) use($request) {
            $message->to($request->email)
                    ->subject('Restablecer Contraseña - PinCode');
        });
        
        return back()->with('status', '¡Enlace enviado! Revisa tu correo.');
    }

    public function showResetPasswordForm($token)
    {
        $email = request()->query('email');
        
        // Verifica que el token existe y no ha expirado
        $resetRecord = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();
            
        if (!$resetRecord) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'El enlace de restablecimiento ha expirado o es inválido.']);
        }
        
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);
        
        // Verifica token
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();
            
        if (!$resetRecord) {
            return back()->withErrors(['email' => 'El enlace de restablecimiento ha expirado o es inválido.']);
        }
        
        // Actualiza contraseña
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
            
        // Elimina token
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        return redirect()->route('login')
            ->with('success', '¡Contraseña actualizada! Ya puedes iniciar sesión con tu nueva contraseña.');
    }
}
