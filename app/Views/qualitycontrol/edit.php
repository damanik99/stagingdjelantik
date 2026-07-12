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

<?php /** @var array $shipments
 * @var array $companyType
 * @var array $qc
 * */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/QualityControl">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quality Control</li>
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

                        <form id="qcForm" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="form-label">Shipment <span class="text-danger">*</span></label>
                                    <select name="shipment_id" id="shipment_id" class="form-control select2" required>
                                        <option value="">Pilih Shipment</option>
                                        <?php foreach ($shipments as $row) : ?>
                                            <option 
                                                value="<?= $row['shipment_id']; ?>"
                                                <?= $row['shipment_number'] == $qc['shipment_number'] ? 'selected' : ''; ?>>
                                                <?= $row['shipment_number']; ?>
                                                <?php if(!empty($row['departure_at'])) : ?>
                                                    (<?= date('d-m-Y', strtotime($row['departure_at'])); ?>)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Supplier</label>
                                    <input id="type_id" type="text" name="type_id" placeholder="Get Name Supplier" class="form-control" required readonly>
                                </div>

                                <!-- <div class="col-md-6">
                                    <label class="form-label">Company Type<span class="text-danger">*</span></label>
                                    <select id="type_id" name="type_id" class="form-control select2" required>
                                        <option value="">Pilih Jenis</option>
                                    </select>
                                </div> -->

                                <div class="col-md-6">
                                    <label class="form-label">FFA (%) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="ffa" class="form-control" value="<?= $qc['ffa'] ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">M&I (%) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="mi" class="form-control" value="<?= $qc['mi'] ?>" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Hasil <span class="text-danger">*</span></label>
                                    <select name="result" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="in_spec" <?= $qc['result'] == 'in_spec' ? 'selected' : ''; ?>>IN SPEC</option>
                                        <option value="out_spec"<?= $qc['result'] == 'out_spec' ? 'selected' : ''; ?>>OUT SPEC</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Photo</label>
                                    <input type="file" name="photo" accept="image/*" capture="environment" class="form-control">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" rows="4" class="form-control"><?= $qc['notes'] ?></textarea>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('/Qualitycontrol') ?>" class="btn btn-default-light">
                                    <i class="fa fa-window-close"></i>
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

// $('#shipment_id').on('change', function() {

//     let shipmentId = parseInt($(this).val());
//     console.log(shipmentId);

//     $('#type_id').html('<option value="">Loading...</option>');

//     $.get("<?//= base_url('QualityControl/getType/') ?>/" + shipmentId, function(response) {

//         let option = '<option value="">-- Select Company Type --</option>';

//         option += '<option value="'+response.supplier+ ' - ' + 'Supplier'+ '">' + response.supplier + ' - ' + 'SUPPLIER' + '</option>';
//         option += '<option value="'+response.buyer + ' - ' + 'Buyer'+ '">' + response.buyer + ' - ' + 'BUYER' + '</option>';

//         $('#type_id').html(option);

//     });
// });

// $('#shipment_id').on('change', function () {

//     loadType($(this).val());

// });

// function loadType(shipmentId )
// {
//     $('#type_id').html('<option value="">Loading...</option>');

//     if (shipmentId != '') {

//         // Driver
//         $.get("<?//= base_url('QualityControl/getType/') ?>/" + shipmentId, function(response){
            
//             let selecteds = (response.supplier == "<?//= $qc['qc_type']; ?>") ? 'selected' : '';
//             let selectedb = (response.buyer == "<?//= $qc['qc_type']; ?>") ? 'selected' : '';
//             console.log(selectedb);
//             console.log(selecteds);
//             let option = '<option value="">-- Select Company Type --</option>';

//             option += '<option value="'+response.supplier+'" '+selecteds+'>'+response.supplier+'</option>';
//             option += '<option value="'+response.buyer+'" '+selectedb+'>'+response.buyer+'</option>';

//             $('#type_id').html(option);

//         });

//     } else {

//         $('#type_id').html('<option value="">-- Select Company IT --</option>');
//     }
// }

$(document).ready(function() {
    
    function fetchSupplier(shipmentId) {
        if (shipmentId) {
            $.ajax({
                url: '<?= base_url('QualityControl/getType/') ?>/' + shipmentId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.supplier) {
                        $('#type_id').val(response.supplier);
                    } else {
                        $('#type_id').val('Nama tidak ditemukan');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data supplier: ", error);
                    $('#type_id').val('Gagal memuat data');
                }
            });
        } else {
            $('#type_id').val('');
        }
    }

    // 2. Kebutuhan CREATE: Jalankan fungsi ketika user MENGUBAH pilihan dropdown
    $('#shipment_id').on('change', function() {
        let shipmentId = parseInt($(this).val());
        fetchSupplier(shipmentId);
    });

    // 3. Kebutuhan EDIT: Jalankan fungsi OTOMATIS saat halaman pertama kali selesai dimuat
    let currentShipmentId = parseInt($('#shipment_id').val());
    if (currentShipmentId) {
        fetchSupplier(currentShipmentId);
    }
});

$('#qcForm').submit(function(e){

    e.preventDefault();

    let formData = new FormData(this);


    console.log('=== FORM DATA ===');

    for (let pair of formData.entries()) {
        console.log(pair[0] + ':', pair[1]);
    }    
                                          
    $.ajax({
        url: "<?= base_url('QualityControl/edit/'.$qc['qc_id']) ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){

           console.log('=== REQUEST SENT ===');

            Swal.fire({
                title: 'Saving...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

        },
        success: function(response, textStatus, xhr){

            console.log('=== SUCCESS ===');
            console.log('Status:', xhr.status);
            console.log('Response:', response);

            if(response.status){

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {

                    window.location.href =
                        "<?= base_url('/QualityControl') ?>";

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
                    icon: 'error',
                    title: 'Validation Error',
                    html: errors
                });
            }
        },
        error: function(){

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Server Error'
            });

        }

    });

});

</script>