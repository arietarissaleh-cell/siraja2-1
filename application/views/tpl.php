<!doctype html>
<html lang="en">

<head>
	<title>Sistem informasi Rajawali 2</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Iconic Bootstrap 4.5.0 Admin Template">
	<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

	<link rel="icon" href="<?= base_url(); ?>/assets/images/id_foof_icon.png" type="image/x-icon">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/dist/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link href="<?= base_url(); ?>/assets/assets_ui/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="assets/dist/assets/vendor/font-awesome/css/font-awesome.min.css">

	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/dist/assets/css/main.css">
	<!-- Data Tables CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/dataTables.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/fixedColumns.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/fixedHeader.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/responsive.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/rowGroup.dataTables.min.css">
	<!-- Data Tables CSS -->

	<!-- STEPS Js -->
	<link href="<?= base_url(); ?>/assets/css/steps/normalize.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>/assets/css/steps/jquery.steps.css" rel="stylesheet" type="text/css" />
	<!-- STEPS Js -->

	<link href="<?= base_url(); ?>/assets/assets_ui/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/lightbox2-2.11.3/src/css/lightbox.css">

	<script src='<?= base_url() ?>/assets/assets_ui/js/mapbox-gl-js/v2.12.0/mapbox-gl.js'></script>
	<link href='<?= base_url() ?>/assets/assets_ui/js/mapbox-gl-js/v2.12.0/mapbox-gl.css' rel='stylesheet' />
	<link href="<?= base_url() ?>/assets/assets_ui/js/viewerjs@1.11.3/dist/viewer.min.css" rel="stylesheet">
	<script src="<?= base_url() ?>/assets/assets_ui/js/viewerjs@1.11.3/dist/viewer.min.js"></script>


	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/leaflet.css" />
	<link rel="stylesheet" src="<?= base_url() ?>/assets/Leaflet.SidePanel-main/Leaflet.SidePanel-main/dist/leaflet-sidepanel.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/leaflet-routing-machine.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/L.Control.Locate.min.css" />
	<script src="<?= base_url(); ?>assets/js/leaflet.js"></script>

	<script src="<?= base_url(); ?>assets/js/leaflet.draw.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/terraformer.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/terraformer-wkt-parser.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/proj4.js"></script>
	<script src="<?= base_url(); ?>assets/js/proj4leaflet.min.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/geosearch.css" />
	<script src="<?= base_url(); ?>assets/js/geosearch.umd.js"></script>
	<script src="<?= base_url(); ?>assets/js/L.Control.Locate.min.js"></script>

	<link rel="stylesheet" src="<?= base_url(); ?>assets/css/zoomist.min.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/leaflet.draw.css">

	<script src="<?= base_url(); ?>assets/js/zoomist.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/turf.min.js" integrity="sha512-Q7HOppxoH0L2M7hreVoFCtUZimR2YaY0fBewIYzkCgmNtgOOZ5IgMNYxHgfps0qrO1ef5m7L1FeHrhXlq1I9HA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?= base_url(); ?>assets/js/shapefile.min.js"></script>


	<link rel="stylesheet" href="<?= base_url() ?>/assets/leaflet-panel-layers-master/src/leaflet-panel-layers.css" />
	<script src="<?= base_url() ?>/assets/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>

	<link rel="stylesheet" href="<?= base_url() ?>/assets/leaflet-sidebar-v2-master/css/leaflet-sidebar.css" />

	<script src="<?= base_url(); ?>assets/js/turf.min.js"></script>

	<script src='<?= base_url(); ?>assets/js/Leaflet.fullscreen.min.js'></script>
	<link href='<?= base_url(); ?>assets/css/leaflet.fullscreen.css' rel='stylesheet' />
	<script src="<?= base_url(); ?>assets/js/compressor.min.js"></script>

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/slick.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/slick-theme.min.css" />
	<script src="<?= base_url(); ?>assets/js/leaflet-routing-machine.js"></script>

	<script src="<?= base_url() ?>/assets/leaflet-easyprint/leaflet.easyPrint.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/leaflet-easyprint/easyPrint.css">


</head>

<style>

</style>

<script>
	var site_url = "<?= site_url() ?>";
</script>

