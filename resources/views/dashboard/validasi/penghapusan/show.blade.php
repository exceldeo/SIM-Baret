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
        <a href="{{route('dashboard.validasi.penghapusan.index')}}" class="breadcrumb-item">Validasi Penghapusan</a>
        <a href="#" class="breadcrumb-item active">Detail Usulan Penghapusan</a>
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
                <a href="{{route('dashboard.validasi.penghapusan.index')}}" id="arrow-back" style="padding: 0px 0px 0px 12px;">
                    <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </a>
                <div class="font-size-lg font-w600">Detail Usulan</div>
            </div>
        </div>
        <div class="block-content">
            <div class="row py-5">
                <div class="col-12" style="padding: 0px;">
                    <ul style="list-style-type: none; padding-left: 0px;">
                        <li>
                            <div class="content-li" style="padding: 0 20px 0 20px;">
                                <h5 class="font-size-h6 font-w500 mb-5">
                                Nama Pengaju <span style="padding: 15px;"> </span> : {!! $catatan->nama_user !!} <br>
                                Asal Unit  <span style="padding: 34px;"> </span>: {!! $catatan->unit !!} <br>
                                Tanggal Pengajuan : {!! substr($catatan->tanggal_catatan,0,10) !!}
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
            <!-- <div class="row"> -->
                <div class="font-size-lg font-w600">&nbsp;&nbsp;&nbsp;Daftar Usulan Aset</div>
                <div class="pull-right">
                <a class="btn btn-sm btn-its-primary text-light" href="{{ route('dashboard.surat.index', ['id_catatan' => $catatan->id_catatan]) }}">Upload Berkas</a>
                </div>
            <!-- </div> -->
        </div>
        <form action="{{route('dashboard.validasi.penghapusan.save')}}" method="post">
        @csrf
        <input type="hidden" name="id_catatan" value="{!! $catatan->id_catatan !!}">
            <div class="block-content">
                <div class="row py-5">
                    <div class="col-12" style="padding-left: 20px;padding-right: 20px;">
                        <div class="block">
                            <table class="js-table-checkable table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center d-none d-sm-table-cell" style="width: 5%;">No<br></br></th>
                                        <th class="text-center d-none d-sm-table-cell">Nama Aset<br></br></th>
                                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Nup<br></br></th>
                                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Merk/Type<br></br></th>
                                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Jumlah<br></br></th>
                                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Tahun Perolehan</th>
                                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Volume<br></br></th>
                                        <th class="text-center d-none d-sm-table-cell" style="width: 15%;">lokasi<br></br></th>
                                        <th class="text-center" style="width: 70px;"> Verifikasi
                                            <label class="css-control css-control-primary css-checkbox py-0 " style="border:10px" >
                                                <input type="checkbox" class="css-control-input" id="check-all" name="check-all" checked  >
                                                <span class="css-control-indicator" ></span>
                                            </label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang as $b)
                                        <tr>
                                            <td class="d-none d-sm-table-cell text-center">{!! $loop->iteration !!}</td>
                                            <td> {{ $b->nama_barang }} </td>
                                            <td class="text-center d-none d-sm-table-cell">{!! $b->nup !!}</td>
                                            <td class="text-center d-none d-sm-table-cell">{!! $b->merk_type !!}</td>
                                            <td class="text-center d-none d-sm-table-cell">{!! $b->jumlah !!}</td>
                                            <td class="text-center d-none d-sm-table-cell">{!! substr($b->tanggal_peroleh,-4) !!}</td>
                                            @php
                                                $total = $b->panjang_barang * $b->lebar_barang * $b->tinggi_barang
                                            @endphp
                                            <td  class="text-center"> {{ $total }} m<sup>3</sup> </td>
                                            <td class="text-center"> {{ $b->nama_gudang }} </td>
                                            <td class="text-center">
                                                <label class="css-control css-control-primary css-checkbox">
                                                    <input type="checkbox" class="css-control-input" id="row[{{$b->id_barang}}]" name="row[{{$b->id_barang}}]" checked>
                                                    <span class="css-control-indicator"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content bg-body-light block-content-full">
                <div class="row">
                    <div class="col align-self-end" >
                        <button type="submit" class="btn btn-its-primary pull-right" onclick="return confirm('Are you sure?')" required >Simpan</button>
                    </div>
                </div>
            </div>
        </form>
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