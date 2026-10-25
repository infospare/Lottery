<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('infospare')->table('software_download_counts', function (Blueprint $table) {
            $table->string('zip_file_path')->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::connection('infospare')->table('software_download_counts', function (Blueprint $table) {
            $table->dropColumn('zip_file_path');
        });
    }
};
