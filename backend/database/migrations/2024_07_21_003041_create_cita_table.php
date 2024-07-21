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
        Schema::create('cita', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\agendadetalle::class)->constrained("agendadetalle");
            $table->string('Tipo');
            $table->string('Estado');
            $table->string('Descripcion');
           // $table->foreignIdFor(\App\Models\Medico::class)->constrained("medico");
            $table->foreignIdFor(\App\Models\Paciente::class)->constrained("paciente");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita');
    }
};
