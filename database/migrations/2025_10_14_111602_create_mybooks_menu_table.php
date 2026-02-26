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
        Schema::create('mybooks_menu', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('imageName')->nullable();
            $table->string('description')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->boolean('is_visual')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mybook_menu');
    }
};
