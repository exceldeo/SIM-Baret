<?php

namespace App\Http\Controllers\Catatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatatanPemasukanController extends Controller
{
    public function index()
    {
        $list = DB::select(
        "
        SELECT * from catatan
        JOIN users ON users.id = catatan.user_id_unit
        WHERE status = 2 ORDER BY catatan.tanggal_catatan DESC
        ");

        return view('dashboard.catatan.pemasukan.index',compact('list'));
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
        JOIN master_barang ON master_barang.barcode = barang.barcode
        WHERE catatan_id = ?
        ", array($id_catatan));


        return view('dashboard.catatan.pemasukan.show',compact('catatan','barang'));
    }
    
    public function print_barcode($id_catatan){
        $barang = DB::select(
            "
            SELECT komponen.kode_barang, barang.barcode, barang.nama_barang, komponen.nama_komponen
            FROM barang
            LEFT JOIN komponen ON barang.kode_barang = komponen.kode_barang
            WHERE barang.catatan_id = ? AND status = 1
            ORDER BY barcode
            ", array($id_catatan));
    
            return view('dashboard.catatan.pemasukan.print_barcode',compact('barang'));
    }
}
