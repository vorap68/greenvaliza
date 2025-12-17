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
        Schema::create('travel_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content');
            $table->string('slug')->unique();
             $table->string('type')->default('post');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_visual')->default(false);
            $table->unsignedBigInteger('travels_menu_term_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->foreign('parent_id')->references('id')->on('travel_posts')->onDelete('cascade');  
            $table->foreign('travels_menu_term_id')->references('term_id')->on('travels_menu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_posts');
    }
};
