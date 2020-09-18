@extends('dashboard.layouts.master')
@section('title')
Scan Barcode
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push mb-0" >
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('scan')}}" class="breadcrumb-item active">Scan Barcode</a>
    </nav>
</div>
@endsection
@section('main')
<div class="content">
    <div class="block block-transparent">
        <div class="block-content">
            <div class="row push">
                <!-- Scanner card -->
                <div class="card w-100">
                    <div class="card-header bg-light" style="padding: 10px">
                        <h5 class="m-0 d-inline">
                            <a class="text-dark" href="{{route('index')}}">
                                <i class="fa fa-1x fa-arrow-circle-o-left pl-5"></i>
                            </a>
                                Scan Barcode
                        </h5>
                    </div>
                    <div class="card-body bg-white p-5 text-center">
                        <div>
                            <video id="video" width="300" height="500" style="border: 1px solid gray"></video>
                        </div>
                        <div id="sourceSelectPanel" style="display:block">
                            <label for="sourceSelect">Ganti kamera:</label><br>
                            <select id="sourceSelect" style="max-width:400px">
                            <option value="cam">Camera 1</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- END Scanner card -->
            </div>
        </div>
    </div>
</div>
@endsection
