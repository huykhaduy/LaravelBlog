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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->datetime('posted_at')->nullable();
            $table->string('post_type');
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('post_collection_id')->nullable();
            $table->foreign('post_collection_id')->references('id')->on('post_collections')->onDelete('set null');
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('title');
            $table->mediumText('content');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            $table->unique(['post_id', 'locale']);

            // Indexes columns
            $table->index('locale');
            $table->index('post_id');
            $table->index(['title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_translations');
    }
};
