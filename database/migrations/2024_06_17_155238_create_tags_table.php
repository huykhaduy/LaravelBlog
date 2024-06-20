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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        // Schema::create('taggables', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('tag_id');
        //     $table->morphs('taggable');
        //     $table->timestamps();

        //     // Foreign key constraint
        //     $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

        //     // Indexes for faster lookups
        //     $table->index(['taggable_id', 'taggable_type']);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        // Schema::dropIfExists('taggables');
    }
};
