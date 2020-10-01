@extends('dashboard.layouts.master')
@section('title')
@isset($result)
Surat
@endisset
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push mb-0" >
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.catatan.penghapusan.index')}}" class="breadcrumb-item">Catatan Penghapusan</a>
        <a href="#" class="breadcrumb-item active">Surat</a>
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
                            <a href="{{ URL::previous() }}" id="arrow-back" class="d-inline">
                                <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                            </a>
                            <div class="d-inline font-size-lg font-w600">
                                    Upload Surat
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white pt-5">
                        <div class="block block-transparent">
                            <div class="block-content">
                                <table id="barang_table" class="table table-striped text-dark w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 100%">Jenis Surat</th>
                                        <!-- <th style="width: 30%">Terakhir diunggah</th>
                                        <th style="width: 30%">Diunggah Oleh</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- <td><a href="{{ route('dashboard.catatan.penghapusan.showSurat', ['id_catatan' => $id_catatan, 'jenis_surat' => 0])}}">Pernyataan tidak mengganggu Tupoksi</a></td> -->
                                        <td><a href="{{ asset('storage/abcde.png') }}">Pernyataan tidak mengganggu Tupoksi</a></td>
                                        <!-- <td><img src="{{ asset('storage/abcde.png') }}"></img></td> -->
                                        <!-- <td>20-02-2020 19:00:55</td>
                                        <td>Bambang</td> -->
                                        <!-- <td>
                                            <button class="btn btn-sm btn-its-primary">Edit</button>
                                        </td> -->
                                    <tr>
                                    <tr>
                                        <td><a href="{{ route('dashboard.catatan.penghapusan.showSurat', ['id_catatan' => $id_catatan, 'jenis_surat' => 1])}}">Permohonan persetujuan penghapusan</a></td>
                                        <!-- <td>20-02-2020 19:00:55</td>
                                        <td>Bambang</td> -->
                                        <!-- <td>
                                            <button class="btn btn-sm btn-its-primary">Edit</button>
                                        </td> -->
                                    <tr>
                                    <tr>
                                        <td><a href="{{ route('dashboard.catatan.penghapusan.showSurat', ['id_catatan' => $id_catatan, 'jenis_surat' => 2])}}">Penetapan penghapusan</a></td>
                                        <!-- <td>20-02-2020 19:00:55</td>
                                        <td>Bambang</td> -->
                                        <!-- <td>
                                            <button class="btn btn-sm btn-its-primary">Edit</button>
                                        </td> -->
                                    <tr>
                                </tbody>
                                </table>
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

</script>
@endsection
