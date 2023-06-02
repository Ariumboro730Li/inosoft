<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('mobils', function (Blueprint $collection) {
            // Add the fields for the "MOBILs" entity
            $collection->string('mesin');
            $collection->integer('kapasitas');
            $collection->string('tipe');
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
        Schema::connection('mongodb')->dropIfExists('mobils');
    }
}
