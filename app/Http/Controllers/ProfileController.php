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
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Perfil actualizado correctamente');
    }

    public function courses()
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        $courses = Course::where('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.courses', compact('courses'));
    }
} 