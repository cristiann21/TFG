<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Course;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        // Si el usuario es profesor y ha subido una nueva foto
        if ($user->isTeacher() && $request->hasFile('avatar')) {
            // Eliminar la foto anterior si existe
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            // Guardar la nueva foto
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images/avatars'), $avatarName);
            $validated['avatar'] = 'images/avatars/' . $avatarName;
        }

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Perfil actualizado correctamente');
    }

    public function courses()
    {
        $user = auth()->user();
        
        if (!$user->isTeacher()) {
            return redirect()->route('profile.enrolled-courses');
        }

        // Obtener SOLO los cursos creados por el profesor
        $courses = Course::where('instructor_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('profile.courses', compact('courses'));
    }

    public function enrolledCourses()
    {
        $user = auth()->user();
        
        // Obtener SOLO los cursos que el usuario ha comprado/adquirido
        $courses = Course::whereHas('users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->where('instructor_id', '!=', $user->id) // Excluir cursos creados por el usuario
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('profile.enrolled-courses', compact('courses'));
    }
} 