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
                        <div id="sourceSelectPanel" style="display:none">
                            <label for="sourceSelect">Ganti kamera:</label><br>
                            <select id="sourceSelect" style="max-width:400px">
                            </select>
                        </div>
                    </div>
                </div>
                <!-- END Scanner card -->
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<!-- Scanned Modal -->
<div class="modal" id="modal-normal3" tabindex="-1" role="dialog" aria-labelledby="modal-normal3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Barcode Terpindai</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content text-center">
                    <h5 class="p-5">ID Barang:</h5>
                    <h3 id="scanned-id" class="p-5"></h3>
                    <div class="spinner-border text-primary" role="status" id="spinner">
                    </div>
                    <div id="detail-barang" class="text-center mb-5" style="display:none">
                        <h5 class="p-0 m-0">Nama Barang:</h5>
                        <h5 class="p-0 m-0" id="nama-barang"></h5>
                        <h5 class="p-0 m-0">Lokasi:</h5>
                        <h5 class="p-0 mb-5" id="lokasi-barang"></h5>
                        <h5 class="p-0 m-0">Jumlah:</h5>
                        <h5 class="p-0 mb-5" id="jumlah-barang"></h5>
                    </div>

                    <div class="d-block text-center" id="form-validasi">
                    <form action="{{route('dashboard.barang.validate')}}"
                        method="post">
                        @csrf
                        <input type="hidden" name="id" id="id-field"></input>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-material"> 
                                    <input autocomplete="off" type="number" min="0"
                                    class="form-control" id="oke" name="oke" required>
                                    <label for="oke">OK</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-material"> 
                                    <input autocomplete="off" type="number" min="0"
                                    class="form-control" id="titip" name="titip" required>
                                    <label for="titip">Titip</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success mb-5 text-light">Validasi</button>
                    </form>
                    </div>
                    <div class="d-block text-center">
                    <form onclick="return confirm('Anda yakin menghapus barang dari usulan penghapusan?')"
                        action="{{route('dashboard.usulan_penghapusan.delete')}}"
                        method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="id" id="id-del">
                        <button class="btn btn-sm btn-warning mb-5" id="min-up-btn" style="display:none;">
                            <i class="fa fa-minus"></i>
                            <span> Usulan Hapus</span>
                        </button>
                    </form>
                    </div>
                    <div class="d-block text-center">
                    <form onclick="return confirm('Anda yakin menambah barang ke usulan penghapusan?')"
                        action="{{route('dashboard.usulan_penghapusan.store')}}"
                        method="post" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" id="id-store">
                        <button class="btn btn-sm btn-danger mb-5" id="plus-up-btn" style="display:none;">
                            <i class="fa fa-plus"></i>
                            <span> Usulan Hapus</span>
                        </button>
                    </form>
                    </div>
                    <a id="view-detail-btn" class="btn btn-info mb-5" style="display:none;">Lihat detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Scanned Modal -->

@endsection
@section('js')
<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
<script type="text/javascript">
    window.addEventListener('load', function () {

        let selectedDeviceId;
        const codeReader = new ZXing.BrowserBarcodeReader()
        console.log('ZXing code reader initialized')
        function start(){
            console.log('start')
            codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                if (result) {
                    document.getElementById('scanned-id').innerHTML = result.text
                    fetchRecords(result.text);
                    $('#modal-normal3').modal('show'); 
                }
                if (err && !(err instanceof ZXing.NotFoundException)) {
                    console.error(err)
                }
            })
        }

        function reset(){
            console.log('reset')
            codeReader.reset();
        }

        // Modal functions
        //on shown
        function alignModal(){
            reset();
            // var modalDialog = $(this).find(".modal-dialog");
            // modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        $(".modal").on("shown.bs.modal", alignModal);

        //on hidden
        $(".modal").on("hidden.bs.modal", function(){
            $('#detail-barang').hide();
            $('#view-detail-btn').hide();
            $('#valid-btn').hide();
            $('#min-up-btn').hide();
            $('#plus-up-btn').hide();
            $("#spinner").show();
            start();
            console.log('hidden')
        });
        codeReader.getVideoInputDevices()
            .then((videoInputDevices) => {
                const sourceSelect = document.getElementById('sourceSelect')
                selectedDeviceId = videoInputDevices[0].deviceId
                if (videoInputDevices.length > 1) {
                    videoInputDevices.forEach((element) => {
                        const sourceOption = document.createElement('option')
                        sourceOption.text = element.label
                        sourceOption.value = element.deviceId
                        sourceSelect.appendChild(sourceOption)
                    })

                    sourceSelect.onchange = () => {
                        selectedDeviceId = sourceSelect.value;
                        reset();
                        start();
                    }

                    const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                    sourceSelectPanel.style.display = 'block'
                }

                start();
            })
            .catch((err) => {
                console.error(err)
            })

        function fetchRecords(barcode){
            console.log('fetch');
            var uri = '{{ route("dashboard.barang.check", ":barcode") }}';
            uri = uri.replace(':barcode', barcode);
            console.log('uri', uri);
            $.ajax({
                url: uri,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    if(response['data'].length != 0)
                    {
                        var url = '{{ route("dashboard.barang.show", ":id") }}';
                        url = url.replace(':id', response['data']['id_master_barang']);
                        $('#view-detail-btn').attr("href", url);

                        $('#id-field').val(response['data']['id_master_barang']);
                        $('#id-del').val(response['data']['barcode']);
                        $('#id-store').val(response['data']['id_master_barang']);
                        $('#oke').val(response['data']['oke']);
                        $('#titip').val(response['data']['titip']);

                        $('#nama-barang').html(response['data']['nama_barang']);
                        $('#lokasi-barang').html(response['data']['nama_gudang']);
                        $('#jumlah-barang').html(response['data']['jumlah']);

                        $('#detail-barang').show();
                        $('#view-detail-btn').show();
                        $('#form-validasi').show();
                        if(response['data']['tanggal_validasi'])
                        {
                            var html = ' <i class="fa fa-check-circle-o text-success" data-toggle="tooltip" data-placement="top" title="Tervalidasi"></i>'
                            $("#scanned-id").append(html);
                        }

                        if(response['usulan_penghapusan'] > 0) $('#min-up-btn').show();
                        else $('#plus-up-btn').show();

                        $("#spinner").hide();
                    }
                    else
                    {
                        $('#detail-barang').hide();
                        $('#view-detail-btn').hide();
                        $('#form-validasi').hide();
                        $('#min-up-btn').hide();
                        $('#plus-up-btn').hide();
                        $("#spinner").hide();
                    }
                },
                error: function(jqXHR, exception) {
                    console.log(jqXHR.status);
                    console.log(exception);
                }
            })

        }
    })
</script>
@endsection