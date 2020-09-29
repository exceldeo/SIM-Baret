<?php

namespace App\Models\Catatan;

use Illuminate\Database\Eloquent\Model;

class FileCatatan extends Model
{
    protected $table = 'file_catatan';
    protected $primaryKey = 'id_file_catatan';
    protected $guarded = ['id_file_catatan'];
}
