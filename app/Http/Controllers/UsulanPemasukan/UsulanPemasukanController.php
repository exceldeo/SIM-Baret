<?php

namespace App\Http\Controllers\UsulanPemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;

class UsulanPemasukanController extends Controller
{

    public function index()
    {
        $gudang = DB::select("SELECT * from gudang");
        $carts = Cart::getContent();

        return view('dashboard.usulan_pemasukan.index',compact('carts','gudang'));
    }

    public function store(Request $request)
    {
        $message = "";
        $gudang = DB::select("SELECT * from gudang WHERE id_gudang = ?", [$request->gudang_id])[0];
        
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

            $id = DB::table('catatan')->insertGetId([
                'tanggal_catatan' => date("Y-m-d h:i:s"),
                'user_id_unit' => 1,
                'status' => 1
            ]);
            $carts = Cart::getContent();

            foreach($carts as $c){
                if($c['attributes']['role'] == 2){
                    continue;
                }
                // $barang                     = new Barang;
                // $barang->barcode            = $c['id'];
                // $barang->nama_barang        = $c['name'];
                // $barang->panjang_barang     = $c['attributes']['panjang'];  
                // $barang->lebar_barang       = $c['attributes']['lebar'];
                // $barang->tinggi_barang      = $c['attributes']['tinggi'];       
                // $barang->catatan_id         = $catatan->id_catatan;  
                // $barang->status             = -1;  
                // $barang->unit               = "informatika";  
                // $barang->nama_gudang        = $c['attributes']['id_gudang']; 
                // $barang->save();

                DB::insert(
                    "
                    INSERT INTO barang
                    (barcode, nama_barang, panjang_barang, lebar_barang, tinggi_barang, catatan_id, status, unit, nama_gudang)
                    VALUES (?, ?, ?, ?, ?, ?, -1, 'informatika', ?)
                    ", array($c['id'], $c['name'], $c['attributes']['panjang'], $c['attributes']['lebar'], $c['attributes']['tinggi'],
                $id, $c['attributes']['id_gudang']));
            }

            Cart::clear();
            $message = ["success" => "Usulan berhasil di simpan!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
}
