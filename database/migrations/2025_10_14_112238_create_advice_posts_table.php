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
       Schema::create('advice_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longtext('content');
            $table->string('slug')->unique();
            $table->boolean('is_visual')->default('1');
            $table->foreignId('menu_id')->constrained('advice_menu');
            $table->timestamps(); 
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advice_posts');
    }
};
