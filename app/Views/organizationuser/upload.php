<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<style>
    .btn-defaultsx {
        color: #242e4c;
        background: #e9e9e9;
        border-color: #ebedfc;
        box-shadow: none;
    }

    .page-headersxd {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        margin: 0.5rem 0rem;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 0;
        border-radius: 7px;
        position: relative;
        min-height: 50px;
    }
</style>

<!-- CSS END -->

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->
<!--app-content open-->
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/OrganizationUser/index">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Upload</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <?= session()->getFlashdata('error'); ?>
                    <form action='<?= base_url(); ?>organizationuser/uploadOrganizationUser' method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select File</label>
                                    <input type="file" name="fileexcel">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <a href="<?= base_url() ?>custom/downloadTemplate/template_userorganization.csv"
                                        class="btn btn-outline-secondary">
                                        Download template</a>
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

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<script>
    <?php if (session()->getFlashdata('error')) { ?>

        toastr.error("<?php echo session()->getFlashdata('error'); ?>");

    <?php }  ?>
</script>