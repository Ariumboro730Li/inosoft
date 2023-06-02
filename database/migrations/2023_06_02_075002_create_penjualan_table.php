<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('penjualans', function (Blueprint $collection) {
            $collection->index('kendaraan_id');
            $collection->string('nama');
            $collection->string('type_kendaraan');
            $collection->date('tanggal');
            $collection->string('jumlah');
            $collection->string('alamat');
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
        Schema::connection('mongodb')->dropIfExists('penjualans');
    }
}
