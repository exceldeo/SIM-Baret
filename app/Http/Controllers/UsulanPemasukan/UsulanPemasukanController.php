<?php

namespace App\Http\Controllers\UsulanPemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang\gudang;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class UsulanPemasukanController extends Controller
{

    public function index()
    {
        $gudang = gudang::all();
        $carts = Cart::getContent();
        // dd($carts);

        return view('dashboard.usulan_pemasukan.index',compact('carts','gudang'));
    }

    public function store(Request $request)
    {
        $message = "";
        $gudang = gudang::find($request->gudang_id);
        
        if($gudang->ruang_sisa <  ($request->panjang * $request->lebar * $request->tinggi)){
            $message = ["fail" => "Gudang melebihi kapasitas"];
        }
        else{
            try {
                Cart::add([
                    'id'        => date("ymdhis"),
                    'name'      => $request->nama,
                    'price'     => 1,
                    'quantity'  => 1,
                    'attributes' => array(
                        'panjang'   => $request->panjang,
                        'lebar'     => $request->lebar,
                        'tinggi'    => $request->tinggi,
                        'lokasi'    => $gudang->nama_gudang,
                        'id_gudang' => $request->gudang_id,
                    ),
                ]);
                // Cart::instance('shopping')->add(date("ymdhis"), $request->nama, 0,0,[
                //     'panjang'   => $request->panjang,
                //     'lebar'     => $request->lebar,
                //     'tinggi'    => $request->tinggi,
                //     'lokasi'    => $gudang->nama_gudang,
                //     'id_gudang' => $request->gudang_id,
                // ]);
                // $carts = Cart::getContent();
                // dd($carts);
                // Cart::add(array(
                //     'id'        => date("ymdhis"),
                //     'nama'      => $request->nama,
                //     'panjang'   => $request->panjang,
                //     'lebar'     => $request->lebar,
                //     'tinggi'    => $request->tinggi,
                //     'lokasi'    => $gudang->nama_gudang,
                //     'id_gudang' => $request->gudang_id,
                // ));
                // $carts[date("ymdhis")] = [
                //     'nama'      => $request->nama,
                //     'panjang'   => $request->panjang,
                //     'lebar'     => $request->lebar,
                //     'tinggi'    => $request->tinggi,
                //     'lokasi'    => $gudang->nama_gudang,
                //     'id_gudang' => $request->gudang_id,
                // ];
                $message = ["success" => "Barang berhasil di tambahkan!"];
    
            } catch (\Throwable $th) {
                $message = ["fail" => $th->getMessage()];
            }
        }

        // $cookie = cookie('masuk-carts', json_encode($carts), 2880);
        return redirect()->back()->with($message);
    }

    public function destroy(Request $request)
    {
        $message = "";
        try {
            Cart::remove($request->id);

            $message = ["success" => "Barang berhasil di hapus!"];

        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
    public function save(Request $request)
    {
        $message = "";
        try {
            Cart::clear();
            $message = ["success" => "Usulan berhasil di simpan!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
}
