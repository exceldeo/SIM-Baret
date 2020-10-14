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
            $table->string('nup');
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang');
            $table->string('tanggal_peroleh');
            $table->string('merk_type')->nullable();
            $table->string('nilai_barang')->nullable();
            $table->float('panjang_barang');
            $table->float('lebar_barang');
            $table->float('tinggi_barang');
            $table->integer('jumlah');
            $table->integer('gudang_id');
            $table->dateTime('tanggal', 0);
            $table->integer('oke');
            $table->integer('titip');
            $table->string('unit');
            $table->string('kondisi')->nullable();
            $table->integer('validasi_oleh')->nullable();
            $table->dateTime('tanggal_validasi', 0)->nullable();
            $table->integer('status');
            // $table->timestamps();
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
