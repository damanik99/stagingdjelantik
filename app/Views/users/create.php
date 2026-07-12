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

<?php /** @var array $groups 
 * @var array $suppliers 
 *  @var array $companies
 * @var array $provinces
 * @var array $groupProgram
 * */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Users">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create New Users</li>
                </ol>
                <h1 class="page-title">Create Users/Driver</h1>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <form id="formCreateUser">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text"name="fullname" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Province <span class="text-danger">*</span></label>
                                    <select name="province_id" id="province_id" class="form-control select2-show-search">
                                        <option value="">-- Select Province --</option>
                                        <?php foreach ($provinces as $row): ?>
                                            <option value="<?= $row['id']; ?>">
                                                <?= esc($row['provinsi']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select name="city_id" id="city_id" class="form-control select2-show-search">
                                        <option value="">-- Select City --</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">District <span class="text-danger">*</span></label>
                                    <select name="district_id" id="district_id" class="form-control select2-show-search">
                                        <option value="">-- Select District --</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Village <span class="text-danger">*</span></label>
                                    <select name="village_id" id="village_id" class="form-control select2-show-search">
                                        <option value="">-- Select Village --</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" rows="3" class="form-control"></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <select name="title" class="form-control select2">
                                    <option value="">Pilih Role</option>
                                    <?php foreach ($groupProgram as $row): ?>
                                        <option value="<?= $row['group']; ?>">
                                            <?= esc($row['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Group <span class="text-danger">*</span></label>
                                    <select name="group_id" id="group_id" class="form-control select2">
                                        <option value="">
                                            -- Select Group --
                                        </option>
                                        <?php foreach($groups as $group): ?>
                                            <option value="<?= $group['group_id']; ?>">
                                                <?= esc($group['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Data Level -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Data Level
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="data_level" class="form-control select2">
                                        <option value="">
                                            -- Select Data Level --
                                        </option>
                                        <option value="HIGH">
                                            High
                                        </option>
                                        <option value="LOW">
                                            Low
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- DRIVER SECTION -->
                            <div id="driverSection" style="display:none;">
                                <hr>
                                <h5>Driver Information</h5>
                                <div class="row">
                                    <!-- Driver Type -->
                                    <div class="col-md-6">
                                        <label class="form-label">Driver Type
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="driver_type" id="driver_type" class="form-control">
                                            <option value="">
                                                -- Select Driver Type --
                                            </option>
                                            <option value="INTERNAL">
                                                INTERNAL
                                            </option>
                                            <option value="SUPPLIER">
                                                SUPPLIER
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3" id="supplierSection" style="display:none;">
                                        <label class="form-label">
                                            Supplier <span class="text-danger">*</span>
                                        </label>

                                        <select name="company_program_id" class="form-control">
                                            <option value="">
                                                -- Select Supplier --
                                            </option>
                                            <?php foreach ($companies as $company): ?>
                                                <option value="<?= $company['company_program_id']; ?>">
                                                    <?= esc($company['company_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Driver Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="driver_name"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            License Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            name="license_number"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">License Type</label>
                                        <select name="license_type" class="form-control">
                                            <option value="">
                                                -- Select License Type --
                                            </option>
                                            <option value="A">SIM A</option>
                                            <option value="B1">SIM B1</option>
                                            <option value="B2">SIM B2</option>

                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            License Expiry Date
                                        </label>
                                        <input
                                            type="date"
                                            name="license_expiry_date"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center mt-5">
                                <a href="<?= base_url('users'); ?>" class="btn btn-default-light">
                                    <i class="fa fa-window-close"></i>
                                    Cancel
                                </a>
                                <button type="button" id="btnSave" class="btn btn-teal">
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
    const DRIVER_GROUP_ID = 2;

    $('.select2').select2({
        width: '100%'
    });

    $('#group_id').on('change', function() {

        let groupId = parseInt($(this).val());

        if(groupId === DRIVER_GROUP_ID)
        {
            $('#driverSection').slideDown();
        }
        else
        {
            $('#driverSection').slideUp();
        }

    });

    $('#driver_type').on('change', function() {

        let driverType = $(this).val();

        if(driverType === 'SUPPLIER')
        {
            $('#supplierSection').show();
        }
        else
        {
            $('#supplierSection').hide();
        }

    });

    $('#btnSave').on('click', function(e) {

        e.preventDefault();

        let formData = new FormData(
            document.getElementById('formCreateUser')
        );

        console.log('=== FORM DATA ===');

        for (let pair of formData.entries()) {
            console.log(pair[0] + ':', pair[1]);
        }

        $.ajax({
            url: "<?= base_url('/users/store') ?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            beforeSend: function() {

                console.log('=== REQUEST SENT ===');

                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },

            success: function(res, textStatus, xhr) {

                Swal.close();

                console.log('=== SUCCESS ===');
                console.log('Status:', xhr.status);
                console.log('Response:', res);

                if (res.status) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message
                    }).then(() => {

                        window.location.href =
                            "<?= base_url('/Users') ?>";

                    });

                } else {

                    let msg = '';

                    if (typeof res.message === 'object') {

                        $.each(res.message, function(key, val) {

                            console.log('Validation Error:', key, val);

                            msg += val + '<br>';

                        });

                    } else {

                        console.log('Message:', res.message);

                        msg = res.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation',
                        html: msg
                    });
                }
            },

            error: function(xhr, status, error) {

                Swal.close();

                console.log('=== AJAX ERROR ===');
                console.log('Status:', xhr.status);
                console.log('Status Text:', xhr.statusText);
                console.log('Error:', error);
                console.log('Response Text:', xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html:
                        '<b>Status:</b> ' + xhr.status +
                        '<br><br><b>Error:</b><br>' +
                        xhr.responseText
                });
            }
        });
    });

    $('#province_id').change(function() {

        let provinceId = $(this).val();

        $('#city_id').html('<option value="">Loading...</option>');
        $('#district_id').html('<option value="">-- Select District --</option>');
        $('#village_id').html('<option value="">-- Select Village --</option>');

        $.get("<?= base_url('users/getCity/') ?>/" + provinceId, function(response){

                let option = '<option value="">-- Select City --</option>';

                $.each(response, function(i,row){

                    option +=
                        '<option value="'+row.id+'">'+
                        row.kabupaten_kota+
                        '</option>';

                });

                $('#city_id').html(option);

            }
        );

    });

    $('#city_id').change(function() {

        let cityId = $(this).val();

        $('#district_id').html('<option value="">Loading...</option>');
        $('#village_id').html('<option value="">-- Select Village --</option>');

        $.get("<?= base_url('users/getDistrict/') ?>/" + cityId, function(response){

                let option = '<option value="">-- Select District --</option>';
                $.each(response, function(i,row){
                    option +=
                        '<option value="'+row.id+'">'+
                        row.kecamatan+
                        '</option>';
                });
                $('#district_id').html(option);
            }
        );
    });

    $('#district_id').change(function() {

        let districtId = $(this).val();

        $('#village_id').html('<option value="">Loading...</option>');

        $.get("<?= base_url('users/getVillage/') ?>/" + districtId,
            function(response){

                let option = '<option value="">-- Select Village --</option>';

                $.each(response, function(i,row){

                    option +=
                        '<option value="'+row.id+'">'+
                        row.kelurahan+
                        '</option>';

                });

                $('#village_id').html(option);

            }
        );

    });
    
</script>