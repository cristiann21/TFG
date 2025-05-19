<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'title',
        'description',
        'price',
        'level',
        'image',
        'created_by',
        'language', // Nuevo campo para el lenguaje de programación
        'category_id', // Relación con categorías
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'cursos_usuarios', 'cursos_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope para búsqueda
    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('title', 'LIKE', "%{$term}%")
                        ->orWhere('description', 'LIKE', "%{$term}%")
                        ->orWhere('language', 'LIKE', "%{$term}%");
        }
        return $query;
    }

    // Scope para filtrar por nivel
    public function scopeLevel($query, $level)
    {
        if ($level) {
            return $query->where('level', $level);
        }
        return $query;
    }

    // Scope para filtrar por lenguaje
    public function scopeLanguage($query, $language)
    {
        if ($language) {
            return $query->where('language', $language);
        }
        return $query;
    }

    // Scope para filtrar por categoría
    public function scopeCategory($query, $category)
    {
        if ($category) {
            return $query->where('category_id', $category);
        }
        return $query;
    }

    // Scope para filtrar por precio
    public function scopePrice($query, $min, $max)
    {
        if ($min && $max) {
            return $query->whereBetween('price', [$min, $max]);
        } elseif ($min) {
            return $query->where('price', '>=', $min);
        } elseif ($max) {
            return $query->where('price', '<=', $max);
        }
        return $query;
    }
}