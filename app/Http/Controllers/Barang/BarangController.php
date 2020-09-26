<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang\MasterBarang;

class BarangController extends Controller
{
    public function index()
    {
        $assets = MasterBarang::join('gudang','gudang.id_gudang','=','master_barang.gudang_id')->get();
        // dd($assets);

        return view('dashboard.barang.index',compact('assets'));
    }

    public function show($id)
    {
        //
    }

}
