<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_barang', function (Blueprint $table) {
            $table->increments('id_master_barang');
            $table->string('barcode')->unique();
            $table->string('nama_barang');
            $table->float('panjang_barang');
            $table->float('lebar_barang');
            $table->float('tinggi_barang');
            $table->integer('gudang_id');
            $table->dateTime('tanggal', 0);
            $table->integer('tervalidasi');
            $table->integer('validasi_oleh');
            $table->dateTime('tanggal_validasi', 0);
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
        Schema::dropIfExists('master_barang');
    }
}
