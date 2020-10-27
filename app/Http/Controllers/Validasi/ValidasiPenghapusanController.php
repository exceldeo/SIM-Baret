<?php

namespace App\Http\Controllers\Validasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    
        // $tupoksi = DB::select("SELECT * FROM file_catatan WHERE catatan_id = ? AND jenis_surat = 8", [$id_catatan])[0];
        $uploaded = DB::select(
            "
            SELECT count(image_url) as count
            from jenis_surat
            LEFT JOIN file_catatan ON jenis_surat.id = file_catatan.jenis_surat
            AND (catatan_id = ?)
            WHERE mandatory = 1
            ", [$id_catatan])[0];
        $need_upload = DB::select("SELECT count(id) as count from jenis_surat WHERE mandatory = 1")[0];
        // var_dump($uploaded);
        // var_dump($need_upload);
        // return;
        $all_uploaded = ($uploaded == $need_upload);
        
        return view('dashboard.validasi.penghapusan.show',compact('catatan','barang', 'all_uploaded'));
    }

    public function save(Request $request)
    {
        $message = "";
        try {
            date_default_timezone_set('Asia/Jakarta');
            DB::update("UPDATE catatan set status = 4,tanggal_validasi = ?,validasi_oleh = ? WHERE id_catatan = ?", [date("Y-m-d H:i:s"),Auth::user()->id,$request->id_catatan]);
            foreach($request->row as $key => $row){
                // dd($row);
                DB::update("UPDATE barang set status = 1 WHERE id_barang = ?", [$key]);

                $barang = DB::select("SELECT * from barang WHERE id_barang = ?", [$key])[0];
                $master_barang = DB::select("SELECT * from master_barang WHERE barcode = ?", [$barang->barcode])[0];
                // dd($master_barang);
                if($master_barang->jumlah <= $barang->jumlah){
                    DB::delete("DELETE from master_barang WHERE barcode = ?", [$barang->barcode]);
                }
                else{
                    DB::update("UPDATE master_barang set jumlah = ?  WHERE barcode = ?", [$master_barang->jumlah - $barang->jumlah, $barang->barcode]);
                }


                $ruang_sisa = DB::select(
                    "
                    SELECT ruang_sisa from gudang
                    WHERE id_gudang = ?
                    ", [$barang->nama_gudang])[0];
                $ruang = $barang->panjang_barang * $barang->lebar_barang * $barang->tinggi_barang * $barang->jumlah;
                
                DB::update("UPDATE gudang set ruang_sisa = ?  WHERE id_gudang = ?", [$ruang_sisa->ruang_sisa + $ruang, $barang->nama_gudang]);

            }

            DB::update("UPDATE m 
            SET m.status = 1 
            FROM master_barang AS m
            INNER JOIN barang AS b ON m.barcode = b.barcode  
            WHERE b.catatan_id = ?", [$request->id_catatan]);
            
            $message = ["success" => "Usulan berhasil tervalidasi"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.validasi.penghapusan.index')->with($message);
        
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
