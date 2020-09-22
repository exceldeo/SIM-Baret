<?php

namespace App\Http\Controllers\UsulanPemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang\gudang;

class UsulanPemasukanController extends Controller
{

    public function index()
    {
        $gudang = gudang::all();
        $carts = json_decode(request()->cookie('masuk-carts'), true);

        return view('dashboard.usulan_pemasukan.index',compact('carts','gudang'));
    }

    public function store(Request $request)
    {
        $message = "";
        $gudang = gudang::find($request->gudang_id);
        $carts = json_decode($request->cookie('masuk-carts'), true); 
        
        if($gudang->ruang_sisa <  ($request->panjang * $request->lebar * $request->tinggi)){
            $message = ["fail" => "Gudang melebihi kapasitas"];
        }
        else{
            try {
    
                $carts[date("ymdhis")] = [
                    'nama'      => $request->nama,
                    'panjang'   => $request->panjang,
                    'lebar'     => $request->lebar,
                    'tinggi'    => $request->tinggi,
                    'lokasi'    => $gudang->nama_gudang,
                    'id_gudang' => $request->gudang_id,
                ];
                $message = ["success" => "Barang berhasil di tambahkan!"];
    
            } catch (\Throwable $th) {
                $message = ["fail" => $th->getMessage()];
            }
        }

        $cookie = cookie('masuk-carts', json_encode($carts), 2880);
        return redirect()->back()->cookie($cookie)->with($message);
    }

    public function destroy(Request $request)
    {
        $message = "";
        $carts = json_decode($request->cookie('masuk-carts'), true); 
        try {

            unset($carts[$request->id]);

            $message = ["success" => "Barang berhasil di hapus!"];

        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        $cookie = cookie('masuk-carts', json_encode($carts), 2880);
    
        return redirect()->back()->cookie($cookie)->with($message);
    }
    public function save(Request $request)
    {
        $message = "";
        $carts = json_decode($request->cookie('masuk-carts'), true); 
        try {
            unset($carts);
            $message = ["success" => "Usulan berhasil di simpan!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        $cookie = cookie('masuk-carts', json_encode($carts), 2880);
        return redirect()->back()->with($message);
    }
}
