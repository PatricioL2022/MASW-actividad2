<?php

use App\Models\Consultorio;
use App\Models\Persona;
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
        Schema::create('medico', function (Blueprint $table) {
            $table->id();
            $table->string('Especialidad');
            $table->string('Subespecialidad');
            $table->string('NumeroCarnet');
            $table->string('Estado');
            $table->timestamps();
            $table->foreignIdFor(Persona::class)->constrained("persona");
            $table->foreignIdFor(Consultorio::class)->constrained("consultorio");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medico');
    }
};
