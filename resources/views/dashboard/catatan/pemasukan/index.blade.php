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
        <a href="{{route('dashboard.catatan.pemasukan.index')}}" class="breadcrumb-item active">Catatan Pemasukan</a>
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
                <a href="{{route('dashboard.index')}}" id="arrow-back" style="padding: 0px 0px 0px 12px;">
                    <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </a>
                <div class="font-size-lg font-w600">Daftar Catatan Pemasukan</div>
            </div>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content">
            <div class="row py-5">
                <div class="col-12" style="padding-left: 20px;padding-right: 20px;">
                    <table id="list_table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th class="d-none d-sm-table-cell text-center" style="width: 5%;">No</th>
                                <th class="d-none d-sm-table-cell text-center top">Nama Pengaju</th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Asal Unit </th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Tanggal Pengajuan</th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Tanggal Verifikasi</th>
                                <th class="text-center" style="width: 23%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($list as $l)
                                    @if((Auth::user()->level == 2 && Auth::user()->unit == $l->unit) || Auth::user()->level != 2)
                                        <tr>
                                            <td class="d-none d-sm-table-cell text-center">{!! $loop->iteration !!}</td>
                                            <td class="d-none d-sm-table-cell">{!! $l->nama_user !!}</td>
                                            <td class="d-none d-sm-table-cell text-center">{!! $l->unit !!}</td>
                                            <td class="d-none d-sm-table-cell text-center">{!! $l->tanggal_catatan !!}</td>
                                            <td class="d-none d-sm-table-cell text-center">{!! $l->tanggal_validasi !!}</td>
                                            <td>
                                                <a href="{{route('dashboard.catatan.pemasukan.print_barcode', ['id_catatan' => $l->id_catatan])}}" target="_blank">
                                                    <button class="btn btn-sm btn-its-primary pull-right mr-3"><i
                                                            class="si si-printer mr-1"></i>Cetak Barcode</button>
                                                </a>
                                                <a href="{{route('dashboard.catatan.pemasukan.show', ['id_catatan' => $l->id_catatan])}}">
                                                    <button class="btn btn-sm btn-its-primary pull-right mr-3"><i
                                                            class="si si-eye mr-1"></i> Detail</button>
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="block-content block-content-full bg-body-light font-size-xs font-italic">
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
@endsection