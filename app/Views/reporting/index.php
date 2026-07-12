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

    <!-- INPUT MASK JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.mask.min.js"></script>

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

    <!-- INTERNAL BOOTSTRAP-DATERANGEPICKER CSS -->
    <link rel="stylesheet"
        href="<?= base_url() ?>/teamplate/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">

    <!-- INTERNAL  TIME PICKER CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/time-picker/jquery.timepicker.css" rel="stylesheet" />

    <!-- INTERNAL  DATE PICKER CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

    <!-- JQUERY JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js"></script>

    <!-- TOASTR CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary br-tr-3 br-tl-3">
                                    <h3 class="card-title">Reporting
                                        <?//=$title?>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="btn-list" style="margin-left: 46px;">
                                            <button type="button" name="submit" class="btn btn-blue" id="att_detail">
                                                Attendance Detail
                                            </button>
                                            <button type="button" name="submit" class="btn btn-blue" id="att_sumary">
                                                Attendance Summary
                                            </button>
                                            <button type="button" name="submit" class="btn btn-blue" id="att_cons">
                                                Attendance Consistency
                                            </button>
                                            <button type="button" name="submit" class="btn btn-blue" id="att_on">
                                                Attendance Ontime
                                            </button>
                                            <button type="button" name="submit" class="btn btn-blue" id="att_vst">
                                                Attendance Visit
                                            </button>
                                            <button type="button" name="submit" class="btn btn-blue" id="att_rmp">
                                                Attendance Roadmap
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Attandance Detail -->
                                <form action='<?=base_url();?>/reporting/attendanceDetail' method="post">
                                    <div class="card-body" id="attandance_detail" style="display:none;">
                                        <h4 class="card-title">ATTENDANCE DETAIL</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE START *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="datestart"
                                                            placeholder="MM/DD/YYYY" type="text" id="datestart">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE END *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="dateend"
                                                            placeholder="MM/DD/YYYY" type="text" id="dateend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6" style="margin-top: -25px;">
                                                <div class="form-actions mt-5">
                                                    <button type="submit" name="submit" value="save"
                                                        class="btn btn-outline-primary" id="attdetail">
                                                        <i class="fa fa-file-text-o"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- finish Attandance Detail -->

                                <!-- Attandance Sumary -->
                                <form action='<?=base_url();?>/reporting/attendanceSumary' method="post">
                                    <div class="card-body" id="attandance_sumary" style="display:none;">
                                        <h4 class="card-title">ATTANDANCE SUMARY</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <select class="form-control custom-select"
                                                        data-placeholder="Choose one" name="type">
                                                        <option label="Choose one">
                                                        </option>
                                                        <option value="users">By Users</option>
                                                        <option value="city">By City</option>
                                                        <option value="region">By Region</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="datestart"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE END *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="dateend"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6" style="margin-top: -25px;">
                                                <div class="form-actions mt-5">
                                                    <button type="submit" name="submit" value="save"
                                                        class="btn btn-outline-primary">
                                                        <i class="fa fa-file-text-o"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- finish Attandance consistency -->
                                <form action='<?=base_url();?>/reporting/attendanceConsistency' method="post">
                                    <div class="card-body" id="attandance_consistency" style="display:none;">
                                        <h4 class="card-title">ATTENDANCE CONSISTENCY</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <select class="form-control custom-select"
                                                        data-placeholder="Choose one" name="type">
                                                        <option label="Choose one">
                                                        </option>
                                                        <option value="users">By Users</option>
                                                        <option value="city">By City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">TITLE</label>
                                                    <input class="form-control" type="text" name="title" id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE START *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="datestart"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE END *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="dateend"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6" style="margin-top: -25px;">
                                                <div class="form-actions mt-5">
                                                    <button type="submit" name="submit" value="save"
                                                        class="btn btn-outline-primary">
                                                        <i class="fa fa-file-text-o"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- finish Attandance Consistency -->

                                <!-- finish Attandance ontime -->
                                <form action='<?=base_url();?>/reporting/attendanceOntime' method="post">
                                    <div class="card-body" id="attandance_ontime" style="display:none;">
                                        <h4 class="card-title">ATTENDANCE ONTIME</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <select class="form-control custom-select"
                                                        data-placeholder="Choose one" name="download_type">
                                                        <option label="Choose one">
                                                        </option>
                                                        <option value="users">By Users</option>
                                                        <option value="city">By City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">TITLE</label>
                                                    <input class="form-control" type="text" name="title" id="title"
                                                        placeholder="Title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Times</label>
                                                    <input class="form-control" type="text" name="times"
                                                        placeholder="Format Late Time 00:00:00">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE START *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="datestart"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE END *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="dateend"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Leader Name</label>
                                                    <input type="text" class="form-control" placholder="Leader Name" name="leader_name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">City</label>
                                                    <input type="text" class="form-control" placholder="City" name="city">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Region</label>
                                                    <input type="text" class="form-control" placholder="Region" name="region">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6" style="margin-top: -25px;">
                                                <div class="form-actions mt-5">
                                                    <button type="submit" name="submit" value="save"
                                                        class="btn btn-outline-primary">
                                                        <i class="fa fa-file-text-o"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- finish Attandance Ontime -->

                                <!-- finish Attandance Visit -->
                                <form action='<?=base_url();?>/reporting/attendanceVisit' method="post">
                                    <div class="card-body" id="attandance_visit" style="display:none;">
                                        <h4 class="card-title">ATTENDANCE VISIT</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <select class="form-control custom-select"
                                                        data-placeholder="Choose one">
                                                        <option label="Choose one">
                                                        </option>
                                                        <option value="users">By Users</option>
                                                        <option value="city">By City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">TITLE</label>
                                                    <input class="form-control" type="text" name="title" id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="datestart"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE END *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="dateend"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6" style="margin-top: -25px;">
                                                <div class="form-actions mt-5">
                                                    <button type="submit" name="submit" value="save"
                                                        class="btn btn-outline-primary">
                                                        <i class="fa fa-file-text-o"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- finish Attandance Visit -->

                                <!-- finish Attandance Roadmap -->
                                <form action='<?=base_url();?>/reporting/attendanceRoadmap' method="post">
                                    <div class="card-body" id="attandance_roadmap" style="display:none;">
                                        <h4 class="card-title">ATTENDANCE ROADMAP</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <select class="form-control custom-select"
                                                        data-placeholder="Choose one">
                                                        <option label="Choose one">
                                                        </option>
                                                        <option value="users">By Users</option>
                                                        <option value="city">By City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">TITLE</label>
                                                    <input class="form-control" type="text" name="title" id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DOWNLOAD TYPE *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="datestart"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">DATE END *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker" name="dateend"
                                                            placeholder="MM/DD/YYYY" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6" style="margin-top: -25px;">
                                                <div class="form-actions mt-5">
                                                    <button type="submit" name="submit" value="save"
                                                        class="btn btn-outline-primary">
                                                        <i class="fa fa-file-text-o"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- finish Attandance Visit -->
                            </div>
                        </div>
                    </div>

                    <div class="row">

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

    <!-- RATING STAR JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/rating/jquery.rating-stars.js"></script>

    <!-- EVA-ICONS JS -->
    <script src="<?= base_url() ?>/teamplate/assets/iconfonts/eva.min.js"></script>

    <!-- INPUT MASK JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.mask.min.js"></script>

    <!-- CUSTOM SCROLLBAR JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- SIDE-MENU JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu.js"></script>

    <!-- SIDEBAR JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js"></script>

    <!-- INTERNAL  FILE UPLOADES JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/fileupload.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/file-upload.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

    <!-- INTERNAL BOOTSTRAP-DATERANGEPICKER JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- INTERNAL  TIMEPICKER JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/time-picker/jquery.timepicker.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/time-picker/toggles.min.js"></script>

    <!-- INTERNAL DATEPICKER JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

    <!-- INTERNAL MULTI SELECT JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/multipleselect/multiple-select.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/multipleselect/multi-select.js"></script>

    <!--INTERNAL  FORMELEMENTS JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/form-elements.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

    <!-- CUSTOM JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>

    <!-- TOASTR JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
    <?php if (session()->getFlashdata('error')) {?>
    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': false,
        'positionClass': 'toast-top-center',
        'preventDuplicates': false,
        'showDuration': '1000',
        'hideDuration': '1000',
        'timeOut': '5000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }

    toastr.warning("<?php echo session()->getFlashdata('error'); ?>");

    <?php }  ?>
    </script>

    <script>
    jQuery(document).ready(function() {
        jQuery('#att_detail').click(function() {
            attandancedetail();
        });

        jQuery('#att_sumary').click(function() {
            attandancesumary();
        });

        jQuery('#att_cons').click(function() {
            attandanceconsistency();
        });

        jQuery('#att_on').click(function() {
            attandanceontime();
        });

        jQuery('#att_vst').click(function() {
            attandancevisit();
        });

        jQuery('#att_rmp').click(function() {
            attandanceroadmap();
        });

    });

    // function attandancedetail()
    // {	
    // 	$("#attandance_detail").removeAttr("style");
    // }

    function attandancedetail() {
        var x = document.getElementById("attandance_detail");
        var attsum = document.getElementById("attandance_sumary");
        var attcons = document.getElementById("attandance_consistency");
        var attont = document.getElementById("attandance_ontime");
        var attvst = document.getElementById("attandance_visit");
        if (x.style.display === "none") {
            x.style.display = "block";
            attsum.style.display = "none";
            attcons.style.display = "none";
            attont.style.display = "none";
            attcons.style.display = "none";
            attvst.style.display = "none";
        } else {
            x.style.display = "none";
        }
    }

    function attandancesumary() {
        var x = document.getElementById("attandance_sumary");
        var attdtl = document.getElementById("attandance_detail");
        var attcons = document.getElementById("attandance_consistency");
        var attont = document.getElementById("attandance_ontime");
        var attvst = document.getElementById("attandance_visit");
        var attrmp = document.getElementById("attandance_roadmap");
        if (x.style.display === "none") {
            x.style.display = "block";
            attdtl.style.display = "none";
            attcons.style.display = "none";
            attont.style.display = "none";
            attvst.style.display = "none";
            attrmp.style.display = "none";
        } else {
            x.style.display = "none";
        }
    }

    function attandanceconsistency() {
        var x = document.getElementById("attandance_consistency");
        var attdtl = document.getElementById("attandance_detail");
        var attsum = document.getElementById("attandance_sumary");
        var attont = document.getElementById("attandance_ontime");
        var attrmp = document.getElementById("attandance_roadmap");
        if (x.style.display === "none") {
            x.style.display = "block";
            attdtl.style.display = "none";
            attsum.style.display = "none";
            attont.style.display = "none";
            attrmp.style.display = "none";
        } else {
            x.style.display = "none";
        }
    }

    function attandanceontime() {
        var x = document.getElementById("attandance_ontime");
        var attdtl = document.getElementById("attandance_detail");
        var attsum = document.getElementById("attandance_sumary");
        var attcons = document.getElementById("attandance_consistency");
        var attvst = document.getElementById("attandance_visit");
        var attrmp = document.getElementById("attandance_roadmap");
        if (x.style.display === "none") {
            x.style.display = "block";
            attdtl.style.display = "none";
            attsum.style.display = "none";
            attcons.style.display = "none";
            attvst.style.display = "none";
            attrmp.style.display = "none";
        } else {
            x.style.display = "none";
        }
    }

    function attandancevisit() {
        var x = document.getElementById("attandance_visit");
        var attdtl = document.getElementById("attandance_detail");
        var attsum = document.getElementById("attandance_sumary");
        var attcons = document.getElementById("attandance_consistency");
        var atton = document.getElementById("attandance_ontime");
        var attrmp = document.getElementById("attandance_roadmap");
        if (x.style.display === "none") {
            x.style.display = "block";
            attdtl.style.display = "none";
            attsum.style.display = "none";
            attcons.style.display = "none";
            atton.style.display = "none";
            attrmp.style.display = "none";
        } else {
            x.style.display = "none";
        }
    }

    function attandanceroadmap() {
        var x = document.getElementById("attandance_roadmap");
        var attdtl = document.getElementById("attandance_detail");
        var attsum = document.getElementById("attandance_sumary");
        var attcons = document.getElementById("attandance_consistency");
        var atton = document.getElementById("attandance_ontime");
        var attvst = document.getElementById("attandance_visit");
        if (x.style.display === "none") {
            x.style.display = "block";
            attdtl.style.display = "none";
            attsum.style.display = "none";
            attcons.style.display = "none";
            atton.style.display = "none";
            attvst.style.display = "none";
        } else {
            x.style.display = "none";
        }
    }
    </script>

</body>

</html>