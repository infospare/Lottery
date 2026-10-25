<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('infospare')->create('lottery_draws', function (Blueprint $table) {
            $table->id();
            $table->string('lottery_name');
            $table->string('draw_code');
            $table->date('draw_date');
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->json('results')->nullable();
            $table->timestamps();

            $table->unique(['lottery_name', 'draw_code']);
            $table->index('draw_date');
        });
    }

    public function down(): void
    {
        Schema::connection('infospare')->dropIfExists('lottery_draws');
    }
};
