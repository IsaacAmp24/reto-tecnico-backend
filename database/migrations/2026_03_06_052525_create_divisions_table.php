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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->unique();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('divisions')
                ->nullOnDelete();

            // nivel y la cant. colabs deben ser enteros positivos aleatorios
            $table->unsignedInteger('level')->comment('Nivel de la división');
            $table->unsignedInteger('collaborators')->comment('Cantidad de colaboradores');

            // embajadores con nombre completo
            $table->string('ambassadors', 120)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
