<?php

namespace App\Http\Controllers\UsulanPemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsulanPemasukanController extends Controller
{
    
    public function index()
    {
        if(Auth::user()->level == 0) $assets = DB::select("SELECT TOP(100) * from v_aset_aktif join v_unit_easet on v_aset_aktif.kode_unit = v_unit_easet.code");
        else $assets = DB::select("SELECT * from v_aset_aktif
        join v_unit_easet on v_aset_aktif.kode_unit = v_unit_easet.code and v_unit_easet.code = ?", Auth::user()->unit);
        $gudang = DB::select("SELECT * from gudang");
        $kategori = DB::select("SELECT * from kategori_vol_asset");
        $carts = Cart::getContent();

        // var_dump($carts);
        // return;

        return view('dashboard.usulan_pemasukan.index',compact('carts','gudang','assets','kategori'));
    }

    public function store(Request $request)
    {
        $message = "";
        // var_dump($request->pilih_barang);
        $pilih_barang = json_decode($request->pilih_barang);
        // var_dump($pilih_barang->kode_barang);
        // return;
        $asset = DB::select("SELECT * from v_aset_aktif WHERE kode_unit = ? and kode_barang = ? and nup = ?", 
                            [$pilih_barang->kode_unit, $pilih_barang->kode_barang, $pilih_barang->nup])[0];
        $kategori = DB::select("SELECT * from kategori_vol_asset WHERE id = ?", [$request->kategori])[0];
        $gudang = DB::select("SELECT * from gudang WHERE id_gudang = ?", [$request->gudang_id])[0];
        // $carts = json_decode($request->cookie('masuk-carts'), true); 
        // date_default_timezone_set('Asia/Jakarta');
        $carts = Cart::getContent();
        $gudang_sisa = $gudang->ruang_sisa;
        
        foreach($carts as $c){
            if($c['attributes']['id_gudang'] == $request->gudang_id){
                $gudang_sisa -= ($c['attributes']['jml'] * $c['attributes']['panjang'] * $c['attributes']['lebar']  * $c['attributes']['tinggi'] );
            }
        }

        if($gudang_sisa <  ($kategori->panjang_barang * $kategori->lebar_barang * $kategori->tinggi_barang)){
            $message = ["fail" => "Gudang melebihi kapasitas"];
        }
        else{
            try {
                // $asset->nilai_sekarang = str_replace(",","",$asset->nilai_sekarang);
                // dd(intval($asset->nilai)/$asset->jml);
                // var_dump($asset);
                // var_dump(intval($asset->nilai_sekarang));
                // return;
                Cart::add([
                    'id'        => date("ymdHis"),
                    'name'      => $asset->nama_barang,
                    'price'     => 1,
                    'quantity'  => 1,
                    'attributes' => array(
                        'kode'      => $asset->kode_barang,
                        'tanggal'   => $asset->tahun_perolehan,
                        'nup'       => $asset->nup,
                        'merk'      => $asset->merk,
                        'jml'       => 1,
                        'nilai'     => intval($asset->nilai_sekarang),
                        'kondisi'   => $request->kondisi,
                        'panjang'   => $kategori->panjang_barang,
                        'lebar'     => $kategori->lebar_barang,
                        'tinggi'    => $kategori->tinggi_barang,
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
                'user_id_unit' => Auth::user()->id,
                'status' => 1,
                'unit'  => Auth::user()->unit
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
