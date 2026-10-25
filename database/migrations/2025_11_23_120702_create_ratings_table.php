<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('infospare')->create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('software_download_count_id');
            $table->string('user_identifier'); // IP address or session ID for anonymous users
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->timestamps();
            
            $table->foreign('software_download_count_id')
                  ->references('id')
                  ->on('software_download_counts')
                  ->onDelete('cascade');
            
            // Ensure one rating per user per software
            $table->unique(['software_download_count_id', 'user_identifier']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('infospare')->dropIfExists('ratings');
    }
};
