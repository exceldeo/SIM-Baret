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
        <a href="#" class="breadcrumb-item">Surat</a>
        <a href="#" class="breadcrumb-item active">Detail Surat</a>
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
                            <div class="float-right">
                                <button class="btn btn-sm btn-its-primary" data-toggle="modal"
                                data-target="#modal-normal">Edit</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white pt-5">
                        <div class="block block-transparent">
                            <div class="block-content">
                                
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
                <form action="{{route('dashboard.catatan.penghapusan.uploadSurat')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="block-content">
                    <div class="form-group row">
                        <input autocomplete="off" type="hidden" 
                        class="form-control" name="catatan_id" value="{{ $id_catatan }}">
                    </div>
                    <div class="form-group row">
                                <input autocomplete="off" type="hidden" 
                                class="form-control" name="jenis_surat" value="{{ $jenis_surat }}" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input type="file" class="form-control" id="surat" name="surat" required>
                                <label for="surat">Upload surat</label>
                            </div>
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

</script>
@endsection
