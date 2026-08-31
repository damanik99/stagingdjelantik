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

<?php /** @var array $organizationtype 
 * @var array $provinces
 * @var string $code
 * @var array $dataOrgz
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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>Organization">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
                <h1 class="page-title">Create Edit Organization</h1>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <form id="organizationForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Organization Code </label>
                                        <input type="text" name="code" class="form-control"
                                            value="<?= $dataOrgz['organization_code'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Organization Type <span class="text-danger">*</span></label>
                                        <input type="text" name="organization_type_id" class="form-control"
                                            value="<?= $dataOrgz['type_name'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Organization Name <span class="text-danger">*</span></label>
                                        <input type="text" name="organization_name" class="form-control"
                                            oninput="this.value = this.value.toUpperCase();" value="<?= $dataOrgz['organization_name'] ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">PIC Name <span class="text-danger">*</span></label>
                                        <input type="text" name="pic_name" class="form-control"
                                            oninput="this.value = this.value.replace(/(^\w|\s\w)/g, m => m.toUpperCase());"
                                            style="text-transform: capitalize;" value="<?= $dataOrgz['pic_name'] ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" pattern="[0-9]+"
                                            title="Number Only" value="<?= $dataOrgz['phone'] ?>"
                                            placeholder="Example: 628749345/081234567" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-label">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Example: aaa@mail.com" value="<?= $dataOrgz['email'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status_id" class="form-control select2" required>
                                            <option value="">-- Select --</option>
                                            <?php foreach ($status as $row): ?>
                                                <option value="<?= $row['status_id']; ?>"
                                                    <?= $row['status_id'] == $dataOrgz['status_id'] ? 'selected' : ''; ?>>
                                                    <?= $row['status_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-label">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-label">
                                        <label class="form-label">Note</label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('/Organization') ?>" class="btn btn-default-light">
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
    <?php if (session()->getFlashdata('success')) { ?>
        toastr.success("<?php echo session()->getFlashdata('success'); ?>");
    <?php }  ?>
</script>

<script>
    $('#organizationForm').submit(function(e) {

        e.preventDefault();

        $.ajax({
            url: "<?= base_url('/organization/saveedit/' . $dataOrgz['organization_program_id']) ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
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
            error: function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem'
                });

            }
        });

    });

    $('#province_id').change(function() {

        let provinceId = $(this).val();

        $.get("<?= base_url('users/getProvinsi/') ?>/" + provinceId, function(response) {

            $.each(response, function(i, row) {
                $('#ProvinsiName').val(row.provinsi);
            });

        });

        $('#city_id').html('<option value="">Loading...</option>');
        $('#district_id').html('<option value="">-- Select District --</option>');
        $('#village_id').html('<option value="">-- Select Village --</option>');

        $.get("<?= base_url('users/getCity/') ?>/" + provinceId, function(response) {

            let option = '<option value="">-- Select City --</option>';

            $.each(response, function(i, row) {

                option +=
                    '<option value="' + row.id + '" data-name="' + row.kabupaten_kota + '">' +
                    row.kabupaten_kota +
                    '</option>';

            });

            $('#city_id').html(option).trigger('change.select2');

        });

    });

    $('#city_id').change(function() {

        let cityId = $(this).val();

        let cityName = $(this).find(':selected').data('name');

        $('#district_id').html('<option value="">Loading...</option>');
        $('#village_id').html('<option value="">-- Select Village --</option>');

        $.get("<?= base_url('users/getDistrict/') ?>/" + cityId, function(response) {

            let option = '<option value="">-- Select District --</option>';

            $.each(response, function(i, row) {
                option +=
                    '<option value="' + row.id + '" data-name="' + row.kecamatan + '">' +
                    row.kecamatan +
                    '</option>';

            });

            $('#district_id').html(option).trigger('change.select2');

            $('#cityName').val(cityName);
        });
    });


    $('#district_id').change(function() {

        let districtId = $(this).val();

        let districtName = $(this).find(':selected').data('name');

        $('#village_id').html('<option value="">Loading...</option>');

        $.get("<?= base_url('users/getVillage/') ?>/" + districtId,
            function(response) {

                let option = '<option value="">-- Select Village --</option>';

                $.each(response, function(i, row) {

                    option +=
                        '<option value="' + row.id + '" data-name="' + row.kelurahan + '">' +
                        row.kelurahan +
                        '</option>';

                    $('#VillageName').val(row.kelurahan);
                });

                $('#village_id').html(option).trigger('change.select2');

                $('#districtName').val(districtName);
            }
        );

    });

    $('#village_id').change(function() {

        let villageName = $(this).find(':selected').data('name');

        $('#villageName').val(villageName);


    });
</script>