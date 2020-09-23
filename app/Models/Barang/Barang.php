<?php

namespace App\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $guarded = ['id_barang'];
}
