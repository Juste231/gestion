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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre'); 
            $table->text('description')->nullable(); 
            $table->enum('statut', ['non commencé', 'en cours', 'terminé'])->default('non commencé'); 
            $table->enum('priorite', ['faible', 'moyenne', 'élevée'])->default('moyenne'); 
            $table->foreignId('projet_id') 
                ->constrained('projets')
                ->onDelete('cascade');
            $table->foreignId('assigne_a')->nullable() 
                ->constrained('users') 
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
