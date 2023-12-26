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
        Schema::create('historico_prova_materia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historico_prova_id');
            $table->unsignedBigInteger('materia_id');
            $table->integer('nota');
            $table->timestamps();

            $table->foreign('historico_prova_id')->references('id')->on('historico_prova');
            $table->foreign('materia_id')->references('id')->on('materias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_prova_materia');
    }
};
