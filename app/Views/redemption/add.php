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

    <!-- SIDEBAR CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- FORN WIZARD CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard_theme_arrows.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard_theme_circles.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/plugins/formwizard/smart_wizard_theme_dots.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/plugins/forn-wizard/css/demo.css" rel="stylesheet">

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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/redemption">Index</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Redemption</li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->

                    <!-- ROW-1 OPEN -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary br-tr-3 br-tl-3">
                                    <h3 class="mb-0 card-title"><?=$title?></h3>
                                </div>
                                <form action='<?=base_url();?>/redemption/save' method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Tracking Number <required>*</required>
                                                    </label>
                                                    <input class="form-control" type="text" name="tracking_number"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Redemption Code <required>*</required>
                                                    </label>
                                                    <input class="form-control" type="text" name="redemption_code"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Member Code <required>*</required></label>
                                                    <select class="form-control select2-show-search"
                                                        name="redemption_code" id="code_id" required="">
                                                        <option value="">
                                                        </option>
                                                        <?php foreach($mcode as $mcodes): ?>
                                                        <option value="<?php echo $mcodes['code'];?>">
                                                            <?php echo $mcodes['code'];?>
                                                        </option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Member Name <required>*</required></label>
                                                    <input class="form-control" type="text" name="member_name"
                                                        id="membername" required="">
                                                    <input type="hidden" name="member_id" id="member_id" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Point Balance</label>
                                                    <input class="form-control" type="text" name="point_balance"
                                                        id="pointbalance" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Point Redeem</label>
                                                    <input class="form-control" type="text" name="point_redeem"
                                                        id="points">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Quantity Redeem <required>*</required>
                                                    </label>
                                                    <input class="form-control" type="text" name="quantity_redeem"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Note</label>
                                                    <textarea class="form-control" rows="3" name="note"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions text-center mt-5">
                                            <a class="btn btn-warning mr-1" href="<?=base_url()?>/redemption"
                                                role="button"><i class="fa fa-window-close"></i> Cancel</a>
                                            <button type="submit" name="submit" value="save" class="btn btn-primary">
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

    <!-- JQUERY JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js"></script>

    <!-- TOASTR JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script type="text/javascript">
    <?php if (session()->getFlashdata('success')) {?>

    toastr.success("<?php echo session()->getFlashdata('success'); ?>");

    <?php }  ?>
    </script>

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

    <!-- CUSTOM SCROLLBAR JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- SIDEBAR JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js"></script>

    <!-- CUSTOM JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>

    <!--INTERNAL  FORMELEMENTS JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

    <script>
    $(document).ready(function() {

        $("#code_id").change(function() {
            value = $(this).val();
            var uri = "<?php echo site_url('redemption/get_member');?>"

            jQuery.ajax({
                type: 'POST',
                async: false,
                dataType: "json",
                url: uri,
                data: {
                    value: value
                },
                beforeSend: function() {
                    $("#global-loader").show();
                },
                complete: function() {
                    $("#global-loader").hide();
                },
                // type: "Get",
                success: function(result) {
                    $("#member_id").val(result.member_id);
                    $("#membername").val(result.first_name);
                    $("#pointbalance").val(result.point_balance);
                    $("#points").val(result.point_redeem);
                    $("#global-loader").hide();
                }
            });
        });

        $('.collapse').collapse({
            toggle: false
        });
    });

    jQuery(document).ready(function() {
        jQuery('#code_id').click(function() {
            codeid();
        });
    });

    // function subtype() {
    //     var sub_item_type_id = $("#code_id").val();
    //     // alert(sub_item_type_id);
    //     var uri = '<?php //echo Yii::app()->createAbsoluteUrl("Datalist/ItemSub"); ?>';
    //     jQuery.ajax({
    //         type: 'POST',
    //         async: false,
    //         dataType: "json",
    //         url: uri,
    //         data: {
    //             sub_item_type_id
    //         },
    //         // type: "Get",
    //         success: function(result) {
    //             $("#item_sub_type_id").val(result);
    //         }
    //     });
    // }
    </script>

</body>

</html>