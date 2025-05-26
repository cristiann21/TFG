<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->string('language')->nullable()->after('level');
            $table->foreignId('category_id')->nullable()->after('language')->constrained('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['language', 'category_id']);
        });

        Schema::dropIfExists('categories');
    }
}; 