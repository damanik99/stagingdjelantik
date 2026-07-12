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

<?php /** @var array<string, mixed> $row */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Companytype">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create New</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                        <div class="card-body">
                            <form id="companyTypeForm">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Type Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="type_name" class="form-control" placeholder="Example : Supplier"
                                                value="<?= $row['type_name'] ?>" maxlength="100">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Status
                                            </label>
                                            <select name="status" class="form-control">
                                                <option value="active" <?= $row['status'] == 'active' ? 'selected' : ''; ?>>
                                                    Active
                                                </option>
                                                <option value="inactive" <?= $row['status'] == 'inactive' ? 'selected' : ''; ?>>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Description
                                            </label>
                                            <textarea name="description" rows="4" class="form-control" placeholder="Description"><?= $row['description'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions text-center mt-5">
                                    <a href="<?= base_url() ?>/Companytype"
                                        class="btn btn-warning">
                                        <i class="fa fa-window-close"></i>
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-teal">
                                        <i class="fa fa-save mr-2"></i>
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
            <!-- COL END -->
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

<!-- INTERNAL  FILE UPLOADES JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/fileupload.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/file-upload.js"></script>

<!-- INTERNAL ACCORDION JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
<?php if (session()->getFlashdata('success')) {?>
toastr.success("<?php echo session()->getFlashdata('success'); ?>");
<?php }  ?>
</script>

<script>
$('#companyTypeForm').submit(function(e) {

    e.preventDefault();

    $.ajax({

        url: "<?= base_url('/companytype/update/'.$row['type_id']) ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",

        beforeSend: function() {

            Swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

        },

        success: function(response) {

            Swal.close();

            if (response.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {

                    window.location.href =
                        "<?= base_url('/Companytype') ?>";

                });

            } else {

                let msg = '';

                $.each(response.message, function(key, value) {
                    msg += value + '<br>';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: msg
                });

            }

        },

        error: function(xhr) {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Internal Server Error'
            });

            console.log(xhr.responseText);

        }

    });

});
</script>
