<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileCatatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_catatan', function (Blueprint $table) {
            $table->increments('id_file_catatan');
            $table->integer('catatan_id');
            $table->integer('jenis_surat');
            $table->string('image_url')->nullable();
            $table->dateTime('waktu_upload', 0)->nullable();
            $table->string('upload_oleh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_catatan');
    }
}
