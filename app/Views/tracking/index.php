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

    <!-- INTERNAL  DATE PICKER CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

    <!-- INTERNAL  DATEPICKER CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />

    <!-- SIDEBAR CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="<?= base_url() ?>/teamplate/assets/colors/color1.css" />

    <!-- INTERNAL SELECT2 CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- INTERNAL  DATE PICKER CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

    <!-- INTERNAL  DATA TABLE CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <!-- TOASTR CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- INTERNAL  FILE UPLODE CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet"
        type="text/css" />

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

    <!-- INTERNAL  DATA TABLE CSS-->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

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
                            <h1 class="page-title">Maps <?=$title?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Table</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                            </ol>
                        </div>
                        <!-- <div class="ml-auto pageheader-btn">
                            <a href="<?=base_url()?>/training/add" class="btn btn-primary btn-icon text-white mr-2">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> Add Training
                            </a>
                            <a href="<?=base_url()?>/training/upload" class="btn btn-success btn-icon text-white mr-2">
                                <span>
                                    <i class="fe fe-upload-cloud"></i>
                                </span>Upload
                            </a>
                        </div> -->
                    </div>
                    <!-- PAGE-HEADER END -->
                    <!-- ROW-4 -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary br-tr-3 br-tl-3">
                                    <h3 class="card-title">MAPS TRACKING</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">Field Team Name</label>
                                                <select class="form-control select2-show-search" name="username"
                                                    id="username">
                                                    <option value=''>-- Select One --</option>
                                                    <?php foreach($username as $usernames): ?>
                                                    <option value="<?php echo $usernames['username'];?>">
                                                        <?php echo $usernames['username'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                <?php  ?>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">Date</label>
                                                <div class="wd-200 mg-b-30">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control" name="date" id="start_date"
                                                            placeholder="YYYY-MM-DD" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label"><br></label>
                                                <button type="button" name="submit" value="save" class="btn btn-primary"
                                                    id="show_route">
                                                    <i class="fa fa-save"> </i> Show Route
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="table-responsive">
                                        <div id="map" style="width: 600px; height: 400px;"></div>
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

    <!-- CUSTOM JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>
    <!-- INTERNAL  DATA TABLE JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/datatable.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>

    <!-- INTERNAL DATEPICKER JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

    <!--INTERNAL  FORMELEMENTS JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

    <!-- INTERNAL DATEPICKER JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <script>
    $(function() {
        $("#start_date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $("#finish_date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

    });

    var map = L.map('map').setView([-6.17552, 106.81227], 14);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    $("#show_route").click(function() {
        getRoute();
    });

    function getRoute() {
        var username = jQuery("#username").val();
        var date = jQuery("#start_date").val();

        if (username != "" && date != "") {
            var uri = '<?php echo site_url('trackings/showRoute');?>';

            jQuery.ajax({
                type: 'POST',
                async: false,
                dataType: "json",
                url: uri,
                data: {
                    username: username,
                    date: date
                },
                success: function(result) {
                    // displayMap();
                    // console.log(result);
                    // var marker = L.marker([-6.17552, 106.81227]).addTo(map);
                    // L.Routing.control({
                    //     waypoints: [
                    //         L.latLng(-6.17552, 106.81227),
                    //         L.latLng(-6.17533, 106.81350),
                    //         L.latLng(-6.17534, 106.81360)
                    //     ]
                    // }).addTo(map);
                    calculateAndDisplayRoute(result.first, result.last, result.wayspoint);
                    // console.log(result);
                }
            });
        } else
            alert("Username dan Date tidak boleh kosong");
    }

    function calculateAndDisplayRoute(first, last, waypts) {
        // alert(start);

        var waypoints = waypts;
        var arr = [];
        // console.log("test :", waypts);
        // return;
        // console.log("test 1 :", waypoints.location);
        // Loop untuk menghitung rute antara titik-titik waypoint
        for (var i = 0; i < waypoints.length; i++) {
            var wypts = waypoints[i];
            var lat = wypts.lat;
            var long = wypts.long;
            var loc = wypts.loc;
            // console.log(wypts);
            // var str = startPoint.join(', ');
            console.log('==', lat, long);

            arr.push(L.latLng(lat, long));

            // arr=[startpoint,startpoint,startpoint,startpoint]

            // Buat instance dari L.Routing.control untuk setiap pasangan titik waypoint
            // L.Routing.control({
            //     waypoints: arr,
            //     show: false,
            //     addWaypoints: false,
            //     routeWhileDragging: true
            // }).addTo(map);
        }
        if (arr == "") {
            alert("Data Kosong");
            location.reload();
        }
        console.log('==>', arr);

        L.Routing.control({
            waypoints: arr,
            show: false,
            addWaypoints: false,
            draggableWaypoints: false,
            fitSelectedRoutes: true,
            showAlternatives: false
        }).on('routeselected', function(e) {
            var route = e.arr;
            arr.coordinates.forEach(function(coordinate) {
                L.marker(coordinate).bindPopup('Alamat routing atau informasi lainnya').addTo(map);
            });
        }).addTo(map);

        // for (var q = 0; q < waypoints.length; q++) {
        //     var wyptsx = waypoints[q];
        //     var latx = wyptsx.lat;
        //     var longx = wyptsx.long;
        //     var locx = wyptsx.loc;

        //     console.log(latx, longx, locx);
        //     L.marker(latx, longx).bindPopup(locx).addTo(map);
        // }

        // var marker = L.marker([-6.17552, 106.81227]).addTo(map);
        // L.Routing.control({
        //     waypoints: [start, end, waypts]
        // }).addTo(map);

        // L.Routing.control({
        //     waypoints: [
        //         L.latLng(-6.17552, 106.81227),
        //         L.latLng(-6.17533, 106.81350),
        //         L.latLng(-6.17534, 106.81360)
        //     ]
        // }).addTo(map);
    }
    </script>
</body>

</html>