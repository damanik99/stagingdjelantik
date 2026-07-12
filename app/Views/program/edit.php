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
    <title>UPDATE PROGRAM</title>


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

    <style>
    required {
        color: red;
    }
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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/client">Index</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->
                    <!-- ROW-1 OPEN -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form action='<?=base_url();?>/program/saveedit/<?php echo $data['program_id'];?>'
                                    method="post" enctype="multipart/form-data">

                                    <!-- header 1 -->
                                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                                        <h3 class="mb-0 card-title">PROGRAM UPDATE</h3>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Client <required>*</required></label>
                                                    <select class="form-control select2-show-search" name="client">
                                                        <option value="">-- Select One --</option>
                                                        <?php foreach($client as $row): ?>
                                                        <option value="<?php echo $row['client_id'];?>"
                                                            <?php if($row['company'] == $data['client_name']) echo " selected" ?>>
                                                            <?php echo $row['company'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Contact Name</label>
                                                    <input class="form-control" type="text" name="contact_name"
                                                        value="<?php echo $data['contact_name'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Contact Email</label>
                                                    <?php 
                                                    if ($data['contact_email'] == NULL)
                                                    {?>
                                                    <input class="form-control" type="text" name="contact_email"
                                                        value="-">
                                                    <?php
                                                    }
                                                    else
                                                    {?>
                                                    <input class="form-control" type="text" name="contact_email"
                                                        value="<?php echo $data['contact_email'];?>">
                                                    <?php
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Contact Phone</label>

                                                    <?php 
                                                       if ($data['contact_phone'] == NULL)
                                                       {
                                                    ?>
                                                    <input class="form-control" type="text" name="contact_phone"
                                                        value="-">
                                                    <?php    
                                                       }
                                                       else
                                                       {
                                                    ?>
                                                    <input class="form-control" type="text" name="contact_phone"
                                                        value="<?php echo $data['contact_phone'];?>">
                                                    <?php    
                                                       }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Code <required>*</required></label>
                                                    <input class="form-control" type="text" name="code"
                                                        value="<?php echo $data['code'];?>" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Name <required>*</required></label>
                                                    <input class="form-control" type="text" name="name_program"
                                                        value="<?php echo $data['program'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Start Date</label>
                                                    <div class="wd-200 mg-b-30">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                </div>
                                                            </div><input class="form-control fc-datepicker"
                                                                placeholder="MM/DD/YYYY" type="text" id="start_date"
                                                                name="start_date"
                                                                value="<?php echo $data['start_date'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Finish Date</label>
                                                    <div class="wd-200 mg-b-30">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                </div>
                                                            </div><input class="form-control fc-datepicker"
                                                                placeholder="MM/DD/YYYY" type="text" id="end_date"
                                                                name="finish_date"
                                                                value="<?php echo $data['end_date'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Budget</label>
                                                    <input class="form-control" type="text" name="budget"
                                                        value="<?php echo $data['budget'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Handling Charge <required>*</required>
                                                    </label>
                                                    <select class="form-control select2-show-search" id="itemtype"
                                                        name="handling_charge_id">
                                                        <option value="<?php echo $data['handling_charge_id'];?>"
                                                            id="handling_charge_id"><?php echo $data['handling'];?>
                                                        </option>
                                                        <?php foreach($handling as $row): ?>
                                                        <option value="<?php echo $row['handling_charge_id'];?>"
                                                            id="handling_charge_id">
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Status <required>*</required>
                                                    </label>
                                                    <select class="form-control select2-show-search" id="status_id"
                                                        name="status_id">
                                                        <?php foreach($status as $row): ?>
                                                        <option value="<?php echo $row['status_id'];?>" id="status_id"
                                                            <?php if($row['name'] == $data['status_name']) echo " selected" ?>>
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Header 2 -->
                                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                                        <h3 class="mb-0 card-title">TRACKER CONFIGURATION</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Time Start</label>
                                                    <input class="form-control" type="text" name="time_start"
                                                        value="<?php echo $data['time_start'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Time Stop </label>
                                                    <input class="form-control" type="text" name="time_stop"
                                                        value="<?php echo $data['time_stop'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"> Frequency (Minute)</label>
                                                    <input class="form-control" type="text" name="frequency"
                                                        value="<?php echo $data['frequency'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['include_saturday'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="include_saturday" value="1" checked>
                                                        <span class="custom-control-label">Include Saturday</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="include_saturday" value="1">
                                                        <span class="custom-control-label">Include Saturday</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['include_sunday'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="include_sunday" value="1" checked>
                                                        <span class="custom-control-label">Include Sunday</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="include_sunday" value="1">
                                                        <span class="custom-control-label">Include Sunday</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Header 5 -->
                                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                                        <h3 class="mb-0 card-title">PRM PROGRAM CONDITION</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- TRACKER CONFIGURATION 1 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_attendance'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_attendance" value="1" checked>
                                                        <span class="custom-control-label">Module Attendance</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_attendance" value="1">
                                                        <span class="custom-control-label">Module Attendance</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_redemption'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_redemption" value="1" checked>
                                                        <span class="custom-control-label">Modul Redemption</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_redemption" value="1">
                                                        <span class="custom-control-label">Modul Redemption</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- TRACKER CONFIGURATION 1 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_activity'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_activity" value="1" checked>
                                                        <span class="custom-control-label">Module Activity</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_activity" value="1">
                                                        <span class="custom-control-label">Module Activity</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_distribution'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_distribution" value="1" checked>
                                                        <span class="custom-control-label">Module Distribution</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_distribution" value="1">
                                                        <span class="custom-control-label">Module Distribution</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- TRACKER CONFIGURATION 3 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_display'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_display" value="1" checked>
                                                        <span class="custom-control-label">Module Display</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_display" value="1">
                                                        <span class="custom-control-label">Module Display</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_selling'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_selling" value="1" checked>
                                                        <span class="custom-control-label">Module Selling</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_selling" value="1">
                                                        <span class="custom-control-label">Module Selling</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- TRACKER CONFIGURATION 4 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_salesclaim'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_salesclaim" value="1" checked>
                                                        <span class="custom-control-label">Module Sales Claim</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_salesclaim" value="1">
                                                        <span class="custom-control-label">Module Sales Claim</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_training'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_training" value="1" checked>
                                                        <span class="custom-control-label">Module Training</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_training" value="1">
                                                        <span class="custom-control-label">Module Training</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- TRACKER CONFIGURATION 5 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <?php 
                                                    if($data['module_inbound'] == "1") 
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_inbound" value="1" checked>
                                                        <span class="custom-control-label">Module Inbound</span>
                                                        <?php 
                                                    }else
                                                    { ?>
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="module_inbound" value="1">
                                                        <span class="custom-control-label">Module Inbound</span>
                                                        <?php 
                                                    } ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions text-center mt-5">
                                            <a class="btn btn-warning mr-1" href="<?=base_url()?>/program"
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

    <!-- TOASTR JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- INTERNAL  FILE UPLOADES JS -->
    <script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/fileupload.js"></script>
    <script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/file-upload.js"></script>

    <script type="text/javascript">
    <?php if (session()->getFlashdata('success')) {?>
    toastr.success("<?php echo session()->getFlashdata('success'); ?>");
    <?php }  ?>
    </script>

    <script>
    $(document).ready(function() {

        //document.getElementById("hidepromo").style.display = "none";

        $('#itemtype').change(function() {

            var type_id = $(this).val();
            console.log(type_id);

            //AJAX request 
            $.ajax({
                url: '<?php echo base_url('Item/itemsubtype');?>',
                method: 'post',
                data: {
                    type_id: type_id
                },
                dataType: 'json',
                success: function(response) {
                    response.forEach(function(responses) {
                        console.log(responses);

                    });
                    // output = "Your order for the following items has been placed: ";
                    document.getElementById('text').innerHTML = response.text;
                }
            });
        });
    });

    $(function() {
        $("#start_date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $("#end_date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

    });
    </script>

</body>

</html>