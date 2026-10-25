<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('infospare')->table('lottery_draws', function (Blueprint $table) {
            $table->string('status', 20)->default('Live')->after('draw_date');
        });
    }

    public function down(): void
    {
        Schema::connection('infospare')->table('lottery_draws', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
