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
    <title>PROFILE</title>

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

    <!-- INTERNAL SELECT2 CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="<?= base_url() ?>/teamplate/assets/colors/color1.css" />

    <!-- INTERNAL  FILE UPLODE CSS -->
    <link href="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet"
        type="text/css" />

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
                            <h1 class="page-title">My Profile</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                                <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->

                    <!-- ROW-1 OPEN -->
                    <form action='<?=base_url();?>/user/editprofile/<?php echo $users['users_id'];?>'
                        enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="userprofile">
                                                <div class="userpic  brround"> <img
                                                        src="<?= !empty($users['picture']) ? $users['picture'] : base_url('/upload/users/no-image.png') ?>"
                                                        alt="" class="userpicimg"> </div>
                                                <h3 class="username text-dark mb-2"><?=$users['first_name'] ?>
                                                </h3>
                                                <p class="mb-1 text-muted">
                                                    <?= !empty($users['title']) ? $users['title'] : 'NULL'?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Edit Picture</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>PICTURE</label>
                                                    <input type="file" name="picture" class="dropify"
                                                        data-default-file="<?=base_url()?>/upload/users/no-image.png"
                                                        data-height="89" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xl-8 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">My Profile</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control"
                                                        value="<?=$users['username'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" name="first_name"
                                                        value="<?=$users['first_name'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="form-label">Password <h6
                                                            class="mt-2 mb-0 text-danger">
                                                            The old password data cannot be displayed.</h6>
                                                    </label>
                                                    <input type="password" class="form-control" name="password"
                                                        id="password">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <br><br><br>
                                                    &nbsp;<input type='checkbox' class='form-check-input' id='show'
                                                        onclick="toggleVisibility()">
                                                    <label>Show password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" name="email"
                                                value="<?=$users['email'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="number" class="form-control" name="phone"
                                                value="<?=$users['phone']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Leader Name</label>
                                            <input type="text" class="form-control" name="leader_name"
                                                value="<?=!empty($users['leader_name']) ? $users['leader_name'] : 'NULL' ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="city"
                                                value="<?=!empty($users['city']) ? $users['city'] : 'NULL' ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Region</label>
                                            <input type="text" class="form-control" name="region"
                                                value="<?=!empty($users['region']) ? $users['region'] : 'NULL' ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="title"
                                                value="<?=$users['title'] ?>">
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <!-- <a href="#" type="submit" name="save" class="btn btn-success mt-1">Save</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-1 CLOSED -->
                    </form>
                </div>
            </div>
            <!-- CONTAINER END -->
        </div>

        <!-- FOOTER -->
        <?= $this->include('layout/footer') ?>
        <!-- FOOTER END -->

    </div>

    <!-- BACK-TO-TOP -->
    <a href=" #top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- JQUERY JS -->
    <script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js">
    </script>

    <!-- BOOTSTRAP JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/js/bootstrap.bundle.min.js">
    </script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/js/popper.min.js">
    </script>

    <!-- SPARKLINE JS-->
    <script src="<?= base_url() ?>/teamplate/assets/js/jquery.sparkline.min.js">
    </script>

    <!-- CHART-CIRCLE JS-->
    <script src="<?= base_url() ?>/teamplate/assets/js/circle-progress.min.js">
    </script>

    <!-- RATING STAR JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/rating/jquery.rating-stars.js">
    </script>

    <!-- EVA-ICONS JS -->
    <script src="<?= base_url() ?>/teamplate/assets/iconfonts/eva.min.js"></script>

    <!-- INPUT MASK JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.mask.min.js">
    </script>

    <!-- SIDE-MENU JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu.js">
    </script>

    <!-- PERFECT SCROLL BAR js-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.min.js">
    </script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu-scroll.js">
    </script>

    <!-- CUSTOM SCROLL BAR JS-->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js">
    </script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js">
    </script>
    <script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

    <!-- SIDEBAR JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js">
    </script>

    <!-- CUSTOM JS-->
    <script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>

    <!-- INTERNAL  FILE UPLOADES JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/fileupload.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/file-upload.js"></script>

    <script>
    function toggleVisibility() {
        var getPasword = document.getElementById("password");
        if (getPasword.type === "password") {
            getPasword.type = "text";
        } else {
            getPasword.type = "password";
        }
    }
    </script>
</body>

</html>