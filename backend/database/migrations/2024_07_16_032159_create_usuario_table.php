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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('Usuario', 25)->unique();
            $table->string('Clave', 100);
            $table->string('Estado', 13);
            $table->date('FechaIn');
            $table->date('FechaUp')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(\App\Models\Persona::class)->constrained("persona");         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
