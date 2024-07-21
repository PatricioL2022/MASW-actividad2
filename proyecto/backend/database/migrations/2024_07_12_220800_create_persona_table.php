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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('Identificacion');
            $table->string('Nombres');
            $table->string('Apellidos');
            $table->string('TipoIdentificacion');
            $table->string('Genero');
            $table->string('Direccion');
            $table->string('Telefono');
            $table->string('Correo');
            $table->string('Titulo');
            $table->string('FechaNacimiento');
            $table->string('Foto');
            $table->string('GrupoSanguineo');
            $table->string('Estado');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
