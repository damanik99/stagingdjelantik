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

<?php /** 
 * @var string $title 
 * @var array $company 
 * */ ?>

<div class="app-content">
    <div class="side-app">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>/StorageContainer">Storage Container</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Create
                    </li>
                </ol>
                <h1 class="page-title">Create Storage Container</h1>
            </div>
        </div>
        <!-- PAGE HEADER END -->

        <div class="row">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <form id="vehicleForm" action="<?= base_url('/StorageContainer/create'); ?>" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Ware House <span class="text-danger">*</span></label>
                                        <select name="company_program_id" class="form-control select2-show-search">
                                            <option value="">-- Select Ware House --</option>
                                            <?php //foreach ($company as $row) : ?>
                                                <option value="<?//= $row['company_program_id']; ?>">
                                                    <?//= $row['company_name']; ?>
                                                </option>
                                            <?php //endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('StorageContainer') ?>" class="btn btn-default-light">
                                    <i class="fa fa-window-close"></i>
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-teal">
                                    <i class="fa fa-save"></i>
                                    Save
                                </button>                                
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
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

<!-- INTERNAL  FILE UPLOADES JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/fileupload.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/file-upload.js"></script>

<!-- INTERNAL ACCORDION JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    $('#vehicleForm').submit(function(e) {

        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,

            beforeSend: function() {
                Swal.fire({
                    title: 'Please Wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },

            success: function(response) {

                if (response.status == true) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        window.location.href = response.redirect;
                    });

                } else {

                    let errorMsg = '';

                    $.each(response.errors, function(key, value) {
                        errorMsg += value + '<br>';
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMsg
                    });
                }
            },

            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Internal Server Error'
                });
            }
        });

    });

});
</script>
