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
        Schema::create('advice_post_images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('alt_text')->nullable();
           $table->string('filename');
             $table->unsignedBigInteger('advice_post_id');
            $table->foreign('advice_post_id')->references('id')->on('advice_posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advice_post_images');
    }
};
