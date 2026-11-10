<?php

use App\Support\SiteContentDefaults;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_contents', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->default('Contenido principal');
            $table->json('content');
            $table->timestamps();
        });

        SiteContentDefaults::prepareAssets();
        DB::table('site_contents')->insert([
            'id' => 1,
            'name' => 'Contenido principal',
            'content' => json_encode(SiteContentDefaults::content(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
