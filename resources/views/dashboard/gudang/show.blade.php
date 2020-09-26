@extends('dashboard.layouts.master')
@section('title')
Validasi Pemasukan
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('/') }}/template/js/plugins/datatables/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.gudang.index')}}" class="breadcrumb-item active">Gudang</a>
        <a href="#" class="breadcrumb-item active">Detail Gudang</a>
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
    <div class="block">
        <div class="block-header block-header-default">
            <div class="row">
                <a href="{{route('dashboard.gudang.index')}}" id="arrow-back" style="padding: 0px 0px 0px 12px;">
                    <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </a>
                <div class="font-size-lg font-w600">Detail Gudang</div>
            </div>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content">
            <div class="row py-5">
                <div class="col-12" style="padding: 0px;">
                    <ul style="list-style-type: none; padding-left: 0px;">
                        <li>
                            <div class="content-li" style="padding: 0 20px 0 20px;">
                                <h5 class="font-size-h6 font-w500 mb-5">
                                Nama Gudang : {!! $d_gudang->nama_gudang !!} <br>
                                Volume : {!! $d_gudang->panjang_gudang * $d_gudang->lebar_gudang * $d_gudang->tinggi_gudang !!} m<sup>3</sup>  <br>
                                Tesedia : {!! $d_gudang->ruang_sisa !!} m<sup>3</sup>  <br>
                                Lokasi : {!! $d_gudang->lokasi_gudang !!}
                                </h5>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <div class="row">
                <div class="font-size-lg font-w600">&nbsp;&nbsp;&nbsp;Daftar Barang </div>
            </div>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content">
            <div class="row py-5">
                <div class="col-12" style="padding-left: 20px;padding-right: 20px;">
                    <div class="block">
                        <table id="list_table" class="js-table-checkable table table-hover">
                            <thead>
                                <tr>
                                    <th class="d-none d-sm-table-cell text-center" style="width: 5%;">No</th>
                                    <th class="d-none d-sm-table-cell">Nama Asset</th>
                                    <th class="d-none d-sm-table-cell" style="width: 10%;">Volume</th>
                                    <th class="d-none d-sm-table-cell" style="width: 10%;">Unit</th>
                                    <th class="text-center" style="width: 20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($as_gudang))
                                    @foreach ($as_gudang as $as)
                                            <tr>
                                                <td class="d-none d-sm-table-cell text-center">{!! $loop->iteration !!}</td>
                                                <td class="d-none d-sm-table-cell">{!! $as->nama_barang !!}</td>
                                                <td class="d-none d-sm-table-cell">{!! $as->panjang_barang * $as->lebar_barang * $as->tinggi_barang !!} m<sup>3</sup></td>
                                                <td class="d-none d-sm-table-cell">{!! $as->unit !!}</td>
                                                <td>
                                                    <a href="{{route('dashboard.barang.show', ['id_barang' => $as->id_master_barang])}}">
                                                        <button class="btn btn-sm btn-its-primary pull-right mr-3"><i
                                                                class="si si-eye mr-1"></i> Detail Asset </button>
                                                    </a>
                                                </td>
                                            </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-content bg-body-light block-content-full">
        </div>
    </div>
</div>
<!-- END Page Content -->


@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#list_table').DataTable( {
        } );
    } );
</script>
<script>jQuery(function(){ Codebase.helpers('table-tools'); });</script>
@endsection