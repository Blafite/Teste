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
    Schema::create('historico_pagamento', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('transacao_id');
        $table->decimal('valor_pago', 10, 2);
        $table->timestamps();

        $table->foreign('transacao_id')->references('id')->on('transacoes');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_pagamento');
    }
};
