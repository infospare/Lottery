<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('infospare')->create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $names = DB::connection('infospare')
            ->table('lottery_draws')
            ->whereNotNull('lottery_name')
            ->distinct()
            ->orderBy('lottery_name')
            ->pluck('lottery_name');

        $now = now();
        foreach ($names as $name) {
            $trimmed = trim((string) $name);
            if ($trimmed === '') {
                continue;
            }

            DB::connection('infospare')->table('lotteries')->insert([
                'name' => strtoupper($trimmed),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::connection('infospare')->dropIfExists('lotteries');
    }
};
