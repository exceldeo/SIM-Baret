<?php

namespace App\Http\Controllers\Validasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\Validasi\PemasukanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ValidasiPemasukanController extends Controller
{
    public function index()
    {
        $list = DB::select(
            "
            SELECT * from catatan
            JOIN users ON users.id = catatan.user_id_unit
            WHERE status = 1 ORDER BY catatan.tanggal_catatan DESC
            ");
            
        return view('dashboard.validasi.pemasukan.index',compact('list'));
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
            // dd($barang);
        return view('dashboard.validasi.pemasukan.show',compact('catatan','barang'));
    }

    public function save(Request $request)
    {
        $message = "";
        try {
            date_default_timezone_set('Asia/Jakarta');
            DB::update("UPDATE catatan set status = 2,tanggal_validasi = ?, validasi_oleh = ? WHERE id_catatan = ?", [date("Y-m-d H:i:s"),Auth::user()->id,$request->id_catatan]);;
            foreach($request->row as $key => $row){
                DB::update("UPDATE barang set status = 1 WHERE id_barang = ?", [$key]);

                $barang = DB::select("SELECT * from barang WHERE id_barang = ?", [$key])[0];
                // dd($barang);
                DB::insert(
                    "
                    INSERT INTO master_barang
                    (nama_barang, barcode, panjang_barang, lebar_barang, tinggi_barang, gudang_id, unit, tanggal, 
                    nup, tanggal_peroleh, merk_type, nilai_barang, jumlah, kondisi, kode_barang, lengkap)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?, 0)
                    ", array($barang->nama_barang, $barang->barcode, $barang->panjang_barang, $barang->lebar_barang, $barang->tinggi_barang,
                    $barang->nama_gudang,$barang->unit, date("Y-m-d H:i:s"),  
                    $barang->nup, $barang->tanggal_peroleh, $barang->merk_type, $barang->nilai_barang, $barang->jumlah, $barang->kondisi, $barang->kode_barang));
                $ruang_sisa = DB::select(
                    "
                    SELECT ruang_sisa from gudang
                    WHERE id_gudang = ?
                    ", [$barang->nama_gudang])[0];
                $ruang = $barang->panjang_barang * $barang->lebar_barang * $barang->tinggi_barang * $barang->jumlah;
                
                DB::update("UPDATE gudang set ruang_sisa = ?  WHERE id_gudang = ?", [$ruang_sisa->ruang_sisa - $ruang, $barang->nama_gudang]);
            }

            $message = ["success" => "Usulan berhasil tervalidasi"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.validasi.pemasukan.index')->with($message);
        
    }
    public function print($id_catatan)
    {
        $barang = DB::select(
            "
            SELECT * from barang
            WHERE catatan_id = ?
            ", [$id_catatan]);
            // dd($barang);
            
        return view('dashboard.validasi.pemasukan.print',compact('barang'));
    }

    public function export($id_catatan) 
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

        return Excel::download(new PemasukanExport($catatan,$barang), $catatan->unit.'_'.substr($catatan->tanggal_catatan,0,10).'.xlsx');
    }

}
