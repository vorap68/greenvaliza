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
      Schema::create('images', function (Blueprint $table) {

    $table->id();

    $table->string('category');
    $table->unsignedBigInteger('post_id');

    $table->string('filename');
    $table->string('alt_text')->nullable();

    $table->timestamps();

    // индексы
    $table->index('category');
    $table->index('post_id');

    // быстрый поиск
    $table->index(['category','post_id']);

    // уникальность
    $table->unique(['category','post_id','filename']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
