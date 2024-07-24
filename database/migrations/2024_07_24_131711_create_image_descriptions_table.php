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
        Schema::create('image_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('before_id')->constrained('images')->cascadeOnDelete();
            $table->foreignId('after_id')->constrained('images')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_descriptions');
    }
};
