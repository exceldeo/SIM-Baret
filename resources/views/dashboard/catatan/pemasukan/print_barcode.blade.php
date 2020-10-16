<!doctype html>
<html lang="en" class="no-focus">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<title>Print Barcode</title>

	<meta name="description" content="SI Presensi">
	<meta name="author" content="DPTSI ITS">
	<meta name="robots" content="noindex, nofollow">

	<!-- Icons -->
	<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
	<link rel="shortcut icon" href="https://presensi.its.ac.id/assets/media/favicons/favicon-web.png">
	<link rel="icon" type="image/png" sizes="192x192" href="https://presensi.its.ac.id/assets/media/favicons/favicon-web.png">
	<link rel="apple-touch-icon" sizes="180x180" href="https://presensi.its.ac.id/assets/media/favicons/favicon-web.png">
	<!-- END Icons -->

	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{asset('template')}}/js/plugins/select2/css/select2.min.css">
	<!-- <link rel="stylesheet" href="{{asset('template')}}/js/plugins/clockpicker/dist/jquery-clockpicker.min.css"> -->
	<link rel="stylesheet" href="{{asset('template')}}/js/plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="{{asset('template')}}/js/plugins/magnific-popup/magnific-popup.css">
	<link rel="stylesheet" href="{{asset('template')}}/js/plugins/chartjs/Chart.min.css">
	<link rel="stylesheet" href="{{asset('template')}}/js/plugins/datatables/dataTables.bootstrap4.css">
	<!-- Fonts and Codebase framework -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
	<link rel="stylesheet" id="css-main" href="{{asset('template')}}/css/codebase.min.css">
	<link rel="stylesheet" href="{{asset('template')}}/css/created/style.css">
    <link rel="stylesheet" href="{{asset('template')}}/css/its/its.css">

    <style>
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: "Muli", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            line-height: 1.2;
        }
    </style>

</head>
<body onload="window.print()">
    <div class="container-fluid">
        <div class="row">
            @foreach($barang as $b)
            <dd class="col-sm-6 text-center barcode">
                <svg id="image-{{ $b->barcode }}"></svg>
                <div class="value">{{ $b->barcode }}</div>
                {{ $b->nama_barang }}<br>
                {{ $b->nama_komponen }}<br>
                
            </dd>
            @endforeach
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">
function generateBarcode(){
    barcodes = document.getElementsByClassName('barcode');
    Array.prototype.forEach.call(barcodes, function(bar) {
        let barcodeValue = bar.getElementsByClassName('value')[0].innerHTML
        let id = '#image-' + barcodeValue
        JsBarcode(id, barcodeValue, {
            background: '#ffffff',
            lineColor: '#000000',
            width: 4
        })
    });
}
generateBarcode()
</script>
</body>
</html>