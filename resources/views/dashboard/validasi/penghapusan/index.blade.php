@extends('dashboard.layouts.master')
@section('title')
Validasi Penghapusan
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('/') }}/template/js/plugins/datatables/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.validasi.penghapusan.index')}}" class="breadcrumb-item active">Validasi Penghapusan</a>
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
                <div class="font-size-lg font-w600">Daftar Usulan Penghapusan</div>
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
                                <th class="d-none d-sm-table-cell text-center">Penghapusan</th>
                                <th class="d-none d-sm-table-cell text-center">Nama Pengusul</th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 20%;">Unit Pengusul</th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Tanggal</th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Waktu</th>
                                <th class="text-center" style="width: 24%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($list))
                                @foreach ($list as $l)
                                    @if((Auth::user()->level == 2 && Auth::user()->unit == $l->unit) || Auth::user()->level != 2)
                                        <tr>
                                            <td class="d-none d-sm-table-cell text-center">{!! $loop->iteration !!}</td>
                                            @php
                                            setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID');
                                            $monthName = strftime('%B %Y', strtotime($l->tanggal_catatan));
                                            @endphp
                                            <td class="d-none d-sm-table-cell">{!! $monthName !!} </td>
                                            <td class="d-none d-sm-table-cell">{!! $l->nama_user !!}</td>
                                            <td class="d-none d-sm-table-cell text-center">{!! $l->unit !!}</td>
                                            <td class="d-none d-sm-table-cell text-center">{!! substr($l->tanggal_catatan,0,10) !!}</td>
                                            <td class="d-none d-sm-table-cell text-center">{!! substr($l->tanggal_catatan,11) !!}</td>
                                            <td>
                                                <a href="{{route('dashboard.validasi.pemasukan.export', ['id_catatan' => $l->id_catatan])}}">
                                                    <button class="btn btn-sm btn-its-primary pull-right mr-3"><i
                                                            class="fa fa-download mr-1"></i>Download Detail</button>
                                                </a>
                                                <a href="{{route('dashboard.validasi.penghapusan.show', ['id_catatan' => $l->id_catatan])}}">
                                                    <button class="btn btn-sm btn-its-primary pull-right mr-3"><i
                                                            class="si si-eye mr-1"></i> Detail</button>
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
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