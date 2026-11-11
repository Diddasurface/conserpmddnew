<?php

use App\Support\SiteContentDefaults;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SiteContentDefaults::prepareAssets();
    }

    public function down(): void
    {
        // Do not remove images because they may already be in use by the CMS.
    }
};
