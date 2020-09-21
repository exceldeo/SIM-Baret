<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang\gudang;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = gudang::all();
        // dd($gudang);
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

            gudang::create([
                'nama_gudang' => $request->nama,
                'panjang_gudang' => $request->panjang,
                'lebar_gudang' => $request->lebar,
                'tinggi_gudang' => $request->tinggi,
                'lokasi_gudang' => $request->lokasi,
            ]);

            $message = ["success" => "Gudang berhasil di buat!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.gudang.index')->with($message);
    }

    public function show($id)
    {
        
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

            gudang::where('id_gudang',$id)
            ->update([
                'nama_gudang' => $request->nama,
                'panjang_gudang' => $request->panjang,
                'lebar_gudang' => $request->lebar,
                'tinggi_gudang' => $request->tinggi,
                'lokasi_gudang' => $request->lokasi,
            ]);

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
            gudang::where('id_gudang',$id)->first()->delete();

            $message = ["success" => "Gudang berhasil di hapus!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.gudang.index')->with($message);
    }
}
