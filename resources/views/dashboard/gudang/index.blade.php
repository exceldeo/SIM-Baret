@extends('dashboard.layouts.master')
@section('title')
Gudang
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('/') }}/template/js/plugins/datatables/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.gudang.index')}}" class="breadcrumb-item active">Gudang</a>
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
                <div class="font-size-lg font-w600">List Gudang</div>
            </div>
            <div class="block-options">
                <!-- <form action="{{route('dashboard.gudang.create')}}" method="GET"> -->
                    <button type="submit" class="btn btn-sm btn-its-primary" data-toggle="modal"
                    data-target="#modal-normal3">
                        <i class="fa fa-plus"></i> Buat Gudang
                    </button>
                <!-- </form> -->
            </div>
        </div>
        <div class="block-content">
            <div class="row py-5">
                <div class="col-12" style="padding-left: 20px;padding-right: 20px;">
                    <table id="gudang_table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" >Gudang</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($gudang as $g)
                                        <tr>
                                            <td>
                                                <div class="content-li" style="padding: 0 20px 0 20px;">
                                                    <h5 class="font-size-h6 font-w500 mb-5">
                                                        <a href="{{route('dashboard.gudang.show', ['id_gudang' => $g->id_gudang])}}"> {{ $g->nama_gudang }}
                                                        </a>
                                                    </h5>
                                                    <span class="mr-10">
                                                        Tersedia : 
                                                    </span>
                                                    <span class="mr-10">
                                                    @php
                                                        $total = $g->panjang_gudang * $g->lebar_gudang * $g->tinggi_gudang
                                                    @endphp
                                                        Total : {!! $total !!} m<sup>3</sup>
                                                    </span>
                                                    <span class="mr-10">
                                                        Lokasi : {!! $g->lokasi_gudang !!}
                                                    </span>
                                                    <span class="mr-10">
                                                        Barang : 
                                                    </span>
                                                    <form class="pull-right" onclick="return confirm('Are you sure?')"
                                                        action="{{route('dashboard.gudang.delete', ['id_gudang' => $g->id_gudang])}}"
                                                        method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash mr-1"></i> Delete</button>
                                                    </form>
                                                    <a
                                                        href="{{route('dashboard.gudang.edit', ['id_gudang' => $g->id_gudang])}}">
                                                        <button class="btn btn-sm btn-its-primary pull-right mr-3"><i
                                                                class="fa fa-pencil mr-1"></i> Edit</button>
                                                    </a>
                                                    <a
                                                        href="{{route('dashboard.gudang.show', ['id_gudang' => $g->id_gudang])}}">
                                                        <button class="btn btn-sm btn-its-primary pull-right mr-3"><i
                                                                class="si si-eye mr-1"></i> Detail</button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
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

<div class="modal" id="modal-normal3" tabindex="-1" role="dialog" aria-labelledby="modal-normal3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Buat Gudang</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <form action="{{route('dashboard.gudang.store')}}" method="post">
                @csrf
                <div class="block-content">
                    <div class="form-group row">
                        <div class="col-md-11">
                            <div class="form-material">
                                <input autocomplete="off" type="text" 
                                class="form-control" id="nama" name="nama" required>
                                <label for="nama">Nama Gudang</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                class="form-control" id="panjang" name="panjang" required>
                                <label for="panjang">Panjang Gudang</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-material">
                               <span> m </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                 class="form-control" id="lebar" name="lebar" required>
                                <label for="lebar">Lebar Gudang</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-material">
                               <span> m </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                 class="form-control" id="tinggi" name="tinggi" required>
                                <label for="tinggi">Tinggi Gudang</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-material">
                               <span> m </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-11">
                            <div class="form-material">
                                <input autocomplete="off" type="text" 
                                class="form-control" id="lokasi" name="lokasi" required>
                                <label for="lokasi">Lokasi Gudang</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">
                            Close
                        </button>
                    <button type="submit" id="create_participant_btn" class="btn btn-alt-success">
                        <i class="fa fa-check"></i> Buat
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Normal Modal -->

@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#gudang_table').DataTable( {
        } );
    } );
</script>
@endsection