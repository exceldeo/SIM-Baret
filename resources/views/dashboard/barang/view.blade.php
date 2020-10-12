@extends('dashboard.layouts.master')
@section('title')
@isset($result)
{{ $result->nama_barang }}
@endisset
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push mb-0" >
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.barang.index')}}" class="breadcrumb-item">Aset Gudang</a>
        @isset($result->barcode)
        <a href="#" class="breadcrumb-item active">{{ $result->barcode }}</a>
        @else
        <a href="#" class="breadcrumb-item active">NOT FOUND</a>
        @endisset
    </nav>
</div>
@endsection
@section('main')
<!-- Page Content -->
<div class="content">
    @if (session('success'))
    <div class="alert alert-success alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('success') }}
    </div>
    @endif
    @if (session('fail'))
    <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('fail') }}
    </div>
    @endif
    <div class="block block-transparent">
        <div class="block-content">
            <div class="row push">
                <!-- Detail card -->
                <div class="card w-100">
                    <div class="card-header bg-light" style="padding: 10px">
                        <div class="m-0">
                            <a href="{{route('dashboard.barang.index')}}" id="arrow-back" class="d-inline">
                                <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                            </a>
                            <div class="d-inline font-size-lg font-w600">
                                    Detail Aset
                            </div>
                            @isset($result)
                            @if(Auth::user()->level != 1)
                            <div class="float-right">
                                @if($isin_draft)
                                <form onclick="return confirm('Anda yakin menghapus barang dari usulan penghapusan?')"
                                    action="{{route('dashboard.usulan_penghapusan.delete')}}"
                                    method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $result->barcode }}">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fa fa-minus d-sm-none"></i>
                                        <span class="d-none d-sm-inline-block">
                                            <i class="fa fa-minus"></i>
                                            <span> Usulan Hapus</span>
                                        </span>
                                    </button>
                                </form>
                                @else
                                <form onclick="return confirm('Anda yakin menambah barang ke usulan penghapusan?')"
                                    action="{{route('dashboard.usulan_penghapusan.store')}}"
                                    method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $result->id_master_barang }}">
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-plus d-sm-none"></i>
                                        <span class="d-none d-sm-inline-block">
                                            <i class="fa fa-plus"></i>
                                            <span> Usulan Hapus</span>
                                        </span>
                                    </button>
                                </form>
                                @endif
                                <button type="submit" class="btn btn-sm btn-its-primary" data-toggle="modal"
                                data-target="#modalEdit">
                                    <i class="fa fa-pencil d-sm-none"></i>
                                    <span class="d-none d-sm-inline-block">
                                        <span>Edit</span>
                                    </span>
                                </button>
                            </div>
                            @endif
                            @endisset
                        </div>
                    </div>
                    <div class="card-body bg-white pt-5">
                        <div class="block block-transparent">
                            <div class="block-content">
                                @isset($result)
                                    <dl class="row">
                                        <dt class="col-sm-3">Barcode</dt>
                                        <dd class="col-sm-9">
                                            <p id="barcode-value">{{ $result->barcode }}</p>
                                            <svg id="barcode"></svg>
                                            <!-- <button class="btn btn-sm btn-info">Print barcode</button> -->
                                        </dd>
                                        <dt class="col-sm-3">Nama barang</dt>
                                        <dd class="col-sm-9">{{ $result->nama_barang }}</dd>
                                        <dt class="col-sm-3">Dimensi (P x L x T)</dt>
                                        <dd class="col-sm-9">{{ $result->panjang_barang }}m x {{ $result->lebar_barang }}m x {{ $result->tinggi_barang }}m</dd>
                                        <dt class="col-sm-3">Lokasi penyimpanan</dt>
                                        <dd class="col-sm-9">{{ $result->nama_gudang }}</dd>
                                        @if(!(is_null($result->tanggal_validasi)))
                                        <dt class="col-sm-3">Validasi oleh</dt>
                                        <dd class="col-sm-9">{{ $result->nama_user }}</dd>
                                        <dt class="col-sm-3">Validasi pada</dt>
                                        <dd class="col-sm-9">{{ date( 'Y-m-d H:i:s', strtotime($result->tanggal_validasi)) }}</dd>
                                        @endif
                                    </dl>
                                @else
                                <div class="text-center">
                                <h3><i class="fa fa-exclamation-triangle"></i> Data tidak ditemukan<h3>
                                </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Detail card -->
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<!-- Edit Modal -->
<div class="modal" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Edit Barang</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <form action="{{route('dashboard.barang.update', ['id_barang' => $result->id_master_barang])}}" method="post">
                @method('patch')
                @csrf
                <div class="block-content">
                    <div class="form-group row">
                        <div class="col-md-11">
                            <div class="form-material">
                                <input autocomplete="off" type="text" 
                                class="form-control" id="nama" name="nama" required
                                value="{{$result->nama_barang}}">
                                <label for="nama">Nama Barang</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                class="form-control" id="panjang" name="panjang" required
                                value="{{$result->panjang_barang}}">
                                <label for="panjang">Panjang Barang</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-material">
                               <span> m </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                 class="form-control" id="lebar" name="lebar" required
                                 value="{{$result->lebar_barang}}">
                                <label for="lebar">Lebar Barang</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-material">
                               <span> m </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                 class="form-control" id="tinggi" name="tinggi" required
                                 value="{{$result->tinggi_barang}}">
                                <label for="tinggi">Tinggi Barang</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-material">
                               <span> m </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="gudang_id">Lokasi Barang</label>
                        <div class="col-lg-11">
                            <select class="js-select2 form-control" id="gudang_id" name="gudang_id" style="width: 100%;">
                                @foreach($gudangs as $gudang)
                                @if($gudang->id_gudang == $result->id_gudang)
                                    <option value="{{$gudang->id_gudang}}" selected='selected'>{{ $gudang->nama_gudang }}</option>
                                @else
                                    <option value="{{$gudang->id_gudang}}">{{ $gudang->nama_gudang }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">
                            Tutup
                        </button>
                    <button type="submit" id="create_participant_btn" class="btn btn-alt-success">
                        <i class="fa fa-check"></i> Perbarui
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Edit Modal -->

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">
function generateBarcode(){
    let barcodeValue = document.getElementById('barcode-value').innerHTML
    JsBarcode('#barcode', barcodeValue, {
        background: '#ffffff',
        lineColor: '#000000'
    })
}

generateBarcode()
</script>
@endsection
