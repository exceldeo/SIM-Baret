<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang\gudang;
use App\Models\Barang\MasterBarang;

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
            $sisa = $request->panjang * $request->lebar * $request->tinggi;
            gudang::create([
                'nama_gudang' => $request->nama,
                'panjang_gudang' => $request->panjang,
                'lebar_gudang' => $request->lebar,
                'tinggi_gudang' => $request->tinggi,
                'lokasi_gudang' => $request->lokasi,
                'ruang_sisa'    => $sisa
            ]);

            $message = ["success" => "Gudang berhasil di buat!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.gudang.index')->with($message);
    }

    public function show($id)
    {
        $d_gudang = gudang::where('id_gudang',$id)->first();
        $as_gudang = MasterBarang::where('gudang_id',$id)->get();
        // dd($as_gudang);

        return view('dashboard.gudang.show',compact('d_gudang','as_gudang'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'nama' => 'required',
            'panjang' => 'required',
            'lebar' => 'required',
            'tinggi' => 'required',
            'lokasi' => 'required',
        ]);

        $message = "";
        try {
            $gudang = gudang::where('id_gudang',$id)->first();
            // dd($request->panjang * $request->lebar * $request->tinggi,$gudang->panjang_gudang * $gudang->lebar_gudang * $gudang->tinggi_gudang,$gudang->ruang_sisa);
            $sisa = ($request->panjang * $request->lebar * $request->tinggi) - ($gudang->panjang_gudang * $gudang->lebar_gudang * $gudang->tinggi_gudang) + $gudang->ruang_sisa;

            gudang::where('id_gudang',$id)
            ->update([
                'nama_gudang' => $request->nama,
                'panjang_gudang' => $request->panjang,
                'lebar_gudang' => $request->lebar,
                'tinggi_gudang' => $request->tinggi,
                'lokasi_gudang' => $request->lokasi,
                'ruang_sisa'    => $sisa
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
