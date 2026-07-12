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

<?php /** @var array<string, mixed> $companyprograms, 
 * @var array<string, mixed> $companyTypes 
 * @var array<string, mixed> $statuses */ 
?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Company">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-blue br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <form id="companyForm"
                            action="<?= base_url(); ?>/company/edit/<?= $companyprograms['company_program_id']; ?>"
                            method="post">
                            <?= csrf_field(); ?>

                            <input type="hidden"
                                name="company_id"
                                value="<?= $companyprograms['company_id']; ?>">

                            <div class="row">

                                <!-- Company Type -->
                                <div class="col-md-6 mb-3">

                                    <label>
                                        Company Type
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        name="company_type_id" class="form-control select2" required>
                                        <option value="">Pilih</option>
                                         <?php foreach($companyTypes as $row): ?>
                                            <option value="<?= $row['type_id'] ?>"
                                                <?= $row['type_id'] == $companyprograms['type_id'] ? 'selected' : ''; ?>>
                                                <?= esc($row['type_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                                <!-- Company Name -->
                                <div class="col-md-6 mb-3">
                                    <label>
                                        Company Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="company_name" class="form-control" value="<?= esc($companyprograms['company_name']); ?>"
                                        required>
                                </div>

                                <!-- PIC -->
                                <div class="col-md-6 mb-3">

                                    <label>
                                        PIC Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="pic_name"
                                        class="form-control"
                                        value="<?= esc($companyprograms['pic_name']); ?>"
                                        required>

                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?= esc($companyprograms['phone']); ?>">
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= esc($companyprograms['email']); ?>">
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select
                                        name="status_id" class="form-control select2" required>
                                        <option value="">Pilih</option>
                                         <?php foreach($statuses as $row): ?>
                                            <option value="<?= $row['status_id'] ?>"
                                                <?= $row['status_id'] == $companyprograms['status_id'] ? 'selected' : ''; ?>>
                                                <?= esc($row['status_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    
                                </div>

                                <!-- Address -->
                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <textarea name="address" rows="3" class="form-control"><?= esc($companyprograms['address']); ?></textarea>
                                </div>

                                <!-- Latitude -->
                                <div class="col-md-6 mb-3">
                                    <label>Latitude</label>
                                    <input type="text" name="latitude" class="form-control" value="<?= esc($companyprograms['latitude']); ?>">
                                </div>

                                <!-- Longitude -->
                                <div class="col-md-6 mb-3">
                                    <label>Longitude</label>
                                    <input type="text" name="longitude" class="form-control" value="<?= esc($companyprograms['longitude']); ?>">
                                </div>

                                
                            </div>
                            <!-- Button -->
                                <div class="text-center mt-5">
                                    <a href="<?= base_url('company'); ?>" class="btn btn-warning">
                                        <i class="fa fa-arrow-left"></i> Cancel
                                    </a>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save
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
    $('#companyForm').on('submit', function(e){

    e.preventDefault();

    Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({

        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function(response, textStatus, xhr){

            Swal.close();
            console.log('Status:', xhr.status);

            if(response.status){

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                });

            }else{

                let errors = '';

                if(response.errors){

                    $.each(response.errors, function(key, value){
                        errors += value + '<br>';
                    });

                } else {
                    console.log('Message:', response.message);
                    errors = response.message;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: response.message
                });

                console.log(response.errors);

            }

        },

        error: function(xhr){

            Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem'
                });

        }

    });

});
</script>
