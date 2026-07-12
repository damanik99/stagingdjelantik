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
                
                <!-- TOASTR CSS -->
                <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

	</head>

	<body class="app sidebar-mini dark-mode">

                <!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="<?= base_url() ?>/teamplate/assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>
                <!--/GLOBAL-LOADER -->

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
									<li class="breadcrumb-item"><a href="#">Form</a></li>
									<li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
								</ol>
							</div>
						</div>
						<!-- PAGE-HEADER END -->
                                                
                                                   <!-- ROW-1 OPEN -->
						<div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                              <form action='<?=base_url();?>/menu/savemenu' enctype="multipart/form-data" method="post" accept-charset="utf-8" > 
                                                        
                                                        
                                                                    <div class="card">
                                                                            <div class="card-header bg-primary">
                                                                                    <h3 class="mb-0 card-title"><?=$title?> Information</h3>
                                                                            </div>

                                                                            <div class="card-body">
                                                                                    <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                    <div class="form-group">
                                                                                                            <label class="form-label">PARENT<b class="text-danger">*</b></label>
                                                                                                             <select name="parent" id="parent" class="form-control custom-select" required="">
                                                                                                                        <option value="">--Select Parent--</option>
                                                                                                                     <?php foreach ($parent as $r) { ?>
                                                                                                                        <option value="<?php echo $r->menu_id ?>"><?php echo $r->name ?></option>
                                                                                                                     <?php } ?>
                                                                                                             </select>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                             <label class="form-label">ACTION<b class="text-danger">*</b> </label>
                                                                                                             <select name="action" id="action" class="form-control custom-select" required="">
                                                                                                                        <option value="">--Select Action--</option>
                                                                                                                    <?php foreach ($action as $r) { ?>
                                                                                                                        <option value="<?php echo $r->action_id ?>"><?php echo $r->name ?></option>
                                                                                                                     <?php } ?>      
                                                                                                             </select>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                            <label class="form-label">ICON MENU</label>
                                                                                                            <input type="text" class="form-control" name="image_url" placeholder="Ex. fa fa-desktop" alt="Icon use font awesome">
                                                                                                    </div>
                                                                                                   
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                    <div class="form-group">
                                                                                                             <label class="form-label">PAGE<b class="text-danger">*</b></label>
                                                                                                             <select name="page" id="page" class="form-control custom-select" required="">
                                                                                                                     <option value="">--Select Page--</option>
                                                                                                                     <?php foreach ($page as $r) { ?>
                                                                                                                        <option value="<?php echo $r->page_id ?>"><?php echo $r->name ?></option>
                                                                                                                     <?php } ?>
                                                                                                             </select>
                                                                                                    </div>
                                                                                                    
                                                                                                    <div class="form-group">
                                                                                                            <label class="form-label">NAME<b class="text-danger">*</b> </label>
                                                                                                            <input type="text" class="form-control" name="name" placeholder="Ex. Master Data" required="">
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                            <label class="form-label">SEQUENCE <b class="text-danger">*</b> </label>
                                                                                                            <input type="text" class="form-control" name="sequence" placeholder="Ex. Sequence 1" required="">
                                                                                                    </div>

                                                                                            </div>

                                                                                            <div class="col-md-6">
                                                                                                    <div class="form-group">
                                                                                                            <label class="form-label">DESCRIPTION </label>
                                                                                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                                 <div class="form-actions text-center mt-5">
                                                                                    <a class="btn btn-warning mr-1" href="<?=base_url()?>/menu" role="button"><i class="fa fa-window-close"></i> Cancel</a>
                                                                                    <button type="submit" name="save" class="btn btn-primary">
                                                                                    <i class="fa fa-save"></i> Save
                                                                                    </button>
                                                                                </div> 
                                                                            </div>

                                                                               

                                                                    </div>
                                                                    </form>
                                                            </div><!-- COL END -->

                                                         

                                                        </div>
						</div>
						<!-- ROW-1 CLOSED -->

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
<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                <script type="text/javascript">
                    <?php if (session()->getFlashdata('success')) {?>
                        toastr.success("<?php echo session()->getFlashdata('success'); ?>");
                    <?php }  ?>
                      
                        
                </script>  
               
	</body>
</html>
