<?php

namespace App\Http\Controllers\Validasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidasiPenghapusanController extends Controller
{
    public function index()
    {
        $list = DB::select(
            "
            SELECT * from catatan
            JOIN users ON users.id = catatan.user_id_unit
            WHERE status = 3
            ");

        return view('dashboard.validasi.penghapusan.index',compact('list'));
    }

    public function show($id_catatan)
    {
        $catatan = DB::select(
            "
            SELECT * from catatan
            JOIN users ON users.id = catatan.user_id_unit
            WHERE id_catatan = ?
            ", [$id_catatan])[0];

        $barang = DB::select(
            "
            SELECT * from barang
            JOIN gudang ON gudang.id_gudang = barang.nama_gudang
            WHERE catatan_id = ?
            ", [$id_catatan]);
    
        return view('dashboard.validasi.penghapusan.show',compact('catatan','barang'));
    }

    public function save(Request $request)
    {
        $message = "";
        try {
            DB::update("UPDATE catatan set status = 4 WHERE id_catatan = ?", [$request->id_catatan]);
            foreach($request->row as $key => $row){
                DB::update("UPDATE barang set status = 1 WHERE id_barang = ?", [$key]);

                $barang = DB::select("SELECT * from barang WHERE id_barang = ?", [$key])[0];
                DB::delete("DELETE from master_barang WHERE barcode = ?", [$barang->barcode]);
                // MasterBarang::create([
                //     'nama_barang'       => $barang->nama_barang,
                //     'barcode'           => $barang->barcode,
                //     'panjang_barang'    => $barang->panjang_barang,
                //     'lebar_barang'      => $barang->lebar_barang,
                //     'tinggi_barang'     => $barang->tinggi_barang,
                //     'gudang_id'         => $barang->nama_gudang,
                //     'unit'              => "informatika",
                //     'tanggal'           => date("Y-m-d h:i:s"),
                //     'tervalidasi'       => 0
                // ]);
            }

            $message = ["success" => "Usulan berhasil tervalidasi"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.validasi.penghapusan.index')->with($message);
        
    }
    public function indexunit()
    {
        $list = DB::select(
            "
            SELECT * from catatan
            JOIN users ON users.id = catatan.user_id_unit
            WHERE status = 4
            ");

        return view('dashboard.validasi.penghapusan.unit.index',compact('list'));
    }

    public function showunit($id_catatan)
    {
        $catatan = DB::select(
            "
            SELECT * from catatan
            JOIN users ON users.id = catatan.user_id_unit
            WHERE id_catatan = ?
            ", [$id_catatan])[0];

        $barang = DB::select(
            "
            SELECT * from barang
            JOIN gudang ON gudang.id_gudang = barang.nama_gudang
            WHERE catatan_id = ?
            ", [$id_catatan]);
    
        return view('dashboard.validasi.penghapusan.unit.show',compact('catatan','barang'));
    }

    public function saveunit(Request $request)
    {
        $message = "";
        try {
            DB::update("UPDATE catatan set status = 4 WHERE id_catatan = ?", [$request->id_catatan]);
            foreach($request->row as $key => $row){
                DB::update("UPDATE barang set status = 1 WHERE id_barang = ?", [$key]);

                $barang = DB::select("SELECT * from barang WHERE id_barang = ?", [$key])[0];
                DB::delete("DELETE from master_barang WHERE barcode = ?", [$barang->barcode]);
                // MasterBarang::create([
                //     'nama_barang'       => $barang->nama_barang,
                //     'barcode'           => $barang->barcode,
                //     'panjang_barang'    => $barang->panjang_barang,
                //     'lebar_barang'      => $barang->lebar_barang,
                //     'tinggi_barang'     => $barang->tinggi_barang,
                //     'gudang_id'         => $barang->nama_gudang,
                //     'unit'              => "informatika",
                //     'tanggal'           => date("Y-m-d h:i:s"),
                //     'tervalidasi'       => 0
                // ]);
            }

            $message = ["success" => "Usulan berhasil tervalidasi"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.validasi.penghapusan.unit.index')->with($message);
        
    }

    public function print($id_catatan)
    {
        $barang = DB::select(
            "
            SELECT * from barang
            WHERE catatan_id = ?
            ", [$id_catatan]);
            // dd($barang);
            
        return view('dashboard.validasi.penghapusan.print',compact('barang'));
    }
}
