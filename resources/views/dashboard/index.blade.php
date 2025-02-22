@extends('dashboard.layouts.master')
@section('title')
Dashboard
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push" >
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item active">Dashboard</a>
    </nav>
</div>
@endsection
@section('main')
<div class="content">
    <div class="row push" style="margin-bottom: 0px">
        <div class="col-md d-md-flex align-items-md-center text-center">
            <h2 class="text-white mb-0">
                <span class="font-w300 text-primary d-md-inline-block">Selamat datang, <strong>{{ Auth::user()->nama_user }}</strong></span>
            </h2>
        </div>
    </div>
    <h2 class="text-white mb-0">
        <span class="font-w300 text-primary d-md-inline-block" style="font-size: 70%">Masuk Sebagai
            <strong>
					<span>
                    @if(Auth::user()->level == 0)
                    Super User
                    @elseif(Auth::user()->level == 1)
                    Administrator
                    @else
                    Unit {{ Auth::user()->nama_unit }}
                    @endif
                    </span>
            </strong>
        </span>
    </h2>
</div>
<div class="content">
    {{-- <h2 class="content-heading">Selamat Datang</h2> --}}
    <div class="block block-transparent">
        <div class="block-content">
            <div class="row gutters-tiny push">
            @if(Auth::user()->level != 1)
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.usulan_pemasukan.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-file-text-o" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Aset Unit</p>
                        </div>
                    </a>
                </div>  
            @endif
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.validasi.pemasukan.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-check-circle" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Verifikasi Pengajuan Aset</p>
                        </div>
                    </a>
                </div>  
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.catatan.pemasukan.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-list" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Catatan Pemasukan</p>
                        </div>
                    </a>
                </div>  
                @if(Auth::user()->level != 1)
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.usulan_penghapusan.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-book" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Usulan Penghapusan Aset</p>
                        </div>
                    </a>
                </div> 
                @endif
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.validasi.penghapusan.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-folder" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Validasi Laporan Penghapusan</p>
                        </div>
                    </a>
                </div> 
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.catatan.penghapusan.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-reorder" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Catatan Penghapusan</p>
                        </div>
                    </a>
                </div>  
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.gudang.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-archive" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Gudang</p>
                        </div>
                    </a>
                </div>  
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.barang.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-briefcase" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Aset Gudang</p>
                        </div>
                    </a>
                </div>  
            
                <!-- END Log card -->
                @if(Auth::user()->level == 0)
                    <div class="col-6 col-md-3 col-xl-2 mt-2">
                        <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="#">
                            <div class="my-5 block-content">
                                <p><i class="fa fa-3x fa-users" style="color: #013880"></i></p>
                                <p class="" style="color: #013880">Pengguna</p>
                            </div>
                        </a>
                    </div>
                @endif
                <!-- END User Management card -->

            </div>
        </div>
    </div>
</div>
@endsection
