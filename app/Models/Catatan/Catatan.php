<?php

namespace App\Models\Catatan;

use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    protected $table = 'catatan';
    protected $primaryKey = 'catatan_id';
    protected $guarded = ['catatan_id'];
}
