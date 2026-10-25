<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('infospare')->table('subscribers', function (Blueprint $table) {
            $table->string('registration_id')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::connection('infospare')->table('subscribers', function (Blueprint $table) {
            $table->dropColumn('registration_id');
        });
    }
};
