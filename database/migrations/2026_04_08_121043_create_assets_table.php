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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->json('variants')->nullable()->default('[]');
            $table->foreignId('category_id')->nullable()->constrained('team_categories')->nullOnDelete();
            $table->json('tags')->nullable()->default('[]');
            $table->dateTime('publish_at')->nullable();
            $table->dateTime('hide_at')->nullable();
            $table->foreignId('creator_id')->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['team_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
