<?php

namespace App\Http\Controllers\UsulanPenghapusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;

class UsulanPenghapusanController extends Controller
{
    public function index()
    {
        $gudang = DB::select("SELECT * from gudang");
        $assets = DB::select(
            "
            SELECT * from master_barang
            JOIN gudang ON gudang.id_gudang = master_barang.gudang_id
            ");
        $carts = Cart::getContent();

        return view('dashboard.usulan_penghapusan.index',compact('carts','assets'));
    }

    public function store(Request $request)
    {
        $message = "";
        try {
            $asset = DB::select(
                "
                SELECT * from master_barang
                JOIN gudang ON gudang.id_gudang = master_barang.gudang_id
                WHERE id_master_barang = ?
                ", [$request->id])[0];

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
            $message = ["success" => "Barang berhasil ditambahkan ke Usulan Penghapusan!"];

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

            $message = ["success" => "Barang berhasil dihapus dari Usulan Penghapusan!"];

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
                'status' => 3
            ]);

            $carts = Cart::getContent();

            foreach($carts as $c){
                if($c['attributes']['role'] == 1){
                    continue;
                }
                
                DB::insert(
                    "
                    INSERT INTO barang
                    (barcode, nama_barang, panjang_barang, lebar_barang, tinggi_barang, catatan_id, status, unit, nama_gudang)
                    VALUES (?, ?, ?, ?, ?, ?, -1, ?, ?)
                    ", array($c['id'], $c['name'], $c['attributes']['panjang'], $c['attributes']['lebar'], $c['attributes']['tinggi'],
                $id, $c['attributes']['unit'], $c['attributes']['id_gudang']));
            }

            Cart::clear();
            $message = ["success" => "Usulan berhasil di simpan!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
}
