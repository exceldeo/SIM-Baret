<?php

namespace App\Models\Catatan;

use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    protected $table = 'catatan';
    protected $primaryKey = 'id_catatan';
    protected $guarded = ['id_catatan'];
}
