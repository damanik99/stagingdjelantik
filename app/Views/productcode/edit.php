<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/productcode">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="mb-0 card-title">PRODUCT CODE UPDATE</h3>
                    </div>
                    <form action='<?=base_url();?>/ProductCode/edit/<?php echo $views[0]['product_code_id'];?>'
                        method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Item Name <required>*</required>
                                        </label>
                                        <select class="form-control select2-show-search" name="programitem_id">
                                            <option value="">--Select One--</option>
                                            <?php foreach($item as $row): ?>
                                            <option value="<?php echo $row['program_item_id'];?>"
                                                <?php if($row['namaitem'] == $views[0]['item_name']) echo " selected" ?>
                                                id="program_item_id">
                                                <?php echo $row['namaitem'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">CODE <required>*</required>
                                        </label>
                                        <input type="text" class="form-control" name="code"
                                            value="<?php echo $views[0]['code'];?>" required=>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="active" value="1"
                                                <?php echo $views[0]['status'] == 1 ? 'checked' : ''; ?>>
                                            <span class="custom-control-label">Active</span>&nbsp;
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-actions text-center mt-5">
                                <a class="btn btn-warning mr-1" href="<?=base_url()?>/ProductCode" role="button"><i
                                        class="fa fa-window-close"></i> Cancel</a>
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
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!--INTERNAL  FORMELEMENTS JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>