<?php

namespace App\Http\Controllers\Catatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan\Catatan;
use App\Models\Barang\Barang;

class CatatanPenghapusanController extends Controller
{
    public function index()
    {
        $list = Catatan::where('status',4)->join('users','users.id','=','catatan.user_id_unit')->get();
        // dd($list);
        return view('dashboard.catatan.penghapusan.index',compact('list'));
    }

    public function show($id_catatan)
    {
        $catatan = Catatan::where('id_catatan',$id_catatan)->join('users','users.id','=','catatan.user_id_unit')->first();
        $barang = Barang::where('catatan_id',$id_catatan)->join('gudang','gudang.id_gudang','=','barang.nama_gudang')->get();
        // dd($barang);

        return view('dashboard.catatan.penghapusan.show',compact('catatan','barang'));
    }
}
