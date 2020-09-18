<?php

namespace App\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'scenario';
    protected $primaryKey = 'scenario_id';
    protected $guarded = ['scenario_id'];
}
