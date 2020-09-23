<?php

namespace App\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    protected $table = 'master_barang';
    protected $primaryKey = 'id_master_barang';
    protected $guarded = ['id_master_barang'];
}
