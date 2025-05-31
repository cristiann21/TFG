<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request, Course $course)
    {
        // Verificar si el usuario ya tiene el curso
        if ($request->user()->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Ya tienes este curso en tu cuenta.');
        }

        try {
            DB::beginTransaction();

            // Crear la compra
            $purchase = Purchase::create([
                'user_id' => $request->user()->id,
                'course_id' => $course->id,
                'total' => $course->price
            ]);

            // Añadir el curso al usuario
            $request->user()->courses()->attach($course->id);

            DB::commit();

            return redirect()->route('courses.show', $course)
                ->with('success', '¡Compra realizada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
} 