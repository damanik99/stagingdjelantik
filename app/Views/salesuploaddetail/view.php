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
    <title>VIEW</title>


    <!-- BOOTSTRAP CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/assets/css/skin-modes.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/assets/css/dark-style.css" rel="stylesheet" />

    <!-- SIDE-MENU CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/css/closed-sidemenu.css" rel="stylesheet">

    <!-- CUSTOM SCROLL BAR CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/css/icons.css" rel="stylesheet" />

    <!-- SIDEBAR CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="<?= base_url() ?>/teamplate/assets/colors/color1.css" />

    <!-- TOASTR CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- INTERNAL SELECT2 CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- INTERNAL BOOTSTRAP-DATERANGEPICKER CSS -->
    <link rel="stylesheet"
        href="<?= base_url() ?>/teamplate/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">

    <!-- INTERNAL  DATE PICKER CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

    <!-- INTERNAL  FILE UPLODE CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet"
        type="text/css" />

    <!-- INTERNAL  DATA TABLE CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />


    <style>
    th {
        color: black;
    }

    required {
        color: red;
    }

    /* tr.odd {
        background: #E5F1F4;
    } */
    </style>

</head>



<body class="app sidebar-mini dark-mode">

    <!-- GLOBAL-LOADER -->
    <!-- <div id="global-loader">
			<img src="<?= base_url() ?>/teamplate/assets/images/loader.svg" class="loader-img" alt="Loader">
		</div> -->
    <!-- /GLOBAL-LOADER -->

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
                            <h1 class="page-title">
                                <?//=$title?>
                            </h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/productcode">index</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sales Upload Information</li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->
                    <!-- ROW-1 OPEN -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title"><i class="fa fa-info-circle"></i> SALES UPLOAD INFORMATION
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered text-nowrap w-100">
                                            <tbody>
                                                <tr>
                                                    <th width="300px" style="color: white;">CODE</th>
                                                    <td>&nbsp;<?php echo $views[0]['code']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">ITEM NAME</th>
                                                    <td>&nbsp;<?php echo $views[0]['item_name']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">CHANNEL FROM</th>
                                                    <td>&nbsp;<?php echo $views[0]['organization_from']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">CHANNEL TO</th>
                                                    <td>&nbsp;<?php echo $views[0]['organization_to']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">UNIQUE NUMBER</th>
                                                    <td>&nbsp;<?php echo $views[0]['unique_number']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">INVOICE NUMBER</th>
                                                    <td>&nbsp;<?php echo $views[0]['invoice_number']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">INVOICE DATE</th>
                                                    <td>&nbsp;<?php echo $views[0]['invoice_date']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">QUANTITY</th>
                                                    <td>&nbsp;<?php echo $views[0]['quantity']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">REVENUE</th>
                                                    <td>&nbsp;<?php echo $views[0]['revenue']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">STATUS SELLING</th>
                                                    <td>&nbsp;<?php echo $views[0]['status_selling']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">STATUS UNIQUE NUMBER</th>
                                                    <td>&nbsp;<?php echo $views[0]['status_unique_number']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">CREATED DATE</th>
                                                    <td>&nbsp;<?php echo $views[0]['created_date']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="300px" style="color: white;">MODIFIED DATE</th>
                                                    <td>&nbsp;<?php echo $views[0]['modified_date']; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="<?= base_url() ?>/salesupload" type="button" class="btn btn-warning"><i
                                            class="fa fa-arrow-left mr-2"></i>Back</a>
                                </div>
                            </div>
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

    <!-- EVA-ICONS JS -->
    <script src="<?= base_url() ?>/teamplate/assets/iconfonts/eva.min.js"></script>

    <!-- SIDE-MENU JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu.js"></script>

    <!-- CUSTOM SCROLLBAR JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- SIDEBAR JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js"></script>

    <!--INTERNAL  FORMELEMENTS JS -->
    <!-- <script src="/teamplate/assets/js/form-elements.js"></script> -->
    <script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

    <!-- INTERNAL  TIMEPICKER JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/time-picker/jquery.timepicker.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/time-picker/toggles.min.js"></script>

    <!-- INTERNAL DATEPICKER JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

    <!-- INTERNAL BOOTSTRAP-DATERANGEPICKER JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- INPUT MASK JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.mask.min.js"></script>

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

    <!-- TOASTR JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</body>

</html>