<?php

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
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->string('NumeroExpediente');
            $table->string('Estado');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(Persona::class)->constrained("persona");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