<body data-theme="light" class="font-nunito">

	<div id="wrapper" class="theme-cyan">

		<!-- Page Loader -->
		<?php $this->load->view('tpl_header'); ?>

		<?php $this->load->view('tpl_sidebar'); ?>

		<!-- rightbar icon div -->
		<div class="right_icon_bar">
			<ul>
				<li><a href="javascript:void(0);" class="right_icon_btn"><i class="fa fa-angle-right"></i></a></li>
			</ul>
		</div>

		<!-- mani page content body part -->
		<div id="main-content">
			<div id="app-content">

			</div>
		</div>

	</div>

	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/pivot.min.css">
	<!-- Javascript -->
	<script src="assets/dist/assets/bundles/libscripts.bundle.js"></script>

	<script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>



	<script src="<?= base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>

	<script src="<?= base_url(); ?>/assets/assets_ui/libs/metismenu/metisMenu.min.js"></script>
	<script src="<?= base_url(); ?>/assets/assets_ui/libs/simplebar/simplebar.min.js"></script>
	<script src="<?= base_url(); ?>/assets/assets_ui/libs/node-waves/waves.min.js"></script>

	<script src="<?= base_url(); ?>/assets/leaflet-sidebar-v2-master/js/leaflet-sidebar.js"></script>

	<script src="<?= base_url() ?>/assets/js/steps/modernizr-2.6.2.min.js"></script>
	<script src="<?= base_url() ?>/assets/js/steps/jquery.validate.min.js"></script>
	<script src="<?= base_url() ?>/assets/js/steps/jquery.cookie-1.3.1.js"></script>
	<script src="<?= base_url() ?>/assets/js/steps/jquery.steps.js"></script>

	<script src="<?= base_url(); ?>/assets/assets_ui/libs/toastr/build/toastr.min.js"></script>

	<!-- scan kamera -->
	<script src="<?= base_url(); ?>assets/js/html5-qrcode.min.js" type="text/javascript"></script>

	<script src="<?= base_url(); ?>/assets/assets_ui/js/pages/sweet-alerts.init.js"></script>
	<script src="<?= base_url(); ?>/assets/assets_ui/libs/sweetalert2/sweetalert2.min.js"></script>
	<!-- Versi Lama -->
	<!-- <link rel="stylesheet" href="<?= base_url(); ?>/assets/assets_ui/js/datatables/1.12.1/css/jquery.dataTables.min.css"> -->
	<!-- <script type="text/javascript" src="<?= base_url(); ?>/assets/assets_ui/js/datatables/1.12.1/js/jquery.dataTables.min.js"></script> -->
	<!-- Versi Lama -->

	<!-- Data Tables JS -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/dataTables.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/dataTables.fixedColumns.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/fixedColumns.dataTables.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/dataTables.fixedHeader.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/dataTables.rowGroup.min.js"></script>




	<script src="<?= base_url() ?>/assets/assets_ui/js/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link href="<?= base_url() ?>/assets/assets_ui/js/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!-- <script src="<?= base_url() ?>/assets/assets_ui/js/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

	<script type="text/javascript" src="<?= base_url() ?>/assets/assets_ui/js/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>/assets/assets_ui/js/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>/assets/assets_ui/js/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>




	<script src="<?= base_url(); ?>/assets/ckeditor/ckeditor.js"></script>

	<script src="<?= base_url(); ?>assets/js/slick.min.js"></script>

	<script src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
	<script src="<?= base_url(); ?>assets/js/pivot.min.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/d3_renderers.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/c3_renderers.min.js"></script> -->
	<!-- xlsx Library -->
	<script src="<?= base_url(); ?>assets/js/xlsx.full.min.js"></script>
	<!-- FileSaver Library -->
	<script src="<?= base_url(); ?>assets/js/FileSaver.min.js"></script>

	<!-- tableExport Library -->
	<script src="<?= base_url(); ?>assets/js/tableexport.min.js"></script>

	<!-- jspdf-autotable Plugin -->
	<script src="<?= base_url(); ?>assets/js/jspdf.plugin.autotable.min.js"></script>





	<script src="<?= base_url(); ?>/assets/assets_ui/js/app.js"></script>
	<script src="<?= base_url(); ?>/assets/js/my_scripts.js"></script>





	<script type="text/javascript" src="<?= base_url(); ?>assets/lightbox2-2.11.3/src/js/lightbox.js"></script>
	<script src="assets/dist/assets/bundles/vendorscripts.bundle.js"></script>
	<!-- page js file -->
	<script src="assets/dist/assets/bundles/mainscripts.bundle.js"></script>


	<script type="text/javascript">
		$(document).ready(function() {
			loadMainContent('main/dashboard');
			$("body").toggleClass("right_icon_toggle")
		});

		function confirmLogout(url) {
			Swal.fire({
				title: 'Yakin mau logout?',
				text: "Kamu akan keluar dari sistem",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Logout!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = url;
				}
			});
		}
	</script>
</body>

</html>