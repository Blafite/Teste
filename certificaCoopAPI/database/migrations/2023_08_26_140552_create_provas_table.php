<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    
    {
        Schema::create('provas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('nome_prova');
            $table->string('codigo');
            $table->unsignedBigInteger('materia_id');
            $table->integer('questoes_facil');
            $table->integer('questoes_intermediaria');
            $table->integer('questoes_dificil');
            $table->integer('percentual_aprovacao');
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('usuarios');
            $table->foreign('materia_id')->references('id')->on('materias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provas');
    }
};
