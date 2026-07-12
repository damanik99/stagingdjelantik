<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Yoha –  HTML5 Bootstrap Admin Template">
		<meta name="author" content="Spruko Technologies Private Limited">
		<meta name="keywords" content="admin dashboard html template, admin dashboard template bootstrap 4, analytics dashboard templates, best admin template bootstrap 4, best bootstrap admin template, bootstrap 4 template admin, bootstrap admin template premium, bootstrap admin ui, bootstrap basic admin template, cool admin template, dark admin dashboard, dark admin template, dark dashboard template, dashboard template bootstrap 4, ecommerce dashboard template, html5 admin template, light bootstrap dashboard, sales dashboard template, simple dashboard bootstrap 4, template bootstrap 4 admin">

		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/teamplate/assets/images/brand/favicon.ico" />

		<!-- TITLE -->
		<title><?=$title?></title>

		<!-- BOOTSTRAP CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

		<!-- STYLE CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/css/style.css" rel="stylesheet"/>
		<link href="<?= base_url() ?>/teamplate/assets/css/skin-modes.css" rel="stylesheet"/>
		<link href="<?= base_url() ?>/teamplate/assets/css/dark-style.css" rel="stylesheet"/>

		<!-- SIDE-MENU CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/css/sidemenu.css" rel="stylesheet">

		<!--PERFECT SCROLL CSS-->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet"/>

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<link href="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.css" rel="stylesheet" />

		<!--- FONT-ICONS CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/css/icons.css" rel="stylesheet"/>

		<!-- SIDEBAR CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- FORN WIZARD CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard.css" rel="stylesheet">
		<link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard_theme_arrows.css" rel="stylesheet">
		<link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard_theme_circles.css"  rel="stylesheet">
		<link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard_theme_dots.css" rel="stylesheet">
		<link href="<?= base_url() ?>/teamplate/assets/plugins/forn-wizard/css/demo.css" rel="stylesheet">

		<!-- COLOR SKIN CSS -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>assets/colors/color1.css" />

		<!-- INTERNAL  DATA TABLE CSS-->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet"/>
		<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
		<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />
                <!-- EXTERNAL  TOASTR-->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    </head>

    <body class="app sidebar-mini dark-mode">

	<!-- GLOBAL-LOADER -->
<!--	<div id="global-loader">
		<img src="<?= base_url() ?>/teamplate/assets/images/loader.svg" class="loader-img" alt="Loader">
	</div>-->
	<!-- /GLOBAL-LOADER -->

	<!-- PAGE -->
    <div class="page">
		<div class="page-main">
			<?php
				echo view('layout/sidebar');
				echo view('layout/header');
				echo view('layout/content');
				$this->renderSection('main');
				// echo view('layout/home');
				// $this->renderSection('footer');
				echo view('layout/footer');
			?>


<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

<!-- JQUERY JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/js/popper.min.js"></script>

<!-- SPARKLINE JS-->
<script src="<?= base_url() ?>/teamplate/assets/js/jquery.sparkline.min.js"></script>

<!-- CHART-CIRCLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/js/circle-progress.min.js"></script>

<!-- RATING STAR JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/rating/jquery.rating-stars.js"></script>

<!-- EVA-ICONS JS -->
<script src="<?= base_url() ?>/teamplate/assets/iconfonts/eva.min.js"></script>

<!-- INPUT MASK JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.mask.min.js"></script>

<!-- CUSTOM SCROLLBAR -->
	<script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- INTERNAL CHARTJS CHART JS -->
	<script src="<?= base_url() ?>/teamplate/assets/plugins/chart/Chart.bundle.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/chart/utils.js"></script>

<!-- SIDE-MENU JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu.js"></script>

<!-- INTERNAL PIETY CHART JS -->
	<script src="<?= base_url() ?>/teamplate/assets/plugins/peitychart/jquery.peity.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/peitychart/peitychart.init.js"></script>

<!-- PERFECT SCROLL BAR js-->
<!-- <script src="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.min.js"></script> -->
<!-- <script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu-scroll.js"></script> -->

<!-- INTERNAL  ECHART JS-->
	<script src="<?= base_url() ?>/teamplate/assets/plugins/echarts/echarts.js"></script>

<!-- CUSTOM SCROLL BAR JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- INTERNAL ACCORDION JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.js"></script>

<!-- SIDEBAR JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js"></script>

<!-- INTERNAL INDEX-SCRIPTS -->
<script src="<?= base_url() ?>/teamplate/assets/js/index5.js"></script>

<!-- INTERNAL APEXCHART JS -->
	<!-- <script src="<?= base_url() ?>/teamplate/assets/js/apexcharts.js"></script> -->

<!--INTERNAL  INDEX JS -->
<!-- <script src="<?= base_url() ?>/teamplate/assets/js/index1.js"></script> -->

<!-- INTERNAL  DATA TABLE JS-->
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/datatable.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/jszip.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/pdfmake.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/vfs_fonts.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.html5.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.print.min.js"></script>
	<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.colVis.min.js"></script>

<!-- CUSTOM JS-->
<script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>
<script>
$(document).ready(function() {
	  $( "#programid" ).change(function() {
		var programid = $('#programid').val();
		console.log(programid);
		   $.ajax({
				  type:'GET',
				  url :"<?= base_url('/dashboard/menuprivilage');?>/"+$(this).val(),
				  data:{'programid':programid},
				  beforeSend: function(){
					$("#global-loader").show();
				   },
				  success:function(data){
				   $('#resultdiv').html(data);
				   $("#global-loader").hide();
				   var slideMenu = $('.side-menu');
					// Activate sidebar slide toggle
					$("[data-toggle='slide']").on('click',function(event) {
							event.preventDefault();
							if(!$(this).parent().hasClass('is-expanded')) {
									slideMenu.find("[data-toggle='slide']").parent().removeClass('is-expanded');
							}
							$(this).parent().toggleClass('is-expanded');
					});
					// Set initial active toggle
					$("[data-toggle='slide.'].is-expanded").parent().toggleClass('is-expanded');  
				  }
			  });
	  });  

});
</script>

</body>
</html>
		
    

   