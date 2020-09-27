<?php

namespace App\Http\Controllers\Validasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan\Catatan;
use App\Models\Barang\Barang;
use App\Models\Barang\MasterBarang;
use App\Models\Gudang\gudang;

class ValidasiPenghapusanController extends Controller
{
    public function index()
    {
        $list = Catatan::where('status',3)->join('users','users.id','=','catatan.user_id_unit')->get();
        // dd($list);
        return view('dashboard.validasi.penghapusan.index',compact('list'));
    }

    public function show($id_catatan)
    {
        $catatan = Catatan::where('id_catatan',$id_catatan)->join('users','users.id','=','catatan.user_id_unit')->first();
        $barang = Barang::where('catatan_id',$id_catatan)->join('gudang','gudang.id_gudang','=','barang.nama_gudang')->get();
        // dd($barang);

        return view('dashboard.validasi.penghapusan.show',compact('catatan','barang'));
    }

    public function save(Request $request)
    {
        // dd($request);
        $message = "";
        try {

            Catatan::where('id_catatan',$request->id_catatan)
                    ->update([
                        'status' => 4,
                    ]);
            foreach($request->row as $key => $row){
                Barang::where('id_barang',$key)
                        ->update([
                            'status' => 1,
                        ]);

                $barang = Barang::where('id_barang',$key)->first();
                // dd($barang);
                MasterBarang::where('barcode',$barang->barcode)->first()->delete();

                // MasterBarang::create([
                //     'nama_barang'       => $barang->nama_barang,
                //     'barcode'           => $barang->barcode,
                //     'panjang_barang'    => $barang->panjang_barang,
                //     'lebar_barang'      => $barang->lebar_barang,
                //     'tinggi_barang'     => $barang->tinggi_barang,
                //     'gudang_id'         => $barang->nama_gudang,
                //     'unit'              => "informatika",
                //     'tanggal'           => date("Y-m-d h:i:s"),
                //     'tervalidasi'       => 0
                // ]);
            }

            $message = ["success" => "Usulan berhasil tervalidasi"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }

        return redirect()->route('dashboard.validasi.penghapusan.index')->with($message);
        
    }

}
