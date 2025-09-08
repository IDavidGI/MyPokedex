<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('found_pokemon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('pokemon_name');
            $table->timestamps();
            $table->unique(['user_id', 'pokemon_name']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('found_pokemon');
    }
};
