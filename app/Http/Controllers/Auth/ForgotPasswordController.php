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
        $hashedToken = Hash::make($token);
        
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $hashedToken,
            'created_at' => Carbon::now()
        ]);
        
        // Envía correo
        Mail::send('auth.email-forgot', ['token' => $token, 'email' => $request->email], function($message) use($request) {
            $message->to($request->email)
                    ->subject('Restablecer Contraseña - PinCode');
        });
        
        return back()->with('status', '¡Enlace enviado! Revisa tu correo.');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->query('email') // Recupera email desde URL
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
            ->first();
            
        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Token inválido o expirado']);
        }
        
        // Actualiza contraseña
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
            
        // Elimina token
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        return redirect()->route('login')
            ->with('success', '¡Contraseña actualizada!');
    }
}
