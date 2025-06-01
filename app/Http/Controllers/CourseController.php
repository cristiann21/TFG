<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los lenguajes y categorías para los filtros
        $languages = Course::select('language')->distinct()->whereNotNull('language')->pluck('language');
        $categories = Category::all();
        $levels = ['Principiante', 'Intermedio', 'Avanzado'];

        // Obtener los parámetros de filtrado
        $search = $request->input('search');
        $level = $request->input('level');
        $language = $request->input('language');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort', 'popular'); // Por defecto ordenar por popularidad

        // Construir la consulta con los filtros
        $query = Course::query()
            ->search($search)
            ->level($level)
            ->language($language)
            ->category($category)
            ->price($minPrice, $maxPrice);

        // Aplicar ordenamiento
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
            default:
                // Ordenar por lenguajes más populares (predefinidos)
                $popularLanguages = [
                    'JavaScript', 'Python', 'Java', 'C#', 'PHP', 
                    'C++', 'TypeScript', 'Ruby', 'Swift', 'Kotlin'
                ];
                
                $orderCases = "CASE";
                foreach ($popularLanguages as $index => $lang) {
                    $orderCases .= " WHEN language = '{$lang}' THEN {$index}";
                }
                $orderCases .= " ELSE 999 END";
                
                $query->orderByRaw($orderCases);
                break;
        }

        // Paginar los resultados
        $courses = $query->paginate(9)->withQueryString();

        return view('courses.index', compact(
            'courses', 
            'languages', 
            'categories', 
            'levels', 
            'search', 
            'level', 
            'language', 
            'category', 
            'minPrice', 
            'maxPrice', 
            'sort'
        ));
    }

    public function show(Course $course)
    {
        // Cargar el curso con sus tests y preguntas
        $course = Course::with(['quizzes' => function($query) {
            $query->with(['questions' => function($query) {
                $query->orderBy('id');
            }]);
        }])->find($course->id);

        // Obtener cursos relacionados (mismo lenguaje o categoría)
        $relatedCourses = Course::where('id', '!=', $course->id)
            ->where(function($query) use ($course) {
                $query->where('language', $course->language)
                      ->orWhere('category_id', $course->category_id);
            })
            ->take(3)
            ->get();

        return view('courses.show', compact('course', 'relatedCourses'));
    }

    public function obtain(Course $course)
    {
        $user = auth()->user();
        $subscription = $user->subscriptions()->where('is_active', true)->first();

        // Verificar si el usuario ya tiene el curso
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Ya tienes este curso en tu cuenta.');
        }

        // Verificar si el usuario tiene una suscripción activa y válida
        if (!$subscription || !$subscription->isActive()) {
            return back()->with('error', 'Necesitas una suscripción activa para obtener cursos.');
        }

        // Verificar si el plan permite obtener cursos
        if ($subscription->plan_type === 'free') {
            return back()->with('error', '¡Suscríbete ahora para acceder a este curso!')
                        ->with('show_subscription_button', true);
        }

        // Verificar límite de cursos según el plan
        $maxCourses = $subscription->plan_type === 'trial' ? 5 : 25;
        $currentCourses = $user->courses()->count();
        
        if ($currentCourses >= $maxCourses) {
            return back()->with('error', 'Has alcanzado el límite de 5 cursos para tu plan de prueba. ¡Actualiza tu suscripción para obtener más cursos!')
                        ->with('show_subscription_button', true);
        }

        try {
            DB::beginTransaction();

            // Añadir el curso al usuario
            $user->courses()->attach($course->id);

            DB::commit();

            // Redirigir con mensaje de éxito
            return redirect()
                ->route('courses.index')
                ->with('success', '¡Curso obtenido correctamente!')
                ->with('show_enrolled_courses_link', true);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al obtener el curso: ' . $e->getMessage());
            return back()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    public function addToFavorites(Course $course)
    {
        // Verificar si el curso ya está en favoritos
        if (!auth()->user()->favorites()->where('course_id', $course->id)->exists()) {
            auth()->user()->favorites()->attach($course->id);
        }
        return back();
    }

    public function removeFromFavorites(Course $course)
    {
        try {
            DB::beginTransaction();
            
            // Verificar si el curso está en favoritos antes de quitarlo
            if (auth()->user()->favorites()->where('course_id', $course->id)->exists()) {
                auth()->user()->favorites()->detach($course->id);
                DB::commit();
                return redirect()->back()->with('success', 'Curso quitado de favoritos');
            }
            
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al quitar de favoritos: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al quitar de favoritos');
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:Principiante,Intermedio,Avanzado',
            'language' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url'
        ]);

        try {
            DB::beginTransaction();

            // Crear el directorio si no existe
            if (!file_exists(public_path('images/courses'))) {
                mkdir(public_path('images/courses'), 0777, true);
            }

            // Guardar la imagen
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/courses'), $imageName);
            $imagePath = 'images/courses/' . $imageName;

            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'level' => $request->level,
                'language' => $request->language,
                'category_id' => $request->category_id,
                'image' => $imagePath,
                'video_url' => $request->video_url,
                'instructor_id' => auth()->id(),
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return redirect()->route('courses.show', $course)
                ->with('success', 'Curso creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el curso: ' . $e->getMessage());
        }
    }

    public function edit(Course $course)
    {
        if ($course->created_by !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este curso.');
        }

        // Cargar los tests del curso con sus preguntas
        $course->load(['quizzes' => function($query) {
            $query->with('questions');
        }]);

        $categories = Category::all();
        return view('courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        // Verificar permisos
        if ($course->created_by !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este curso.');
        }

        // Validar los datos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:Principiante,Intermedio,Avanzado',
            'language' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'video_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Preparar los datos para actualizar
            $data = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'level' => $validated['level'],
                'language' => $validated['language'],
                'category_id' => $validated['category_id'],
                'video_url' => $validated['video_url'] ?? null
            ];

            // Manejar la imagen si se subió una nueva
            if ($request->hasFile('image')) {
                // Eliminar la imagen anterior si existe
                if ($course->image && file_exists(public_path($course->image))) {
                    unlink(public_path($course->image));
                }

                // Guardar la nueva imagen
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/courses'), $imageName);
                $data['image'] = 'images/courses/' . $imageName;
            }

            // Actualizar el curso
            $course->fill($data);
            $course->save();

            DB::commit();

            return redirect()->route('courses.show', $course)
                ->with('success', 'Curso actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar el curso:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Error al actualizar el curso: ' . $e->getMessage());
        }
    }

    public function destroy(Course $course)
    {
        if ($course->created_by !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar este curso.');
        }

        // Eliminar la imagen si existe
        if ($course->image && file_exists(public_path($course->image))) {
            unlink(public_path($course->image));
        }

        $course->delete();

        return redirect()->route('profile.courses')
            ->with('success', 'Curso eliminado exitosamente.');
    }
}