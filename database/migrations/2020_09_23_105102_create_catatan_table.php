<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan', function (Blueprint $table) {
            $table->increments('id_catatan');
            $table->dateTime('tanggal_catatan', 0);
            $table->string('unit')->nullable();
            $table->integer('user_id_unit');
            $table->integer('validasi_oleh')->nullable();
            $table->integer('status');
            $table->dateTime('tanggal_validasi', 0)->nullable();
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
        Schema::dropIfExists('catatan');
    }
}
