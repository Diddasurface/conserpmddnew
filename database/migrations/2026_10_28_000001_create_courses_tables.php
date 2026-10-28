<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('category')->nullable();
            $table->string('instructor')->nullable();
            $table->string('instructor_image')->nullable();
            $table->unsignedInteger('lessons_count')->nullable();
            $table->string('lessons_label')->default('lecciones');
            $table->unsignedInteger('students_count')->nullable();
            $table->string('students_label')->default('participantes');
            $table->unsignedTinyInteger('rating')->nullable();
            $table->unsignedInteger('reviews_count')->nullable();
            $table->string('reviews_label')->default('valoraciones');
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('currency', 10)->default('S/');
            $table->string('badge_text')->nullable();
            $table->string('badge_caption')->nullable();
            $table->string('button_text')->default('Solicitar información');
            $table->string('button_url', 2048)->nullable();
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['is_published', 'sort_order']);
        });

        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->default('Cursos');
            $table->string('title')->default('Únete a nuestros cursos que tenemos para ti.');
            $table->string('empty_text')->default('Próximamente publicaremos nuevos cursos.');
            $table->string('button_text')->nullable();
            $table->string('button_url', 2048)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_sections');
        Schema::dropIfExists('courses');
    }
};
