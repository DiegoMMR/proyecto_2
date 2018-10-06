<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuenta_id')->unsigned()->index();
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
            $table->integer('cuenta_terceros_id')->nullable()->unsigned()->index();
            $table->foreign('cuenta_terceros_id')->references('id')->on('cuentas_terceros')->onDelete('cascade');
            $table->string('tipo');
            $table->double('monto', 25, 2);
            $table->double('saldo_anterior', 25, 2);
            $table->double('saldo_nuevo', 25, 2);
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
        Schema::dropIfExists('movimientos');
    }
}
