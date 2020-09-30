<!doctype html>
<html lang="en" class="no-focus">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<title>Print Usulan Pemasukan</title>

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
            <div class="col-12">
                <table border="1px">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barang as $b)
                            <tr>
                                <td>{{ $b->nama_barang }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>