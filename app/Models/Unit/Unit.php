<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'id_unit';
    protected $guarded = ['id_unit'];
}
