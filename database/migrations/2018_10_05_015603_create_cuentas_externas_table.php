<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasExternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_externas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->double('saldo', 25, 2);
            $table->integer('estado')->default(1);
            $table->double('limite_monto', 25, 2);
            $table->integer('limite_transacciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentas_externas');
    }
}
