<?php

namespace App\Http\Controllers\Catatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatatanPenghapusanController extends Controller
{
    public function index()
    {
        $list = DB::select(
        "
        SELECT * from catatan
        JOIN users ON users.id = catatan.user_id_unit
        WHERE status = 4
        ");

        return view('dashboard.catatan.penghapusan.index',compact('list'));
    }

    public function show($id_catatan)
    {
        $catatan = DB::select(
        "
        SELECT * from catatan
        JOIN users ON users.id = catatan.user_id_unit
        WHERE id_catatan = ?
        ", array($id_catatan))[0];
    
        $barang = DB::select(
        "
        SELECT * from barang
        JOIN gudang ON gudang.id_gudang = barang.nama_gudang
        WHERE catatan_id = ?
        ", array($id_catatan));

        return view('dashboard.catatan.penghapusan.show',compact('catatan','barang'));
    }
}
