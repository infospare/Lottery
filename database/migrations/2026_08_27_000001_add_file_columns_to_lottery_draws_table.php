<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('infospare')->table('lottery_draws', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('draw_date');
            $table->string('original_filename')->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::connection('infospare')->table('lottery_draws', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'original_filename']);
        });
    }
};
