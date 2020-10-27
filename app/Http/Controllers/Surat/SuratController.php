<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function index($id_catatan)
    {
        $result = DB::select(
            "
            SELECT jenis_surat.id, jenis_surat.jenis_surat, file_catatan.image_url, file_catatan.catatan_id, jenis_surat.mandatory,
            file_catatan.waktu_upload, file_catatan.upload_oleh
            from jenis_surat
            LEFT JOIN file_catatan ON jenis_surat.id = file_catatan.jenis_surat
            AND (catatan_id = ?)
            ORDER BY jenis_surat.id
            ",[$id_catatan]);
        return view('dashboard.surat.index', ['result' => $result, 'id_catatan' => $id_catatan]);
    }

    public function indexLog($id_catatan)
    {
        $result = DB::select(
            "
            SELECT jenis_surat.id, jenis_surat.jenis_surat, file_catatan.image_url, file_catatan.catatan_id,
            file_catatan.waktu_upload, file_catatan.upload_oleh
            from jenis_surat
            LEFT JOIN file_catatan ON jenis_surat.id = file_catatan.jenis_surat
            AND (catatan_id = ?)
            ORDER BY jenis_surat.id
            ",[$id_catatan]);
        return view('dashboard.surat.indexLog', ['result' => $result, 'id_catatan' => $id_catatan]);
    }

    public function upload(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');
        $message = "";

        try{
            if ($request->hasFile('surat')) {
                if ($request->file('surat')->isValid()) {
                    //
                    $validated = $request->validate([
                        'surat' => 'mimes:jpeg,png,pdf|max:10240',
                    ]);
                    $extension = $request->surat->extension();
                    $filename = $request->catatan_id.'_'.$request->jenis_surat.'_'.date("YmdHis").'.'.$extension;
                    $request->surat->storeAs('public', $filename);
                    $url = Storage::url($filename);
                    DB::insert("INSERT INTO file_catatan (catatan_id, jenis_surat, image_url, waktu_upload, upload_oleh) VALUES(?, ?, ?, ?, ?)", 
                    [$request->catatan_id, $request->jenis_surat, $url, date("Y-m-d H:i:s"), Auth::user()->nama_user]);
                }
            }
            $message = ["success" => "File berhasil ditambahkan"];

        }catch(\Throwable $th){
            $message = ["fail" => $th->getMessage()];

        }
        return redirect()->back()->with($message);

    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');
        $message = "";

        try{
            if ($request->hasFile('surat')) {
                if ($request->file('surat')->isValid()) {
                    //
                    $validated = $request->validate([
                        'surat' => 'mimes:jpeg,png,pdf|max:10240',
                    ]);
                    $extension = $request->surat->extension();
                    $filename = $request->catatan_id.'_'.$request->jenis_surat.'_'.date("YmdHis").'.'.$extension;
                    $request->surat->storeAs('public', $filename);
                    $url = Storage::url($filename);
                    DB::update("UPDATE file_catatan set image_url = ?, waktu_upload = ?, upload_oleh = ? WHERE catatan_id = ? AND jenis_surat = ?", 
                    [$url, date("Y-m-d H:i:s"), Auth::user()->nama_user, $request->catatan_id, $request->jenis_surat]);
                }
            }
            $message = ["success" => "File berhasil diubah"];

        }catch(\Throwable $th){
            $message = ["fail" => $th->getMessage()];

        }
        return redirect()->back()->with($message);

    }
}
