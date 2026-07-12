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
    <title>CREATE</title>


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

    <!-- SIDEBAR CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- INTERNAL BOOTSTRAP-DATERANGEPICKER CSS -->
    <link rel="stylesheet"
        href="<?= base_url() ?>/teamplate/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">

    <!-- INTERNAL  TIME PICKER CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/time-picker/jquery.timepicker.css" rel="stylesheet" />

    <!-- INTERNAL  DATE PICKER CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

    <!-- INTERNAL  MULTI SELECT CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/teamplate/assets/plugins/multipleselect/multiple-select.css">

    <!-- INTERNAL TELEPHONE CSS-->
    <link rel="stylesheet" href="<?= base_url() ?>/teamplate/assets/plugins/telephoneinput/telephoneinput.css">

    <!--- FONT-ICONS CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/css/icons.css" rel="stylesheet" />

    <!-- SIDEBAR CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- COLOR SKIN CSS -->
    <!-- <link id="theme" rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>/teamplate/assets/colors/color1.css" /> -->

    <!-- TOASTR CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- INTERNAL SELECT2 CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- JQUERY JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js"></script>

    <link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />

    <style>
    required {
        color: red;
    }
    </style>
</head>

<body class="app sidebar-mini dark-mode">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="<?= base_url() ?>/teamplate/assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/salesupload">Index</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create Sales Upload</li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->

                    <!-- ROW-1 OPEN -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="mb-0 card-title">CREATE SALES UPLOAD</h3>
                                </div>
                                <form id="salesupload" action='<?=base_url();?>/salesupload/add' method="post"
                                    enctype="multipart/form-data">
                                    <div class="card-body">
                                        <?= session()->getFlashdata('message'); ?>
                                        <?= session()->getFlashdata('error'); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">CODE<required>*</required>
                                                    </label>
                                                    <input type="text" class="form-control" name="code"
                                                        placeholder="code" value="<?= $code ?>" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">ITEM NAME<required> *</required>
                                                    </label>
                                                    <select class="form-control select2-show-search"
                                                        name="program_item_id" required="">
                                                        <option value="">--Select One--</option>
                                                        <?php foreach($item as $row): ?>
                                                        <option value="<?php echo $row['program_item_id'];?>"
                                                            id="item_name">
                                                            <?php echo $row['namaitem'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">INVOICE NUMBER
                                                    </label>
                                                    <input type="text" class="form-control" name="invoice_number"
                                                        placeholder="invoice number" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">INVOICE DATE
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input type="text" class="form-control fc-datepicker"
                                                            name="invoice_date" placeholder="YYYY-MM-DD" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">SELLING DATE<required> *</required>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input type="text" class="form-control fc-datepicker"
                                                            name="selling_date" placeholder="YYYY-MM-DD" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">UNIQUE NUMBER<required> *</required>
                                                    </label>
                                                    <input type="text" class="form-control" name="unique_number"
                                                        placeholder="unique number" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">QUANTITY
                                                    </label>
                                                    <input type="text" class="form-control" name="quantity"
                                                        placeholder="quanity">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">REVENUE
                                                    </label>
                                                    <input type="text" class="form-control" name="revenue"
                                                        placeholder="revenue">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">ORGANIZATION FROM <required>*</required>
                                                    </label>
                                                    <select class="form-control select2-show-search"
                                                        name="organization_from" required>
                                                        <option value="">--Select One--</option>
                                                        <?php foreach($organization as $row): ?>
                                                        <option value="<?php echo $row['client_organization_id'];?>">
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">ORGANIZATION TO <required>*</required>
                                                    </label>
                                                    <select class="form-control select2-show-search"
                                                        name="organization_to" required>
                                                        <option value="">--Select One--</option>
                                                        <?php foreach($organization as $row): ?>
                                                        <option value="<?php echo $row['client_organization_id'];?>">
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">SALES STATUS<required> *</required>
                                                    </label>
                                                    <select class="form-control" id="status" name="status" required>
                                                        <option value="">--Select One--</option>
                                                        <option value="distribution">Distribution</option>
                                                        <option value="online">Online</option>
                                                        <option value="project">Project</option>
                                                        <option value="retail">Retail</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions text-center mt-5">
                                            <a class="btn btn-warning mr-1" href="<?=base_url()?>/SalesUpload/index"
                                                role="button"><i class="fa fa-window-close"></i> Cancel</a>
                                            <button type="submit" name="save" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- COL END -->
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

    <script>
    <?php if (session()->getFlashdata('success')) {?>
    alert("<?php echo session()->getFlashdata('success'); ?>");
    <?php }  ?>

    <?php if (session()->getFlashdata('error')) {?>
    alert("<?php echo session()->getFlashdata('error'); ?>");
    <?php }  ?>
    </script>

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

    <!-- PERFECT SCROLL BAR js-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu-scroll.js"></script>

    <!-- SIDEBAR JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js"></script>

    <!--INTERNAL  FORMELEMENTS JS -->
    <!-- <script src="/teamplate/assets/js/form-elements.js"></script> -->
    <script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

    <!-- INTERNAL DATEPICKER JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

    <!--INTERNAL  ADVANCED FORM JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/advancedform.js"></script>

    <!-- CUSTOM JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>

    <script>
    // datepicker
    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd',
        maxDate: '0'
    });

    // $(document).ready(function() {
    //     $('#salesupload').on('submit', function(e) {
    //         e.preventDefault(); // Cegah submit awal

    //         var uniqueNumber = $('input[name="unique_number"]').val();

    //         if (uniqueNumber) {
    //             $.ajax({
    //                 url: "<?//= base_url('/salesupload/checkSN'); ?>",
    //                 type: "POST",
    //                 data: {
    //                     unique_number: uniqueNumber
    //                 },
    //                 dataType: "json",
    //                 success: function(response) {
    //                     console.log(response);
    //                     if (response == "ok") {
    //                         alert(
    //                             "Unique number sudah ada. Silakan masukkan nomor yang berbeda."
    //                         );
    //                     } else {
    //                         $('#salesupload')[0].submit();
    //                         // Kirim form jika tidak ada duplikasi
    //                     }
    //                 },
    //                 error: function() {
    //                     alert("Terjadi kesalahan saat memeriksa unique number.");
    //                 }
    //             });
    //         } else {
    //             alert("Unique number tidak boleh kosong.");
    //         }
    //     });
    // });
    </script>

</body>

</html>