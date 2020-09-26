@extends('dashboard.layouts.master')
@section('title')
Scan Barcode
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push mb-0" >
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="#" class="breadcrumb-item">Item</a>
        @isset($id)
        <a href="#" class="breadcrumb-item active">{{ $id }}</a>
        @else
        <a href="#" class="breadcrumb-item active">id</a>
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
                            <a href="{{route('dashboard.index')}}" id="arrow-back" class="d-inline">
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
                                <button class="btn btn-sm btn-primary">Edit</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white p-5">
                        <div class="block block-transparent">
                            <div class="block-content">
                                <dl class="row">
                                    <dt class="col-sm-3">Barcode</dt>
                                    @isset($id)
                                    <dd class="col-sm-9">
                                        <p id="barcode-value">{{ $id }}</p>
                                        <svg id="barcode"></svg>
                                        <button class="btn btn-sm btn-info">Print barcode</button>
                                    </dd>
                                    @endisset
                                    <dt class="col-sm-3">Nama barang</dt>
                                    <dd class="col-sm-9">Dummy</dd>
                                    <dt class="col-sm-3">Dimensi (P x L x T) dalam cm</dt>
                                    <dd class="col-sm-9">10.0 x 50.0 x 10.0</dd>
                                    <dt class="col-sm-3">Lokasi penyimpanan</dt>
                                    <dd class="col-sm-9">Gudang Elektronik - 1</dd>
                                </dl>
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
