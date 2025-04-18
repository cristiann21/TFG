<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->text('description');
        $table->decimal('price', 8, 2);
        $table->string('level'); // básico, intermedio, avanzado
        $table->string('image')->nullable();
        $table->foreignId('created_by')->constrained('users');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
