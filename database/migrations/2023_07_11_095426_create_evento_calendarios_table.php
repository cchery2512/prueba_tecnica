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
        Schema::create('evento_calendario', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->foreignId('tipo_evento_id')->constrained('tipo_evento', 'id');
            $table->timestamp('fecha_hora_inicio');
            $table->timestamp('fecha_hora_fin');
            $table->foreignId('usuario_crea')->constrained('users', 'id');
            $table->foreignId('usuario_modifica')->nullable()->constrained('users', 'id');
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_calendario');
    }
};
