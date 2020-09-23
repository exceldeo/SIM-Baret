<?php

namespace App\Http\Controllers\UsulanPemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang\gudang;
use App\Models\Catatan\Catatan;
use App\Models\Barang\Barang;
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
                        'role'      => 1
                    ),
                ]);
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
    public function save()
    {
        $message = "";
        try {
            $catatan                    = new Catatan;
            $catatan->tanggal_catatan   = date("Y-m-d h:i:s");
            $catatan->user_id_unit      = 1;
            $catatan->status            = 1;
            $catatan->save();

            $carts = Cart::getContent();

            foreach($carts as $c){
                $barang                     = new Barang;
                $barang->barcode            = $c['id'];
                $barang->nama_barang        = $c['name'];
                $barang->panjang_barang     = $c['attributes']['panjang'];  
                $barang->lebar_barang       = $c['attributes']['lebar'];
                $barang->tinggi_barang      = $c['attributes']['tinggi'];       
                $barang->catatan_id         = $catatan->id_catatan;  
                $barang->status             = -1;  
                $barang->nama_gudang        = $c['attributes']['id_gudang']; 
                $barang->save();
            }

            Cart::clear();
            $message = ["success" => "Usulan berhasil di simpan!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
}
