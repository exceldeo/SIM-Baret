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
        $carts = json_decode($request->cookie('masuk-carts'), true); 
        date_default_timezone_set('Asia/Jakarta');
        if($gudang->ruang_sisa <  ($request->panjang * $request->lebar * $request->tinggi)){
            $message = ["fail" => "Gudang melebihi kapasitas"];
        }
        else{
            try {
                $request->nilai = str_replace(",","",$request->nilai);
                // dd(intval($request->nilai)/$request->jml);
                Cart::add([
                    'id'        => date("ymdHis"),
                    'name'      => $request->nama,
                    'price'     => 1,
                    'quantity'  => 1,
                    'attributes' => array(
                        'kode'      => $request->kode,
                        'tanggal'   => $request->tanggal_peroleh,
                        'nup'       => $request->nup,
                        'merk'      => $request->merk,
                        'jml'       => $request->jml,
                        'nilai'     => intval($request->nilai)/$request->jml,
                        'kondisi'   => $request->kondisi,
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
    
    public function save(Request $request)
    {
        $message = "";
        try {

            unset($carts);
            date_default_timezone_set('Asia/Jakarta');
            $id = DB::table('catatan')->insertGetId([
                'tanggal_catatan' => date("Y-m-d H:i:s"),
                'user_id_unit' => 1,
                'status' => 1,
                'unit'  => 'informatika'
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
                    (kode_barang, barcode, nup, nama_barang, tanggal_peroleh, merk_type, 
                    nilai_barang, panjang_barang, lebar_barang, tinggi_barang, jumlah,
                    catatan_id, nama_gudang, status, unit, kondisi)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, -1, 'informatika', ?)
                    ", array($c['attributes']['kode'], $c['id'],$c['attributes']['nup'], $c['name'], 
                    $c['attributes']['tanggal'], $c['attributes']['merk'], $c['attributes']['nilai'],
                    $c['attributes']['panjang'], $c['attributes']['lebar'], $c['attributes']['tinggi'],
                    $c['attributes']['jml'],$id, $c['attributes']['id_gudang'], $c['attributes']['kondisi']));
            }
            
            Cart::clear();
            $message = ["success" => "Usulan berhasil di simpan!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
}
