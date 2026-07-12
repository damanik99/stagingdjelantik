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

<?php /** @var array $companyTypes 
 * @var array $status
 * */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Company">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
                <h1 class="page-title">Create New Company</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/CompanyType/create" class="btn btn-radius btn-success-light btn-icon mr-2">
                    <i class="fa fa-plus mr-2"></i>Create Company Type
                </a>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <form id="companyForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Company Type *</label>
                                    <select name="company_type_id"
                                        class="form-control select2"
                                        required>
                                        <option value="">Pilih</option>
                                        <?php foreach($companyTypes as $row): ?>
                                        <option value="<?= $row['type_id']; ?>">
                                            <?= $row['type_name']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Company Name *</label>
                                    <input type="text"
                                        name="company_name"
                                        class="form-control"
                                        required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="form-label">PIC Name</label>
                                    <input type="text"
                                        name="pic_name"
                                        class="form-control">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text"
                                        name="phone"
                                        class="form-control">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                        name="email"
                                        class="form-control">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status_id"
                                        class="form-control select2-show-search">
                                        <option value="">Choose Status</option>
                                        <?php foreach ($status as $row) : ?>
                                            <option value="<?= $row['status_id']; ?>">
                                                <?= $row['status_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Address</label>
                                    <textarea
                                        name="address"
                                        class="form-control"></textarea>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Latitude</label>
                                    <input type="text"
                                        name="latitude"
                                        class="form-control">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Longitude</label>
                                    <input type="text"
                                        name="longitude"
                                        class="form-control">
                                </div>

                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('/Company') ?>" class="btn btn-default-light">
                                    <i class="fa fa-window-close mr-2"></i>
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-teal">
                                    <i class="fa fa-save"></i>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
<?php if (session()->getFlashdata('success')) {?>
toastr.success("<?php echo session()->getFlashdata('success'); ?>");
<?php }  ?>
</script>

<script>
    $('#companyForm').submit(function(e){

        e.preventDefault();

        $.ajax({
            url: "<?= base_url('/company/store') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function(){

                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

            },
            success: function(response){

                Swal.close();
                      
                if(response.status){

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {

                        window.location.href =
                            "<?= base_url('/company') ?>";

                    });

                }else{

                    let msg = '';

                    if (response.errors) {

                        $.each(response.errors, function(key, val) {
                            msg += val + '<br>';
                        });

                    } else {

                        msg = response.message;

                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation',
                        html: msg
                    });
                }

            },
            error: function(){

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem'
                });

            }
        });

    });
</script>