<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->

<!-- INTERNAL  FILE UPLODE CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet"
    type="text/css" />

<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

<!-- INTERNAL  DATE PICKER CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

<?php /** @var array $data
 * @var array $orgz
 * */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/OrganizationUser">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Users Organization</li>
                </ol>
                <h1 class="page-title">Edit Users Organization</h1>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <form id="organizationUserForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Organization -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Organization <span class="text-danger">*</span>
                                        </label>
                                        <select name="organization_program_id" class="form-control select2-show-search"
                                            required>
                                            <option value="">Select Organization</option>
                                            <?php foreach ($orgz as $row) : ?>
                                                <option value="<?= $row['organization_program_id']; ?>"
                                                    <?= $row['organization_program_id'] == $data['organization_program_id'] ? 'selected' : ''; ?>>
                                                    <?= esc($row['organization_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden"
                                    name="organization_user_id"
                                    value="<?= $data['organization_user_id'] ?>">

                                <!-- Username -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Username <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" name="username" class="form-control"
                                            placeholder="Enter username" value="<?= $data['username'] ?>" required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Password <span class="text-danger">*</span>
                                        </label>

                                        <input type="password" name="password"
                                            class="form-control" placeholder="Leave blank to keep current password">
                                    </div>
                                </div>

                                <!-- Fullname -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Full Name <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" name="fullname" class="form-control"
                                            placeholder="Enter full name" value="<?= $data['fullname'] ?>" required>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Phone
                                        </label>

                                        <input type="text" name="phone"
                                            class="form-control" placeholder="Enter phone number" value="<?= $data['phone'] ?>">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Email
                                        </label>

                                        <input type="email" name="email"
                                            class="form-control" placeholder="Enter email" value="<?= $data['email'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-12 mt-12">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control"><?= $data['address'] ?></textarea>
                                </div>

                                <!-- Picture -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Picture
                                        </label>

                                        <?php if (!empty($data['picture'])) : ?>

                                            <div class="mb-3">
                                                <img src="<?= base_url('upload/image/users/' . $data['picture']) ?>"
                                                    class="img-thumbnail"
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            </div>

                                        <?php else : ?>

                                            <div class="mb-3">
                                                <span class="text-muted">
                                                    No picture uploaded
                                                </span>
                                            </div>

                                        <?php endif; ?>

                                        <input type="file"
                                            name="picture"
                                            class="form-control"
                                            accept="image/jpeg,image/png,image/jpg">

                                        <small class="text-muted">
                                            Leave empty if you don't want to change the picture.
                                        </small>
                                    </div>
                                </div>

                            </div>

                            <div class="text-center mt-5 text-end">
                                <a href="<?= base_url('/OrganizationUser') ?>" class="btn btn-default-light">
                                    <i class="fa fa-window-close mr-2"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-teal">
                                    <i class="fa fa-save"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

<!-- INTERNAL  FILE UPLOADES JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/fileupload.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/file-upload.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    <?php if (session()->getFlashdata('success')) { ?>
        toastr.success("<?php echo session()->getFlashdata('success'); ?>");
    <?php }  ?>
</script>

<script>
    $('#organizationUserForm').submit(function(e) {

        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: "<?= base_url('organizationuser/saveedit') ?>",
            type: "POST",
            data: formData,
            dataType: "json",

            processData: false,
            contentType: false,

            beforeSend: function() {
                Swal.fire({
                    title: 'Processing...',
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

                        window.location.href = response.redirect;

                    });
                } else {
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
            error: function(xhr) {

                Swal.close();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem'
                });

                console.log(xhr.responseText);

            }
        });

    });
</script>