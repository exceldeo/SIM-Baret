<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = DB::select("SELECT * from gudang");
        return view('dashboard.gudang.index',compact('gudang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'panjang' => 'required',
            'lebar' => 'required',
            'tinggi' => 'required',
            'lokasi' => 'required',
        ]);

        $message = "";
        try {
            $sisa = $request->panjang * $request->lebar * $request->tinggi;
            
            DB::insert(
                "
                INSERT INTO gudang
                (nama_gudang, panjang_gudang, lebar_gudang, tinggi_gudang, lokasi_gudang, ruang_sisa)
                VALUES (?, ?, ?, ?, ?, ?)
                ", array($request->nama, $request->panjang, $request->lebar, $request->tinggi, $request->lokasi, $sisa));

            $message = ["success" => "Gudang berhasil di buat!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.gudang.index')->with($message);
    }

    public function show($id)
    {
        $d_gudang = DB::select(
            "
            SELECT * from gudang
            WHERE id_gudang = ?
            ", array($id))[0];

        $as_gudang = DB::select(
            "
            SELECT * from master_barang
            WHERE gudang_id = ?
            ", array($id));

        return view('dashboard.gudang.show',compact('d_gudang','as_gudang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'panjang' => 'required',
            'lebar' => 'required',
            'tinggi' => 'required',
            'lokasi' => 'required',
        ]);

        $message = "";
        try {
            $gudang = DB::select("SELECT * from gudang WHERE id_gudang = ?", [$id])[0];
            $sisa = ($request->panjang * $request->lebar * $request->tinggi) - ($gudang->panjang_gudang * $gudang->lebar_gudang * $gudang->tinggi_gudang) + $gudang->ruang_sisa;

            DB::update(
                "
                UPDATE gudang SET
                nama_gudang = ?,
                panjang_gudang = ?,
                lebar_gudang = ?,
                tinggi_gudang = ?,
                lokasi_gudang = ?,
                ruang_sisa = ?
                WHERE id_gudang = ?
                ", array($request->nama, $request->panjang, $request->lebar, $request->tinggi, $request->lokasi, $sisa, $id));
            $message = ["success" => "Gudang berhasil di edit!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.gudang.index')->with($message);
    }

    public function destroy($id)
    {
        $message = "";
        try {
            DB::delete("DELETE from gudang WHERE id_gudang = ?", [$id]);

            $message = ["success" => "Gudang berhasil di hapus!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.gudang.index')->with($message);
    }
}
