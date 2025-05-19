<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses = Course::latest()->take(3)->get();
        return view('home', compact('featuredCourses'));
    }
}