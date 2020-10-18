<?php

namespace App\Http\Controllers\UsulanPenghapusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsulanPenghapusanController extends Controller
{
    public function index()
    {
        $gudang = DB::select("SELECT * from gudang");
        $assets = DB::select(
            "
            SELECT * from master_barang
            JOIN gudang ON gudang.id_gudang = master_barang.gudang_id
            WHERE status = 1
            ");
        $carts = Cart::getContent();
            // dd($carts);
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

            DB::update("UPDATE master_barang set status = -1 WHERE id_master_barang = ?", [$request->id]);
                
            $jml = Cart::get($asset->barcode);
                
                if( $jml != NULL){
                    // dd($asset->jumlah < $jml['attributes']['jml'] + 1);
                    if($asset->jumlah < $jml['attributes']['jml'] + 1){
                        $message = ["fail" => "Barang yang diusulkan melebihi batas!"];
                        return redirect()->back()->with($message);
                    }
                    Cart::update($asset->barcode,[
                        'attributes' => [
                            "kode"      => $jml['attributes']['kode'],
                            "tanggal"   => $jml['attributes']['tanggal'],
                            "nup"       => $jml['attributes']['nup'],
                            "merk"      => $jml['attributes']['merk'],
                            "jml"       => $jml['attributes']['jml'] + 1,
                            "nilai"     => $jml['attributes']['nilai'],
                            "kondisi"   => $jml['attributes']['kondisi'],
                            "panjang"   => $jml['attributes']['panjang'],
                            "lebar"     => $jml['attributes']['lebar'],
                            "tinggi"    => $jml['attributes']['tinggi'],
                            "lokasi"    => $jml['attributes']['lokasi'],
                            "id_gudang" => $jml['attributes']['id_gudang'],
                            "unit"      => $jml['attributes']['unit'],
                            "role"      => $jml['attributes']['role']
                        ]
                    ]);
                }
                else{
                    if($asset->kode_barang == NULL){
                        $asset->kode_barang = 0;
                    }
                    Cart::add([
                        'id'        => $asset->barcode,
                        'name'      => $asset->nama_barang,
                        'price'     => 1,
                        'quantity'  => 1,
                        'attributes' => array(
                            'kode'      => $asset->kode_barang,
                            'tanggal'   => $asset->tanggal_peroleh,
                            'nup'       => $asset->nup,
                            'merk'      => $asset->merk_type,
                            'jml'       => 1,
                            'nilai'     => $asset->nilai_barang,
                            'kondisi'   => $asset->kondisi,
                            'panjang'   => $asset->panjang_barang,
                            'lebar'     => $asset->lebar_barang,
                            'tinggi'    => $asset->tinggi_barang,
                            'lokasi'    => $asset->nama_gudang,
                            'id_gudang' => $asset->id_gudang,
                            'unit'      => $asset->unit,
                            'role'      => 2
                        ),
                    ]);
                }

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
            DB::update("UPDATE master_barang set status = 1 WHERE barcode = ?", [$request->id]);

            Cart::remove($request->id);

            $message = ["success" => "Barang berhasil dihapus dari Usulan Penghapusan!"];

        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
    
    public function save(Request $request)
    {
        $message = "";
        try {
            date_default_timezone_set('Asia/Jakarta');
            $id = DB::table('catatan')->insertGetId([
                'tanggal_catatan' => date("Y-m-d H:i:s"),
                'user_id_unit' => Auth::user()->id,
                'status' => 3,
                'unit'  => Auth::user()->unit,
                ]);
                
            if ($request->hasFile('surat')) {
                if ($request->file('surat')->isValid()) {
                    $validated = $request->validate([
                        'surat' => 'mimes:jpeg,png,pdf|max:10240',
                    ]);
                    echo "valid";
                    $extension = $request->surat->extension();
                    $filename = $id.'_8_'.date("YmdHis").'.'.$extension;
                    $request->surat->storeAs('public', $filename);
                    $url = Storage::url($filename);
                }
            }
            DB::insert("INSERT INTO file_catatan (catatan_id, jenis_surat, image_url, waktu_upload, upload_oleh) VALUES(?, 8, ?, ?, ?)",
            [$id, $url, date("Y-m-d H:i:s"), Auth::user()->nama_user]);
            $carts = Cart::getContent();

            foreach($carts as $c){
                if($c['attributes']['role'] == 1){
                    continue;
                }

                DB::insert(
                    "
                    INSERT INTO barang
                    (kode_barang, barcode, nup, nama_barang, tanggal_peroleh, merk_type, 
                    nilai_barang, panjang_barang, lebar_barang, tinggi_barang, jumlah,
                    catatan_id, nama_gudang, status, unit, kondisi)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, -1, ?, ?)
                    ", array($c['attributes']['kode'], $c['id'],$c['attributes']['nup'], $c['name'], 
                    $c['attributes']['tanggal'], $c['attributes']['merk'], $c['attributes']['nilai'],
                    $c['attributes']['panjang'], $c['attributes']['lebar'], $c['attributes']['tinggi'],
                    $c['attributes']['jml'],$id, $c['attributes']['id_gudang'],Auth::user()->unit, $c['attributes']['kondisi']));
            }

            Cart::clear();
            $message = ["success" => "Usulan berhasil di simpan!"];
        } catch (\Throwable $th) {
            $message = ["fail" => $th->getMessage()];
        }
        return redirect()->back()->with($message);
    }
}
