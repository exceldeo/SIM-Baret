<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $results = DB::select('SELECT * from master_barang LEFT JOIN gudang ON master_barang.gudang_id = gudang.id_gudang');
        $gudangs = DB::select('SELECT * from gudang');
        $cart_items = Cart::getContent();
        $del_carts = array();
        foreach($cart_items as $key => $item)
        {
            if($item['attributes']['role'] != 2) continue;
            array_push($del_carts, $key);
        }

        return view('dashboard.barang.index', ['results' => $results, 'gudangs' => $gudangs, 'del_carts' => $del_carts]);
    }

    public function show($id)
    {
        $result = DB::select(
        "SELECT * from master_barang 
        LEFT JOIN gudang ON master_barang.gudang_id = gudang.id_gudang
        LEFT JOIN users ON master_barang.validasi_oleh = users.id
        WHERE id_master_barang = ?",
        array($id)
        );
        $gudangs = DB::select('SELECT * from gudang');

        if(count($result) > 0)
        {
            $isin_draft = FALSE;
            if(Cart::get($result[0]->barcode)){
                $isin_draft = TRUE;
            }
            return view('dashboard.barang.view', ['result' => $result[0], 'isin_draft' => $isin_draft, 'gudangs' => $gudangs]);
        }
        else
            return view('dashboard.barang.view');
    }

    // check if record with following barcode exists
    public function check($barcode)
    {
        $result['data'] = DB::select(
        "SELECT * from master_barang
        LEFT JOIN gudang ON master_barang.gudang_id = gudang.id_gudang 
        WHERE barcode = ?",
        array($barcode)
        )[0];

        $cart_items = Cart::getContent();
        $result['usulan_penghapusan'] = 0;
        foreach($cart_items as $key => $item)
        {
            if($item['attributes']['role'] == 2 && $key == $result['data']->barcode) $result['usulan_penghapusan'] = 1;
        }

        echo json_encode($result);
        exit;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $query =
        "BEGIN TRANSACTION;
 
        UPDATE master_barang
        SET nama_barang = ?, panjang_barang = ?, lebar_barang = ?, tinggi_barang = ?, gudang_id = ?
        WHERE id_master_barang = ?;
        
        UPDATE barang
        SET nama_barang = ?, panjang_barang = ?, lebar_barang = ?, tinggi_barang = ?, nama_gudang = ?
        WHERE id_barang = ?;
        
        COMMIT;";

        $values = array($request->nama, $request->panjang, $request->lebar, $request->tinggi, $request->gudang_id, $id);
        try{
            $result = DB::update($query, array_merge($values, $values));

            $message = ["success" => "Barang berhasil diperbarui!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->back()->with($message);
    }

    public function validateScan(Request $request)
    {
        $message = "";
        try {
            DB::update("UPDATE master_barang set tervalidasi = 1, validasi_oleh = ?, tanggal_validasi = ?
            where id_master_barang = ?", [Auth::user()->id, date("Y-m-d H:i:s"), $request->id]);

            $message = ["success" => "Barang berhasil divalidasi!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.scan')->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
