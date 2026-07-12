<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />
<!-- CSS END -->

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->

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
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="card-title">UPLOAD</h3>
                    </div>
                    <?= session()->getFlashdata('message'); ?>
                    <form action='<?=base_url();?>/Pointaccumulation/upload' method="post"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select File</label>
                                    <input type="file" name="fileexcel">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <a href="<?=base_url()?>/custom/downloadTemplate/template_pointAccumulation.csv"
                                        class="btn btn-outline-secondary">
                                        Download template</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="replaceexist"
                                            value="replaceexist">
                                        <span class="custom-control-label">REPLACE EXISTING DATA</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="submit" value="save" class="btn btn-primary">
                                        <i class="fa fa-save"> </i> Upload
                                    </button>
                                </div>
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