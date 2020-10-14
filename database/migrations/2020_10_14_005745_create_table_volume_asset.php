<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVolumeAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_vol_asset', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->float('panjang_barang');
            $table->float('lebar_barang');
            $table->float('tinggi_barang');
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
        Schema::dropIfExists('kategori_vol_asset');
    }
}
