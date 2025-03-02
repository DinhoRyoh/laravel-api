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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('status')->nullable();
            // l'image sera en enregistré sous forme de texte en base 64
            $table->text('image');
            // je considère qu'un administrateur ne puisse pas être supprimé
            // ou dans le cas d'un soft delete, le profil sera toujours valable avec un administrateur existant mais inactif
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
