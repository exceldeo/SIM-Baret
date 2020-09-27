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
        <a href="{{route('dashboard.barang.index')}}" class="breadcrumb-item">Barang</a>
        @isset($result->barcode)
        <a href="#" class="breadcrumb-item active">{{ $result->barcode }}</a>
        @else
        <a href="#" class="breadcrumb-item active">NOT FOUND</a>
        @endisset
    </nav>
</div>
@endsection
@section('main')
<div class="content">
    <div class="block block-transparent">
        <div class="block-content">
            <div class="row push">
                <!-- Detail card -->
                <div class="card w-100">
                    <div class="card-header bg-light" style="padding: 10px">
                        <div class="m-0">
                            <a href="{{ URL::previous() }}" id="arrow-back" class="d-inline">
                                <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                            </a>
                            <div class="d-inline font-size-lg font-w600">
                                    Detail Barang
                            </div>
                            <div class="float-right">
                                <button class="btn btn-sm btn-danger d-sm-none">+</button>
                                <button class="btn btn-sm btn-danger d-none d-sm-inline-block">+ Draft Penghapusan</button>
                                <button class="btn btn-sm btn-its-primary">Edit</button>
                            </div>
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
                                            <button class="btn btn-sm btn-info">Print barcode</button>
                                        </dd>
                                        <dt class="col-sm-3">Nama barang</dt>
                                        <dd class="col-sm-9">{{ $result->nama_barang }}</dd>
                                        <dt class="col-sm-3">Dimensi (P x L x T)</dt>
                                        <dd class="col-sm-9">{{ $result->panjang_barang }}m x {{ $result->lebar_barang }}m x {{ $result->tinggi_barang }}m</dd>
                                        <dt class="col-sm-3">Lokasi penyimpanan</dt>
                                        <dd class="col-sm-9">{{ $result->nama_gudang }}</dd>
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
