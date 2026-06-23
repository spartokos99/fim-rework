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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#555555');
            $table->json('settings')->nullable();
            $table->string('image')->nullable();

            $table->foreignId('owner_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->unique(['slug']);
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Team::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->primary(['team_id', 'user_id']);

            $table->unique(['team_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_user');
    }
};
