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
        Schema::create('consultorio', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Ruc');
            $table->string('NombreComercial');
            $table->string('Direccion');
            $table->string('Telefono');
            $table->string('PorcentajeIva');
            $table->string('Logo');
            $table->string('Correo');
            $table->string('DireccionMatriz');
            $table->string('Estado');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio');
    }
};
