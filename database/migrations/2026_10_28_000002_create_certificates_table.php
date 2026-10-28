<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->unique();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('recipient_name');
            $table->string('training_title');
            $table->date('issued_at');
            $table->date('expires_at')->nullable();
            $table->decimal('hours', 7, 2)->nullable();
            $table->string('evidence_image');
            $table->text('public_notes')->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
