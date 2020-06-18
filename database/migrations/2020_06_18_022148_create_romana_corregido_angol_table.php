<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRomanaCorregidoAngolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('romana_corregido_angol', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folio_mop');
            $table->string('patente');
            $table->dateTimeTz('fecha',0);
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
        Schema::dropIfExists('romana_corregido_angol');
    }
}
