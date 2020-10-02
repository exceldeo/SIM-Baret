<?php

namespace App\Http\Controllers\Catatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

    public function surat($id_catatan)
    {
        $result = DB::select(
            "
            SELECT jenis_surat.id, jenis_surat.jenis_surat, file_catatan.image_url, file_catatan.catatan_id,
            file_catatan.waktu_upload, file_catatan.validasi_oleh
            from jenis_surat
            LEFT JOIN file_catatan ON jenis_surat.id = file_catatan.jenis_surat
            AND (catatan_id = ?)
            ORDER BY jenis_surat.id
            ",[$id_catatan]);
        return view('dashboard.catatan.penghapusan.surat.index', ['result' => $result, 'id_catatan' => $id_catatan]);
    }

    public function showSurat($id_catatan, $jenis_surat)
    {
        return view('dashboard.catatan.penghapusan.surat.show', ['id_catatan' => $id_catatan, 'jenis_surat' => $jenis_surat]);
    }

    public function uploadSurat(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');
        $message = "";

        try{
            if ($request->hasFile('surat')) {
                //  Let's do everything here
                if ($request->file('surat')->isValid()) {
                    //
                    // $validated = $request->validate([
                    //     'surat' => 'mimes:jpeg,png|max:1014',
                    // ]);
                    $extension = $request->surat->extension();
                    $filename = 'abcde'.'.'.$extension;
                    $request->surat->storeAs('public', $filename);
                    $url = Storage::url($filename);
                    DB::insert("INSERT INTO file_catatan (catatan_id, jenis_surat, image_url, waktu_upload, validasi_oleh) VALUES(?, ?, ?, ?, ?)", 
                    [$request->catatan_id, $request->jenis_surat, $url, date("Y-m-d H:i:s"), "Bambang"]);
                }
            }
            $message = ["success" => "Gudang berhasil di buat!"];

        }catch(\Throwable $th){
            $message = ["fail" => $th->getMessage()];

        }
        return redirect()->back()->with($message);

    }
}
