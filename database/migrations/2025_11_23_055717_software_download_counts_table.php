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
        
        Schema::connection('infospare')->create('software_download_counts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->text('description');
            $table->integer('download_count')->default(0);
            $table->string('size');
            $table->date('last_updated');
            $table->string('file_path');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('infospare')->dropIfExists('software_download_counts');
    }
};
