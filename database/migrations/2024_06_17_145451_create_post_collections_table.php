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
        Schema::create('post_collections', function (Blueprint $table) {
            $table->id();
            $table->datetime('posted_at')->nullable();
            $table->json('title');
            $table->json('content')->nullable();
            
            $table->timestamps();
        });

        // Schema::create('post_collection_translations', function (Blueprint $table){
        //     $table->id();
        //     $table->string('locale');
           
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->unsignedBigInteger('post_collection_id');
        //     $table->foreign('post_collection_id')->references('id')->on('post_collections')->onDelete('cascade');

        //     $table->unique(['post_collection_id', 'locale']);

        //     // Indexes columns
        //     $table->index('locale');
        //     $table->index('post_collection_id');
        //     $table->index(['title(25)']);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_collections');
    }
};
