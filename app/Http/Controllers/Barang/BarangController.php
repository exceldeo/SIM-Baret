<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = DB::select('SELECT * from master_barang LEFT JOIN gudang ON master_barang.gudang_id = gudang.id_gudang');
        $gudangs = DB::select('SELECT * from gudang');
        return view('dashboard.barang.index', ['results' => $results, 'gudangs' => $gudangs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = DB::select(
        "SELECT * from master_barang 
        LEFT JOIN gudang ON master_barang.gudang_id = gudang.id_gudang
        WHERE id_master_barang = ?",
        array($id)
        );

        if(count($result) > 0)
            return view('dashboard.barang.view', ['result' => $result[0]]);
        else
            return view('dashboard.barang.view');
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

        return redirect()->route('dashboard.barang.index')->with($message);
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
