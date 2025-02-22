@extends('dashboard.layouts.master')
@section('title')
@isset($result)
Upload Berkas
@endisset
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push mb-0" >
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item">Dashboard</a>
        <a href="{{route('dashboard.validasi.penghapusan.index')}}" class="breadcrumb-item">Validasi Penghapusan</a>
        <a href="{{route('dashboard.validasi.penghapusan.show', ['id_catatan' => $id_catatan])}}" class="breadcrumb-item ">Detail Usulan Penghapusan</a>
        <a href="#" class="breadcrumb-item active">Upload Berkas</a>
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
                            <a href="{{ route('dashboard.validasi.penghapusan.show', ['id_catatan' => $id_catatan]) }}" id="arrow-back" class="d-inline">
                                <button type="button" class="btn btn-sm btn-circle btn-secondary mr-5 mb-5">
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                            </a>
                            <div class="d-inline font-size-lg font-w600">
                                    Upload Berkas
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white pt-5">
                        <div class="block block-transparent">
                            <div class="block-content">
                                <table id="barang_table" class="table table-striped text-dark w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 50%">Nama Berkas</th>
                                        <th style="width: 25%">Terakhir diunggah</th>
                                        <th style="width: 25%">Diunggah Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($result)
                                    @foreach($result as $surat)
                                    @if($surat->id != 8 && Auth::user()->level == 2 )
                                        @continue
                                    @endif
                                    <tr>
                                        <td>{{ $surat->id }}</td>
                                        <td>
                                        @if(is_null($surat->image_url) && $surat->mandatory == 1)
                                        {{ $surat->jenis_surat }}
                                        <i class="fa fa-exclamation-circle text-danger" data-toggle="tooltip" data-placement="top" title="Belum diunggah"></i>
                                        @else
                                        <a href="{{ asset($surat->image_url) }}" target="__blank">
                                        {{ $surat->jenis_surat }}
                                        </a>
                                        @endif
                                        </td>
                                        <td>{{ $surat->waktu_upload ? date( 'Y-m-d H:i:s', strtotime($surat->waktu_upload)) : '' }}</td>
                                        <td>{{ $surat->upload_oleh }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-its-primary pull-right mr-3" data-toggle="modal" 
                                            data-target="#modal-normal{{ $surat->id }}" style="width:100px">Upload File</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                </table>
                                <div class="modal-footer ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <form class="pull-right" 
                                                    action="{{route('dashboard.validasi.penghapusan.show', ['id_catatan' => $id_catatan])}}">
                                                    <button class="btn btn-its-primary" >Selesai</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@isset($result)
@foreach($result as $surat)
<div class="modal" id="modal-normal{{ $surat->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">{{ $surat->jenis_surat }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                @if(is_null($surat->image_url))
                <form action="{{route('dashboard.surat.upload')}}" method="post" enctype="multipart/form-data">
                @else
                <form action="{{route('dashboard.surat.update')}}" method="post" enctype="multipart/form-data">
                @endif
                @csrf
                <div class="block-content">
                    <input type="hidden" class="form-control" name="catatan_id" value="{{ $id_catatan }}">
                    <input type="hidden" class="form-control" name="jenis_surat" value="{{ $surat->id }}">
                    <div class="form-group row">
                        <div class="col-9">
                            <div class="form-material">
                                <input type="file" class="form-control" id="surat" name="surat" required>
                                <label for="surat">Upload surat (jpg/png/pdf max 10MB)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">
                            Tutup
                        </button>
                    <button type="submit" id="create_participant_btn" class="btn btn-alt-success">
                        <i class="fa fa-check"></i> Upload
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endisset
<!-- END Normal Modal -->

</script>
@endsection
