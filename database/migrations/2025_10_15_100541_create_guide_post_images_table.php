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
        Schema::create('guide_post_images', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('alt_text')->nullable();
           $table->string('filename');
           $table->unique(['filename', 'guide_post_id']);
             $table->unsignedBigInteger('guide_post_id');
            $table->foreign('guide_post_id')->references('id')->on('guide_posts');
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_post_images');
    }
};
