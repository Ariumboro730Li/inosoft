<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('motors', function (Blueprint $collection) {
            // Add the fields for the "MOTOR" entity
            $collection->string('mesin');
            $collection->string('tipe suspensi');
            $collection->string('tipe_transmisi');
            $collection->index('kendaraan_id');
            $collection->string('stok');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('motors');
    }
}
