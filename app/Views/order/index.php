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
    <title><?=$title?></title>


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

    <!-- INTERNAL ACCORDION CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.css" rel="stylesheet" />

    <!-- INTERNAL  DATEPICKER CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />

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
                                <li class="breadcrumb-item"><a href="#">Table List Data</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->

                    <!-- ROW-1 OPEN -->
                    <div class="row row-deck">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Generate Report</h3>
                                </div>
                                <div class="card-body">
                                    <!-- ACCORDION BEGIN -->
                                    <ul class="generate-accordion accordionjs m-0" data-active-index="false">
                                        <!-- SECTION 1 -->
                                        <li>
                                            <div>
                                                <h3>Export Detail Order Report</h3>
                                            </div>
                                            <div>

                                                <div class="card-body">
                                                    <form action='<?=base_url();?>/order/report' method="post">
                                                        <div class="row">

                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class="form-label">Start Date</label>
                                                                    <input type="text" class="form-control"
                                                                        name="startdate" id="startdate">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class="form-label">End Date</label>
                                                                    <input type="text" class="form-control"
                                                                        name="enddate" id="enddate">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group" style="margin-top: 12px;">
                                                                    <button type="submit" name="seacrh" value="seacrh"
                                                                        class="btn btn-primary mt-5">
                                                                        <i class="fa fa-search-plus"> </i> Search
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- SECTION 2 -->

                                    </ul>
                                </div>
                            </div>
                        </div><!-- COL-END -->
                    </div>
                    <!-- ROW-1 CLOSED -->

                    <!-- ROW-4 -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary br-tr-3 br-tl-3">
                                    <h3 class="card-title">List Data <?=$title?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="tabledata"
                                            class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th class="wd-15p">Order ID</th>
                                                    <th class="wd-15p">Order Date</th>
                                                    <th class="wd-15p">Member Name</th>
                                                    <th class="wd-15p">Mobile Phone</th>
                                                    <th class="wd-25p">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php 
                                                        if(!empty($view)){
                                                        for($a=0 ; $a<count($view) ; $a++){ 
                                                            $OrderID = $view[$a]['OrderID'];
                                                        ?>
                                                    <td><?=$view[$a]['OrderID']?></td>
                                                    <td><?=$view[$a]['OrderDate']?></td>
                                                    <td><?=$view[$a]['first_name']?></td>
                                                    <td><?=$view[$a]['MobilePhone']?></td>
                                                    <td>
                                                        <a href="<?=base_url()?>/order/detail/<?=$OrderID?>"
                                                            class="badge badge-pill badge-primary" title="Edit"><i
                                                                class="fa fa-eye"></i></a>
                                                    </td>

                                                </tr>
                                                <?php } }else{ ?>
                                                <tr>
                                                    <td colspan="5"><b>No data found...</b></td>
                                                </tr>
                                                <?php } ?>
                                                </tr>
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


    <!--INTERNAL  INDEX JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/index1.js"></script>

    <!-- CUSTOM JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>

    <!-- INTERNAL ACCORDION JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.min.js"></script>

    <!-- INTERNAL  DATA TABLE JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

    <!-- INTERNAL DATEPICKER JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script>
    $(function(e) {
        $(".generate-accordion").accordionjs();
    });

    $(function() {

        $("#startdate").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $("#enddate").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

    });

    $('#tabledata').DataTable({
        order: false,
        columnDefs: [{
            targets: "_all",
            orderable: false
        }],
        "paging": true,
        "lengthMenu": [
            [10, 25, 50, 100, 1000, -1],
            [10, 25, 50, 100, 1000, "All"]
        ],
        "pagingType": "full_numbers",
        "pageLength": 10


    });
    </script>

</body>

</html>