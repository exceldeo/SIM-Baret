@extends('dashboard.layouts.master')
@section('title')
Catatan Pemasukan
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('/') }}/template/js/plugins/datatables/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.catatan.pemasukan.index')}}" class="breadcrumb-item">Catatan Pemasukan</a>
        <a href="#" class="breadcrumb-item active">Detail Catatan Pemasukan</a>
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
                <a href="{{route('dashboard.validasi.pemasukan.index')}}" id="arrow-back" style="padding: 0px 0px 0px 12px;">
                    <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </a>
                <div class="font-size-lg font-w600">Detail Usulan</div>
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
                                Nama Pengusul : {!! $catatan->nama_user !!} <br>
                                Unit : {!! $catatan->unit_user !!} <br>
                                Tanggal Pengusulan : {!! substr($catatan->tanggal_catatan,0,10) !!}
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
                <div class="font-size-lg font-w600">&nbsp;&nbsp;&nbsp;Daftar Barang yang di Usulan</div>
            </div>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content">
            <div class="row py-5">
                <div class="col-12" style="padding-left: 20px;padding-right: 20px;">
                    <div class="block">
                        <table class="js-table-checkable table table-hover">
                            <thead>
                                <tr>
                                    <th class="d-none d-sm-table-cell" style="width: 5%;">No</th>
                                    <th class="d-none d-sm-table-cell">Nama Barang</th>
                                    <th class="d-none d-sm-table-cell" style="width: 15%;">Volume Barang</th>
                                    <th class="d-none d-sm-table-cell" style="width: 20%;">Lokasi</th>
                                    <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barang as $b)
                                    <tr>
                                        <td class="text-center">{!! $loop->iteration !!}</td>
                                        <td> {{ $b->nama_barang }} </td>
                                        @php
                                            $total = $b->panjang_barang * $b->lebar_barang * $b->tinggi_barang
                                        @endphp
                                        <td> {{ $total }} m<sup>3</sup> </td>
                                        <td> {{ $b->nama_gudang }} </td>
                                        @if($b->status == -1 )
                                            <td class="d-none d-sm-table-cell text-center">
                                                <span class="badge badge-danger">Ditolak</span>
                                            </td>
                                        @else
                                            <td class="d-none d-sm-table-cell text-center">
                                                <span class="badge badge-success">Diterima</span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
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