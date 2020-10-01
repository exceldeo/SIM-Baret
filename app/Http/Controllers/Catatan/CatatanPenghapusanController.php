<?php

namespace App\Http\Controllers\Catatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        return view('dashboard.catatan.penghapusan.surat.index', ['id_catatan' => $id_catatan]);
    }

    public function showSurat($id_catatan, $jenis_surat)
    {
        return view('dashboard.catatan.penghapusan.surat.show', ['id_catatan' => $id_catatan, 'jenis_surat' => $jenis_surat]);
    }

    public function uploadSurat(Request $request)
    {
        try{
            if ($request->hasFile('surat')) {
                echo 'ada\n';
                //  Let's do everything here
                if ($request->file('surat')->isValid()) {
                    //
                    $validated = $request->validate([
                        'surat' => 'mimes:jpeg,png|max:1014',
                    ]);
                    $extension = $request->surat->extension();
                    $filename = 'abcde'.'.'.$extension;
                    $request->surat->storeAs('public', $filename);
                    $url = Storage::url($filename);
                    DB::insert("INSERT INTO file_catatan (catatan_id, jenis_surat, image_url) VALUES(?, ?, ?)", [$request->catatan_id, $request->jenis_surat, $url]);
                }
            }
            var_dump($request->surat);
        }catch(\Throwable $th){
            echo $th->getMessage();
        }

    }
}
