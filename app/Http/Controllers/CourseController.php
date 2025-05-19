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
}