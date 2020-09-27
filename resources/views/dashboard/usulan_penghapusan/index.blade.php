@extends('dashboard.layouts.master')
@section('title')
Usulan Penghapusan Barang
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('/') }}/template/js/plugins/datatables/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.usulan_penghapusan.index')}}" class="breadcrumb-item active">Usulan Penghapusan Barang</a>
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
                <div class="font-size-lg font-w600">Daftar Usulan Barang</div>
            </div>
            <div class="block-options">
                <!-- <form action="{{route('dashboard.gudang.create')}}" method="GET"> -->
                    <button type="submit" class="btn btn-sm btn-its-primary" data-toggle="modal"
                    data-target="#modal-large">
                        <i class="fa fa-plus"></i> Tambah Barang
                    </button>
                <!-- </form> -->
            </div>
        </div>
        <div class="block-content">
            <table class="table table-vcenter">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Name</th>
                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Panjang</th>
                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Lebar</th>
                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Tinggi</th>
                        <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Unit</th>
                        <th class="text-center d-none d-sm-table-cell" style="width: 20%;">Lokasi</th>
                        <th class="text-center" style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!is_null($carts))
                        @foreach($carts as $key=>$c)
                        @if($c['attributes']['role'] != 2)
                            @continue
                        @endif
                            <tr>
                                <th class="text-center" scope="row">{!! $loop->iteration !!}</th>
                                <td>{{ $c['name'] }}</td>
                                <td class="text-center">{{ $c['attributes']['panjang'] }} m</td>
                                <td class="text-center">{{ $c['attributes']['lebar'] }} m</td>
                                <td class="text-center">{{ $c['attributes']['tinggi'] }} m</td>
                                <td class="text-center">{{ $c['attributes']['unit'] }}</td>
                                <td class="text-center">{{ $c['attributes']['lokasi'] }}</td>
                                <td class="text-center">
                                    <form onclick="return confirm('Are you sure?')"
                                        action="{{route('dashboard.usulan_pemasukan.delete')}}"
                                        method="post">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="id" value="{!!$key!!}">
                                        <button class="btn btn-sm btn-secondary" title="Delete"><i class="fa fa-trash mr-1"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Steps Navigation -->
        <div class="block-content bg-body-light block-content-full ">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <form class="pull-right" onclick="return confirm('Are you sure?')"
                            action="{{route('dashboard.usulan_pemasukan.save')}}"
                            method="post">
                            @csrf
                            <button class="btn btn-its-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<div class="modal" id="modal-large" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Data Barang</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row py-5">
                        <div class="col-12" style="padding-left: 20px;padding-right: 20px;">
                            <table id="list_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="d-none d-sm-table-cell text-center" style="width: 5%;">No</th>
                                        <th class="d-none d-sm-table-cell text-center">Nama Asset</th>
                                        <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Volume</th>
                                        <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Gudang</th>
                                        <th class="d-none d-sm-table-cell text-center" style="width: 10%;">Unit</th>
                                        <th class="text-center" style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!is_null($assets))
                                        @foreach ($assets as $as)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell text-center">{!! $loop->iteration !!}</td>
                                                    <td class="d-none d-sm-table-cell">{!! $as->nama_barang !!}</td>
                                                    <td class="d-none d-sm-table-cell">{!! $as->panjang_barang * $as->lebar_barang * $as->tinggi_barang !!} m<sup>3</sup></td>
                                                    <td class="d-none d-sm-table-cell">{!! $as->nama_gudang !!}</td>
                                                    <td class="d-none d-sm-table-cell">{!! $as->unit !!}</td>
                                                    <td>
                                                        <form action="{{route('dashboard.usulan_penghapusan.store')}}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{!!$as->id_master_barang!!}">
                                                            <button class="btn btn-sm btn-secondary" title="pilih">Pilih</button>
                                                        </form>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END Large Modal -->

@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#list_table').DataTable( {
        } );
    } );
    // $('#myModal').on('show.bs.modal', function(e) {
    //     var userid = $(e.relatedTarget).data('userid');
    //     $(e.currentTarget).find('input[name="user_id"]').val(userid);
    // });
</script>
@endsection