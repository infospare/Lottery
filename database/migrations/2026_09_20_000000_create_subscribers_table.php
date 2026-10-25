<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('infospare')->create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('subscriber_name');
            $table->string('phone', 30)->nullable();
            $table->string('registration_key')->unique();
            $table->date('expiry_date');
            $table->string('notes', 500)->nullable();
            $table->timestamps();

            $table->index('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::connection('infospare')->dropIfExists('subscribers');
    }
};
