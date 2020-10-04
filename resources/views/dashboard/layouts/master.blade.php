<!doctype html>
<html lang="en" class="no-focus">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<title>@yield('title')</title>

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

	<!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
	<!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
    @yield('css')
</head>
<body>

<div id="page-container" class="enable-page-overlay side-scroll page-header-modern main-content-boxed">
	<!-- Header -->
	<header id="page-header">
		<!-- Header Content -->
		<div class="content-header">
			<!-- Left Section -->
			<div class="content-header-section">
				<!-- Toggle Sidebar -->
				<div class="content-header-item">
				</div>
				<!-- END Toggle Sidebar -->
			</div>
			<!-- END Left Section -->

			<!-- Right Section -->
			<div class="content-header-section">
				<!-- Scan Barcode -->
				<a href="{{route('scan')}}">
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-rounded btn-dual-secondary" id="scan-barcode">
							<i class="fa fa-barcode d-sm-none"></i>
								<span class="d-none d-sm-inline-block"><i class="fa fa-barcode">
									</i> 
										<span>Pindai Barcode</span>
								</span>
						</button>
					</div>
				</a>
				<!-- END Scan Barcode -->
                <!-- User Dropdown -->
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-user d-sm-none"></i>
							<span class="d-none d-sm-inline-block"><i class="fa fa-user">
								</i> 
									<span>{{ Auth::user()->nama_user }}</span>
							</span>
						<i class="fa fa-angle-down ml-5"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
						<a class="dropdown-item" href="{{route('dashboard.logout')}}">
							<i class="fa ffa-arrow-circle-left mr-5"></i> Keluar
						</a>
					</div>
				</div>
				<!-- END User Dropdown -->
			</div>
			<!-- END Right Section -->
		</div>
		<!-- END Header Content -->

		<!-- Header Loader -->
		<div id="page-header-loader" class="overlay-header bg-primary">
			<div class="content-header content-header-fullrow text-center">
				<div class="content-header-item">
					<i class="fa fa-sun-o fa-spin text-white"></i>
				</div>
			</div>
		</div>
		<!-- END Header Loader -->
	</header>
	<!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
    @yield('breadcrumb')
    @yield('main')
    </main>
	<!-- END Main Container -->

	<!-- Footer -->
	<footer id="page-footer" class="opacity-0">
		<div class="content py-20 font-size-xs clearfix">
			<div class="row align-items-center">
				<div class="col-6">Copyright &copy; <span class="js-year-copy"></span> Institut Teknologi Sepuluh Nopember</div>
				<div class="col-6 text-right">
					<img src="https://presensi.its.ac.id/assets/media/img/logo-its-biru.png" height="40">
					<img src="https://presensi.its.ac.id/assets/media/img/logo-its-semangat-baru.png" height="40px">
				</div>
			</div>
		</div>
	</footer>
	<!-- END Footer -->
</div>
<!-- END Page Container -->

<script src="{{asset('template')}}/js/codebase.core.min.js"></script>
<script src="{{asset('template')}}/js/codebase.app.min.js"></script>
<script src="{{asset('template')}}/js/plugins/select2/js/select2.full.min.js"></script>
<script src="{{asset('template')}}/js/plugins/masked-inputs/jquery.maskedinput.min.js"></script>
<script src="{{asset('template')}}/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('template')}}/js/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="{{asset('template')}}/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="{{asset('template')}}/js/plugins/chartjs/Chart.min.js"></script>
<script>
	$('.input-time').toArray().forEach(function (field) {
		new Cleave(field, {
			time: true,
			timePattern: ['h', 'm']
		});
	});

	jQuery(function () {
		Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs', 'slimscroll', 'magnific-popup']);
	});
</script>
@yield('js')
</body>
</html>
