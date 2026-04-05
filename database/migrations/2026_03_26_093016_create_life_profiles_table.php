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
        Schema::create('life_profiles', function (Blueprint $table) {
$table->id();

    $table->enum('type', ['etudiant', 'famille', 'couple']);

    $table->decimal('budget_min', 10, 2)->nullable();
    $table->decimal('budget_max', 10, 2)->nullable();

    $table->string('location')->nullable();

    $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('life_profiles');
    }
};
