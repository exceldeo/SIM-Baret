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
                <span class="font-w300 text-primary d-md-inline-block">Selamat datang, <strong>Admin</strong></span>
            </h2>
        </div>
    </div>
    <h2 class="text-white mb-0">
        <span class="font-w300 text-primary d-md-inline-block" style="font-size: 70%">Masuk Sebagai
            <strong>
					<span>Administrator</span>
            </strong>
        </span>
    </h2>
    <p></p>
</div>
<div class="content">
    {{-- <h2 class="content-heading">Selamat Datang</h2> --}}
    <div class="block block-transparent">
        <div class="block-content">
            <div class="row gutters-tiny push">
                <!-- User Management card -->
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center"  href='user'>
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-users" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Pengguna</p>
                        </div>
                    </a>
                </div>
                <!-- END User Management card -->
                <!-- Draft card -->
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="#">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-file-text-o" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Draft masuk</p>
                        </div>
                    </a>
                </div>  
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="#">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-book" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Draft keluar</p>
                        </div>
                    </a>
                </div> 
                <!-- END Draft card -->
                <!-- Warehouse card -->
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="{{route('dashboard.gudang.index')}}">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-archive" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Gudang</p>
                        </div>
                    </a>
                </div>  
                <!-- END Warehouse card -->
                <!-- Items card -->
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="#">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-briefcase" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Barang</p>
                        </div>
                    </a>
                </div>  
                <!-- END Items card -->
                <!-- Log card -->
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="#">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-list" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Catatan pemasukan</p>
                        </div>
                    </a>
                </div>  
                <div class="col-6 col-md-3 col-xl-2 mt-2">
                    <a class="h-100 block block-rounded block-bordered block-link-shadow text-center" href="#">
                        <div class="my-5 block-content">
                            <p><i class="fa fa-3x fa-reorder" style="color: #013880"></i></p>
                            <p class="" style="color: #013880">Catatan penghapusan</p>
                        </div>
                    </a>
                </div>  
                <!-- END Log card -->
            </div>
        </div>
    </div>
</div>
@endsection
