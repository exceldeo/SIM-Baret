<?php

namespace App\Models\Gudang;

use Illuminate\Database\Eloquent\Model;

class gudang extends Model
{
    protected $table = 'gudang';
    protected $primaryKey = 'id_gudang';
    protected $guarded = ['id_gudang'];
}
