<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->

<!-- INTERNAL  FILE UPLODE CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet"
    type="text/css" />

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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/redemption">Index</a></li>
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
                        <h3 class="mb-0 card-title">REDEMPTION UPDATE</h3>
                    </div>
                    <form action='<?=base_url();?>/redemption/saveedit/<?php echo $views['redemption_id'];?>'
                        method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">DELIVERY ORDER <required>*</required>
                                        </label>
                                        <input type="text" class="form-control" name="delivery_order"
                                            value="<?php echo $views['noref'];?>" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">STATUS <required>*</required>
                                        </label>
                                        <select class="form-control select2-show-search" id="status" name="status">
                                            </option>
                                            <?php foreach($status as $key => $row){ ?>
                                            <p><?php //echo var_dump($row);exit; ?></p>
                                            <option value=" <?php echo $key;?>"
                                                <?php if($row == $views['status_name']) echo " selected" ?>
                                                id="status_id">
                                                <?php echo $row;?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">NOTE <required>*</required>
                                        </label>
                                        <textarea class="form-control" name="note1" cols="20"
                                            rows="5"><?php echo $views['note1'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-center mt-5">
                                <a class="btn btn-warning mr-1" href="<?=base_url()?>/redemption" role="button"><i
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
<script>
<?php if (session()->getFlashdata('success')) {?>
toastr.success("<?php echo session()->getFlashdata('success'); ?>");
<?php }  ?>
</script>