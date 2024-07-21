<?php

use App\Models\Persona;
use App\Models\Rol;
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
            $table->string('Usuario');
            $table->string('Password');
            $table->string('Estado');
            $table->timestamps();
            $table->foreignIdFor(Rol::class)->constrained("rol");
            $table->foreignIdFor(Persona::class)->constrained("persona");
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
