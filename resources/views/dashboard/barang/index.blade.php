@extends('dashboard.layouts.master')
@section('title')
Barang
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('/') }}/template/js/plugins/datatables/dataTables.bootstrap4.css">
<style>
table {
  counter-reset: rowNumber;
}
table tr {
  counter-increment: row-num;
}
.row-detail td:first-child::before {
    content: counter(row-num);
}
</style>
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="#" class="breadcrumb-item active">Aset Gudang</a>
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
                <div class="font-size-lg font-w600">List Barang</div>
            </div>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-12" >
                    <table id="barang_table" class="table table-striped text-dark w-100">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th>Name</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 5%;">Tahun Perolehan</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 5%;">Nup</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 5%;">Merk/Type</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 5%;">Jumlah</th>
                                <!-- <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Nilai Barang</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Kondisi</th> -->
                                <th class="text-center d-none d-sm-table-cell" style="width: 5%;">Volume</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 10%;">Lokasi</th>
                                <th class="text-center" style="width: 24%" >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($results as $barang)
                                    @if( (Auth::user()->level == 2 && Auth::user()->unit == $barang->unit ) || Auth::user()->level != 2)
                                        <tr class="row-detail">
                                            <td class="text-center"></td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ substr($barang->tanggal_peroleh,-4) }}</td>
                                            <td>{{ $barang->nup }}</td>
                                            <td>{{ $barang->merk_type }}</td>
                                            <td>{{ $barang->jumlah }}</td>
                                            <td>{{ $barang->panjang_barang * $barang->lebar_barang * $barang->tinggi_barang }}m<sup>3</sup> </td>
                                            <td>{{ $barang->nama_gudang }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('dashboard.gudang.show', $barang->gudang_id) }}" class="btn btn-sm btn-its-primary">
                                                    <i class="fa fa-archive d-sm-none"></i>
                                                    <span class="d-none d-sm-inline-block">
                                                        <span>Gudang</span>
                                                    </span>
                                                </a>
                                                <a href="{{ route('dashboard.barang.show', $barang->id_master_barang) }}" class="btn btn-sm btn-its-primary">
                                                    <i class="fa fa-info d-sm-none"></i>
                                                    <span class="d-none d-sm-inline-block">
                                                        <span>Detail</span>
                                                    </span>
                                                </a>
                                                @if(in_array($barang->barcode, $del_carts))
                                                @if(Auth::user()->level != 1)
                                                <form onclick="return confirm('Anda yakin menghapus barang dari usulan penghapusan?')"
                                                    action="{{route('dashboard.usulan_penghapusan.delete')}}"
                                                    method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $barang->barcode }}">
                                                    <button class="btn btn-sm btn-warning">
                                                        <i class="fa fa-minus d-sm-none"></i>
                                                        <span class="d-none d-sm-inline-block">
                                                            <i class="fa fa-minus"></i>
                                                            <span> Usulan Hapus</span>
                                                        </span>
                                                    </button>
                                                </form>
                                                @else
                                                <form onclick="return confirm('Anda yakin menambah barang ke usulan penghapusan?')"
                                                    action="{{route('dashboard.usulan_penghapusan.store')}}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $barang->id_master_barang }}">
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash d-sm-none"></i>
                                                        <span class="d-none d-sm-inline-block">
                                                            <i class="fa fa-plus"></i>
                                                            <span> Usulan Hapus</span>
                                                        </span>
                                                    </button>
                                                </form>
                                                @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<!-- Edit Modal -->
@foreach ($results as $barang)
<div class="modal" id="modalEdit{{ $barang->id_master_barang }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $barang->id_master_barang }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Edit Barang</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <form action="{{route('dashboard.barang.update', ['id_barang' => $barang->id_master_barang])}}" method="post">
                @method('patch')
                @csrf
                <div class="block-content">
                    <div class="form-group row">
                        <div class="col-md-11">
                            <div class="form-material">
                                <input autocomplete="off" type="text" 
                                class="form-control" id="nama" name="nama" required
                                value="{{$barang->nama_barang}}">
                                <label for="nama">Nama Barang</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input autocomplete="off" type="number" step="any" 
                                class="form-control" id="panjang" name="panjang" required
                                value="{{$barang->panjang_barang}}">
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
                                 class="form-control" id="lebar" name="lebar" required
                                 value="{{$barang->lebar_barang}}">
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
                                 class="form-control" id="tinggi" name="tinggi" required
                                 value="{{$barang->tinggi_barang}}">
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
                            <select class="js-select2 form-control" id="gudang_id" name="gudang_id" style="width: 100%;">
                                @foreach($gudangs as $gudang)
                                @if($gudang->id_gudang == $barang->id_gudang)
                                    <option value="{{$gudang->id_gudang}}" selected='selected'>{{ $gudang->nama_gudang }}</option>
                                @else
                                    <option value="{{$gudang->id_gudang}}">{{ $gudang->nama_gudang }}</option>
                                @endif
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
                        <i class="fa fa-check"></i> Perbarui
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- END Edit Modal -->


@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#barang_table').DataTable( {
            "scrollX": true
        } );
    } );
    
</script>
@endsection