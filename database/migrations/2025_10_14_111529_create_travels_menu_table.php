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
        Schema::create('travels_menu', function (Blueprint $table) {
            $table->id();
            $table->string('title');
             $table->string('type')->default('menus');
              $table->unsignedBigInteger('term_id')->unique()->nullable();
            $table->string('imageName')->nullable();
            $table->string('imageExten')->nullable();
            $table->string('description')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels_menu');
    }
};
