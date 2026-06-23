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
        Schema::create('team_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->integer('parent_id')->default(-1)->index();
            $table->string('title')->required();
            $table->string('slug')->required()->unique();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->string('prefix')->nullable();
            $table->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete();

            $table->unique(['team_id', 'slug']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_categories');
    }
};
