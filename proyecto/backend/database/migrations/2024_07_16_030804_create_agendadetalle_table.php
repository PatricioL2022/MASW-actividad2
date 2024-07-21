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
        Schema::create('agendadetalle', function (Blueprint $table) {
            $table->id();
            $table->time('HoraInicio');
            $table->time('HoraFin');
            $table->string('Estado');
            $table->timestamps();
            $table->foreignIdFor(\App\Models\Agenda::class)->constrained("agenda");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendadetalle');
    }
};
