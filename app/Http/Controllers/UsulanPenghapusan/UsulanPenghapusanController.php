<?php

namespace App\Http\Controllers\UsulanPenghapusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang\gudang;
use App\Models\Catatan\Catatan;
use App\Models\Barang\Barang;
use App\Models\Barang\MasterBarang;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class UsulanPenghapusanController extends Controller
{
    public function index()
    {
        $gudang = gudang::all();
        $assets = MasterBarang::join('gudang','gudang.id_gudang','=','master_barang.gudang_id')->get();
        $carts = Cart::getContent();
        // dd($assets);

        return view('dashboard.usulan_penghapusan.index',compact('carts','assets'));
    }

    public function store(Request $request)
    {
        $message = "";
        try {
            $asset = MasterBarang::where('id_master_barang',$request->id)->join('gudang','gudang.id_gudang','=','master_barang.gudang_id')->first();
            Cart::add([
                'id'        => $asset->barcode,
                'name'      => $asset->nama_barang,
                'price'     => 1,
                'quantity'  => 1,
                'attributes' => array(
                    'panjang'   => $asset->panjang_barang,
                    'lebar'     => $asset->lebar_barang,
                    'tinggi'    => $asset->tinggi_barang,
                    'lokasi'    => $asset->nama_gudang,
                    'id_gudang' => $asset->id_gudang,
                    'unit'      => $asset->unit,
                    'role'      => 2
                ),
            ]);
            $message = ["success" => "Barang berhasil di tambahkan!"];

        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

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
            $catatan->status            = 3;
            $catatan->save();

            $carts = Cart::getContent();

            foreach($carts as $c){
                if($c['attributes']['role'] == 1){
                    continue;
                }
                $barang                     = new Barang;
                $barang->barcode            = $c['id'];
                $barang->nama_barang        = $c['name'];
                $barang->panjang_barang     = $c['attributes']['panjang'];  
                $barang->lebar_barang       = $c['attributes']['lebar'];
                $barang->tinggi_barang      = $c['attributes']['tinggi'];       
                $barang->catatan_id         = $catatan->id_catatan;  
                $barang->status             = -1;  
                $barang->unit               = $c['attributes']['unit'];  
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
