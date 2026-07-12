<!doctype html>
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
		<link href="<?= base_url() ?>/teamplate/assets/css/closed-sidemenu.css" rel="stylesheet">

		<!--PERFECT SCROLL CSS-->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet"/>

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- FONT-ICONS CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/css/icons.css" rel="stylesheet"/>

		<!-- SIDEBAR CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- COLOR SKIN CSS -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>/teamplate/assets/colors/color1.css" />

		<!-- INTERNAL SELECT2 CSS -->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet"/>

		<!-- INTERNAL  DATE PICKER CSS-->
		<link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet"/>

	</head>

	<body class="app sidebar-mini dark-mode">

		<!-- GLOBAL-LOADER  -->
		<div id="global-loader">
			<img src="<?= base_url() ?>/teamplate/assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>
		 <!-- GLOBAL-LOADER -->

		<!-- PAGE -->
		<div class="page">
			<div class="page-main">
              
                <!-- SIDEBAR -->	
                <?= $this->include('layout/sidebar') ?>
                <!-- END SIDEBAR -->
                <!-- TOP BAR -->
                <?= $this->include('layout/topbar') ?>				
                <!-- END TOP BAR -->
                
                <!--app-content open-->
				<div class="app-content">
					<div class="side-app">

						<!-- PAGE-HEADER -->
						<div class="page-header">
							<div>
								<h1 class="page-title"><?=$title?></h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Table</a></li>
									<li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
								</ol>
							</div>
						</div>
						<!-- PAGE-HEADER END -->
                        <!-- ROW-4 -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
                                    <div class="card-header bg-primary br-tr-3 br-tl-3">
										<h3 class="card-title"><?=$title?></h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="exportexample" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
												<thead>
                                                <tr>
                                                    <th class="wd-15p">Tracking Number</th>
                                                    <th class="wd-15p">Status</th>
                                                    <th class="wd-20p">Note</th>
                                                    <th class="wd-15p">Update Date</th>
                                                </tr>
												</thead>
												<tbody>
                                                <tr>
												<?php
													if(!empty($data))
													{
														for($a=0 ; $a<count($data) ; $a++)
														{ 
															$id = $data[$a]['redemption_id'];
													?> 
													<td><?=$data[$a]['tracking_number']?></td>
													<td><?=$data[$a]['status']?></td>
													<td><?=$data[$a]['note']?></td>
													<td><?=$data[$a]['created_date']?></td>													
												</tr>
												<?php } }else{ ?> 
												<tr>
													<td colspan="5"><b>Tidak ada data member di temukan...</b></td>
												</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- ROW-4 CLOSED-->
						

					</div>
				</div>
				<!-- CONTAINER END -->
            </div>

			<!-- FOOTER -->
			<?= $this->include('layout/footer') ?>
			<!-- FOOTER END -->
                        
		</div>
		
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

		<!-- RATING STARJS -->
		<script src="<?= base_url() ?>/teamplate/assets/plugins/rating/jquery.rating-stars.js"></script>

		<!-- EVA-ICONS JS -->
		<script src="<?= base_url() ?>/teamplate/assets/iconfonts/eva.min.js"></script>

		<!-- SIDE-MENU JS-->
		<script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu.js"></script>

		<!-- PERFECT SCROLL BAR js-->
		<script src="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.min.js"></script>
		<script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu-scroll.js"></script>

		<!-- CUSTOM SCROLLBAR JS-->
		<script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- SIDEBAR JS -->
		<script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js"></script>

		<!-- INTERNAL APEXCHART JS -->
		<script src="<?= base_url() ?>/teamplate/assets/js/apexcharts.js"></script>

		<!--INTERNAL  INDEX JS -->
		<script src="<?= base_url() ?>/teamplate/assets/js/index1.js"></script>

		<!-- CUSTOM JS -->
		<script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>
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

	</body>
</html>
