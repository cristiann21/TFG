<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

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
        
        // Verificar si el usuario ya tiene el curso
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->back()->with('error', 'Ya tienes este curso en tu cuenta.');
        }

        if ($user->getRemainingCourses() <= 0) {
            return redirect()->back()->with('error', 'No tienes cursos disponibles para obtener.');
        }

        // Añadir el curso al usuario
        $user->courses()->attach($course->id);

        return redirect()->back()->with('success', 'Curso obtenido con éxito.');
    }

    public function addToFavorites(Course $course)
    {
        auth()->user()->favorites()->attach($course->id);
        return back()->with('success', 'Curso añadido a favoritos');
    }

    public function removeFromFavorites(Course $course)
    {
        auth()->user()->favorites()->detach($course->id);
        return back()->with('success', 'Curso eliminado de favoritos');
    }

    public function create()
    {
        if (!auth()->check() || auth()->user()->role !== 'teacher') {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'teacher') {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:Principiante,Intermedio,Avanzado',
            'language' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/courses'), $imageName);
            $data['image'] = 'images/courses/' . $imageName;
        }

        Course::create($data);

        return redirect()->route('courses.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    public function edit(Course $course)
    {
        if (!auth()->check() || auth()->user()->role !== 'teacher' || $course->created_by !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este curso.');
        }

        $categories = Category::all();
        return view('courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        if (!auth()->check() || auth()->user()->role !== 'teacher' || $course->created_by !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este curso.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:Principiante,Intermedio,Avanzado',
            'language' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($course->image && file_exists(public_path($course->image))) {
                unlink(public_path($course->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/courses'), $imageName);
            $data['image'] = 'images/courses/' . $imageName;
        }

        $course->update($data);

        return redirect()->route('profile.courses')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Course $course)
    {
        if (!auth()->check() || auth()->user()->role !== 'teacher' || $course->created_by !== auth()->id()) {
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