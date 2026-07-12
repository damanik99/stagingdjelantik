<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Yoha –  HTML5 Bootstrap Admin Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin dashboard html template, admin dashboard template bootstrap 4, analytics dashboard templates, best admin template bootstrap 4, best bootstrap admin template, bootstrap 4 template admin, bootstrap admin template premium, bootstrap admin ui, bootstrap basic admin template, cool admin template, dark admin dashboard, dark admin template, dark dashboard template, dashboard template bootstrap 4, ecommerce dashboard template, html5 admin template, light bootstrap dashboard, sales dashboard template, simple dashboard bootstrap 4, template bootstrap 4 admin">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/teamplate/assets/images/brand/favicon.ico" />

    <!-- TITLE -->
    <title>PROGRAM</title>

    <!-- INTERNAL  DATA TABLE CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <!-- BOOTSTRAP CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/assets/css/skin-modes.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/assets/css/dark-style.css" rel="stylesheet" />

    <!-- SIDE-MENU CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/css/closed-sidemenu.css" rel="stylesheet">

    <!--PERFECT SCROLL CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet" />

    <!-- CUSTOM SCROLL BAR CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/css/icons.css" rel="stylesheet" />

    <!-- SIDEBAR CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="<?= base_url() ?>/teamplate/assets/colors/color1.css" />

    <!-- INTERNAL SELECT2 CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- INTERNAL  DATE PICKER CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

    <!-- JQUERY JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js"></script>

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
                            <!-- <h1 class="page-title"><?=$title?></h1> -->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Table</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                            </ol>
                        </div>
                        <div class="ml-auto pageheader-btn">
                            <a href="<?=base_url()?>/wizard" class="btn btn-primary btn-icon text-white mr-2">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> CREATE
                            </a>
                        </div>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create new data program, klik
                        button<i class="fe fe-plus"></i> create.<br>
                        <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create some new data program, klik
                        button <i class="fa fa-upload"></i> upload.<br>
                        <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Update data in table column "action",
                        klick button
                        <i class="fa fa-pencil"></i> (icon pencil).<br>
                        <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>View detail data in table column
                        "action", klik
                        button <i class="fa fa-eye"></i> (icon eye).<br>
                    </div>
                    <!-- PAGE-HEADER END -->
                    <!-- ROW-4 -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary br-tr-3 br-tl-3">
                                    <h3 class="card-title">DATA PROGRAM</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="exportexample"
                                            class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th class="wd-13p">Program Code</th>
                                                    <th class="wd-10p">Program Name</th>
                                                    <th class="wd-20p">Client</th>
                                                    <th class="wd-15p">Status</th>
                                                    <th class="wd-15p">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
													if(!empty($program))
													{
														for($a=0 ; $a<count($program) ; $a++)
														{ 
															$id = $program[$a]['program_id'];
													?>
                                                    <td><?=$program[$a]['code']?></td>
                                                    <td><?=$program[$a]['program_name']?></td>
                                                    <td><?=$program[$a]['company']?></td>
                                                    <td><?=$program[$a]['status_name']?></td>
                                                    <td>
                                                        <a href="<?=base_url()?>/program/edit/<?=$id?>"
                                                            class="badge badge-pill badge-success" title="Edit"><i
                                                                class="fa fa-pencil"></i></a>
                                                        <a href="<?=base_url()?>/program/view/<?=$id?>"
                                                            class="badge badge-pill badge-primary" title="view"><i
                                                                class="fa fa-eye"></i></a>
                                                    </td>

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

    <script>
    <?php if (session()->getFlashdata('success')) {?>
    alert("<?php echo session()->getFlashdata('success'); ?>");
    <?php }  ?>
    </script>

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
</body>

</html>