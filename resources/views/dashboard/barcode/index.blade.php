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
                <a id="view-detail-btn" class="btn btn-info mb-5">Lihat detail</a>
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
                    console.log(result.text)
                    document.getElementById('scanned-id').innerHTML = result.text
                    var url = '{{ route("dashboard.barang.detail", ":id") }}';
                    url = url.replace(':id', result.text);
                    console.log(url)
                    $('#view-detail-btn').attr("href", url);
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
            var modalDialog = $(this).find(".modal-dialog");
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        $(".modal").on("shown.bs.modal", alignModal);

        //on hidden
        $(".modal").on("hidden.bs.modal", function(){
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
    })
</script>
@endsection