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
        Schema::create('songs', function (Blueprint $table) {           
            $table->id();
            $table->unsignedBigInteger('album_id'); 
            $table->foreign('album_id')->references('id')->on('albums');
            $table->string("track");
            $table->string("genre");    
            $table->string("release_date");
            $table->timestamps();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
