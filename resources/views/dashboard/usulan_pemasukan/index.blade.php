@extends('dashboard.layouts.master')
@section('title')
Usulan Pemasukan Barang
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('/') }}/template/js/plugins/datatables/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.usulan_pemasukan.index')}}" class="breadcrumb-item active">Usulan Pemasukan Barang</a>
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
                    data-target="#modal-normal">
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
                        <th class="text-center d-none d-sm-table-cell" style="width: 20%;">Lokasi</th>
                        <th class="text-center" style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!is_null($carts))
                        @foreach($carts as $key=>$c)
                            <tr>
                                <th class="text-center" scope="row">{!! $loop->iteration !!}</th>
                                <td>{{ $c['name'] }}</td>
                                <td class="text-center">{{ $c['attributes']['panjang'] }} m</td>
                                <td class="text-center">{{ $c['attributes']['lebar'] }} m</td>
                                <td class="text-center">{{ $c['attributes']['tinggi'] }} m</td>
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
                            <input type="hidden" name="id" value="1">
                            <button class="btn btn-its-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<div class="modal" id="modal-normal" tabindex="-1" role="dialog" aria-labelledby="modal-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Tambah Barang</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <form action="{{route('dashboard.usulan_pemasukan.store')}}" method="post">
                @csrf
                <div class="block-content">
                    <div class="form-group row">
                        <div class="col-md-11">
                            <div class="form-material">
                                <input autocomplete="off" type="text" 
                                class="form-control" id="nama" name="nama" required>
                                <label for="nama">Nama Barang</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                class="form-control" id="panjang" name="panjang" required>
                                <label for="panjang">Panjang Barang</label>
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
                                <label for="lebar">Lebar Barang</label>
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
                                <label for="tinggi">Tinggi Barang</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-material">
                               <span> m </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="gudang_id">Lokasi Barang</label>
                        <div class="col-lg-11">
                            <select class="js-select2 form-control" id="gudang_id" name="gudang_id" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach($gudang as $g)
                                    <option value="{{$g->id_gudang}}">{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">
                            Tutup
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
    // $('#myModal').on('show.bs.modal', function(e) {
    //     var userid = $(e.relatedTarget).data('userid');
    //     $(e.currentTarget).find('input[name="user_id"]').val(userid);
    // });
</script>
@endsection