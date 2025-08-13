<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html> <![endif]-->
<!--[if !IE]><!--><html><!-- <![endif]-->
<head>
	<title><?= get_myconf('company_name')?></title>
	
	<!-- Meta -->
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	
	<!-- 
	**********************************************************
	In development, use the LESS files and the less.js compiler
	instead of the minified CSS loaded by default.
	**********************************************************
	<link rel="stylesheet/less" href="<?= base_url();?>/assets/less/admin/module.admin.page.index.less" />
	-->
	<link rel="shortcut icon" href="<?= base_url();?>assets/images/icon_siRaja.png">
		<!--[if lt IE 9]><link rel="stylesheet" href="<?= base_url();?>/assets/components/library/bootstrap/css/bootstrap.min.css" /><![endif]-->
	<link rel="stylesheet" href="<?= base_url();?>/assets/css/admin/module.admin.page.index.min.css" />
	
	<!--table-->
	<link rel="stylesheet" href="<?= base_url();?>/assets/css/admin/module.admin.page.tables.min.css" />
	<!--akun-->
	<link rel="stylesheet" href="<?= base_url();?>/assets/css/admin/module.admin.page.my_account.min.css" />
	<!--chart-->
	
	<!--notifications-->
	<link rel="stylesheet" href="<?= base_url();?>/assets/css/admin/module.admin.page.notifications.min.css" />
	<link rel="stylesheet" href="<?= base_url();?>/assets/css/admin/module.admin.page.form_elements.min.css" />

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

<script src="<?= base_url();?>/assets/components/library/jquery/jquery.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/library/jquery/jquery-migrate.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/library/modernizr/modernizr.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/plugins/less-js/less.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/library/jquery-ui/js/jquery-ui.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js?v=v1.2.3"></script>	
<!--chart-->

</head>
<script>
	var site_url = "<?= site_url()?>";
</script>
<script type='text/javascript'>
	
</script>
<body class="">
<div class="navbar navbar-fixed-top navbar-primary main" role="navigation">
<?= $this->load->view('tpl_header');?>
</div>
<div id="menu" class="hidden-print hidden-xs">
	<?= $this->load->view('tpl_sidebar');?>
</div>

	<div class="lead separator center relativeWrap" style="margin-bottom: -89px;" id="progres_cont">
		<p class="innerTB margin-none">
			<i class="fa fa-spinner fa-spin fa-large"></i> Mohon tunggu  ...
		</p>
	</div>
	<div id="app-content"></div> 

		<!-- // Content END -->
		
		<div class="clearfix"></div>
		<!-- // Sidebar menu & content wrapper END -->
		
		<div id="footer" class="hidden-print">
			
			<!--  Copyright Line -->
			<div class="copy">&copy; 2016 - <a href="http://www.siRaja.com">siRaja</a> - All Rights Reserved. </div>
			<!--  End Copyright Line -->
	
		</div>
		<!-- // Footer END -->
		
	</div>
	<!-- // Main Container Fluid END -->
	

	

	<!-- Global -->
	<script>
	var basePath = '',
		commonPath = '<?= base_url();?>/assets/',
		rootPath = '<?= base_url();?>/',
		DEV = false,
		componentsPath = '<?= base_url();?>/assets/components/';
	
	var primaryColor = '#cb4040',
		dangerColor = '#b55151',
		infoColor = '#466baf',
		successColor = '#8baf46',
		warningColor = '#ab7a4b',
		inverseColor = '#45484d';
	
	var themerPrimaryColor = primaryColor;
	</script>
	
	<script src="<?= base_url();?>/assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/plugins/nicescroll/jquery.nicescroll.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/plugins/breakpoints/breakpoints.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/core/js/animations.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/widgets/widget-chat/assets/js/widget-chat.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/plugins/slimscroll/jquery.slimscroll.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/bootstrap-datepicker/assets/lib/js/bootstrap-datepicker.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/charts/easy-pie/assets/lib/js/jquery.easy-pie-chart.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/charts/easy-pie/assets/custom/easy-pie.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/widgets/widget-scrollable/assets/js/widget-scrollable.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/plugins/holder/holder.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/core/js/sidebar.main.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/core/js/sidebar.collapse.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/helpers/themer/assets/plugins/cookie/jquery.cookie.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/core/js/core.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/uniform/assets/custom/js/uniform.init.js?v=v1.2.3"></script>

<script src="<?= base_url();?>/assets/components/core/js/my_scripts.js"></script>
<!--table-->
<script src="<?= base_url();?>/assets/components/modules/admin/tables/datatables/assets/lib/js/jquery.dataTables.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/tables/datatables/assets/lib/extras/TableTools/media/js/TableTools.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/tables/datatables/assets/lib/extras/ColVis/media/js/ColVis.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/tables/datatables/assets/custom/js/DT_bootstrap.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/tables/datatables/assets/custom/js/datatables.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/tables/classic/assets/js/tables-classic.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/forms/elements/select2/assets/lib/js/select2.js?v=v1.2.3"></script>
<!--chart
<script src="<?= base_url();?>assets/js/flot/jquery.flot.js"></script>
<script src="<?= base_url();?>assets/js/flot/jquery.flot.resize.js"></script>
<script src="<?= base_url();?>assets/js/flot/jquery.flot.pie.js"></script>
<script src="<?= base_url();?>assets/js/flot/jquery.flot.stack.js"></script>
<script src="<?= base_url();?>assets/js/flot/jquery.flot.crosshair.js"></script>
<script src="<?= base_url();?>assets/js/flot/numeral.min.js"></script>
-->
<script src="<?= base_url();?>assets/js/loader.js"></script>
<!--gritter-->
<script src="<?= base_url();?>/assets/components/modules/admin/notifications/gritter/assets/lib/js/jquery.gritter.min.js?v=v1.2.3"></script>
<script src="<?= base_url();?>/assets/components/modules/admin/notifications/gritter/assets/custom/js/gritter.init.js?v=v1.2.3"></script>
<script src="<?= base_url();?>assets/js/bootbox.js"></script>
<script src="<?= base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
         loadMainContent('main/dashboard');
		 google.charts.load('current', {'packages':['corechart']});
	
      });
   </script>
</body>
</html>
<!--
Author: Rickytarius
Author URL: http://www.bayssl.com
-->
