<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css"
    rel="stylesheet" />
<!-- CSS END -->
<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->
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
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="card-title">REPORT</h3>
                    </div>
                    <form action='<?=base_url();?>/redemption/report' method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Start Date <required>*</required></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="start_date" id="start_date"
                                                placeholder="YYYY-MM-DD" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">End Date <required>*</required></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="finish_date" id="finish_date"
                                                placeholder="YYYY-MM-DD" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-center mt-5">
                                <a class="btn btn-warning mr-1" href="<?=base_url()?>/selling" role="button"><i
                                        class="fa fa-window-close"></i> Cancel</a>
                                <button type="submit" name="submit" value="save" class="btn btn-primary"><i
                                        class="fa fa-save"></i> Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ROW-4 CLOSED-->
    </div>
</div>
<!-- CONTAINER END -->
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

<script>
<?php if (session()->getFlashdata('error')) {?>
toastr.error("<?php echo session()->getFlashdata('error'); ?>");
<?php }  ?>

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
</script>