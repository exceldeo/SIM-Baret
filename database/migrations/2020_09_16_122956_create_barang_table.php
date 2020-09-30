<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('kode_barang');
            $table->string('barcode');
            $table->string('nup');
            $table->string('nama_barang');
            $table->string('tanggal_peroleh');
            $table->string('merk_type')->nullable();
            $table->string('nilai_barang')->nullable();
            $table->float('panjang_barang');
            $table->float('lebar_barang');
            $table->float('tinggi_barang');
            $table->integer('jumlah');
            $table->integer('catatan_id');
            $table->integer('status');
            $table->string('unit');
            $table->string('kondisi')->nullable();
            $table->string('nama_gudang')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('barang');
    }
}
