<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->withTimestamps();
    }

    public function createdCourses()
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function hasActiveSubscription()
    {
        return $this->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->exists();
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getRemainingCourses()
    {
        $subscription = $this->subscriptions()->where('is_active', true)->first();
        if (!$subscription) {
            return 0;
        }

        $maxCourses = $subscription->plan_type === 'premium' ? 25 : 5; // Premium: 25 cursos, Basic: 5 cursos
        $acquiredCourses = $this->courses()->count();

        return max(0, $maxCourses - $acquiredCourses);
    }

    public function favorites()
    {
        return $this->belongsToMany(Course::class, 'favorites')
            ->withTimestamps();
    }
}