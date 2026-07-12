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
 <link href="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.css" rel="stylesheet"/>

<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

<?php /** @var array $po
 * @var array $buyer
 * @var array $supplier
 * @var array $driver
 * @var array $vehicle
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
                    <li class="breadcrumb-item active" aria-current="page">Create New Company</li>
                </ol>
                <h1 class="page-title">Create Shipment</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/Companytype/create" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> Create Company Type
                </a>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <form id="shipmentForm" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Shipment Number <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="shipment_number"
                                            class="form-control"
                                            value="Auto Generate"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Purchase Order</label>
                                        <select name="purchase_order_id"
                                                class="form-control select2-show-search">
                                            <option value="">Select Purchase Order</option>
                                            <?php //foreach ($po as $row) : ?>
                                                <option value="<?//= $row['purchase_order_id']; ?>">
                                                    <?//= $row['po_number']; ?>
                                                </option>
                                            <?php //endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                        <select name="supplier_company_program_id" id="supplier_company_program_id"
                                                class="form-control select2-show-search">
                                            <option value="">Select Supplier</option>
                                            <?php foreach ($supplier as $row) : ?>
                                                <option value="<?= $row['company_program_id']; ?>">
                                                    <?= $row['company_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Buyer <span class="text-danger">*</span></label>
                                        <select name="buyer_company_program_id"
                                                class="form-control select2-show-search" required>
                                            <option value="">Select Buyer</option>
                                            <?php foreach ($buyer as $row) : ?>
                                                <option value="<?= $row['company_program_id']; ?>">
                                                    <?= $row['company_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Driver <span class="text-danger">*</span></label>
                                        <select name="driver_id" class="form-control select2-show-search" required>
                                            <option value="">--Select Driver--</option>
                                            <?php foreach ($driver as $row) : ?>
                                                <option value="<?= $row['driver_id']; ?>">
                                                    <?= $row['driver_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Vehicle</label>
                                        <select name="vehicle_id" class="form-control select2-show-search">
                                            <option value="">Select Vehicle</option>
                                            <?php foreach ($vehicle as $row) : ?>
                                                <option value="<?= $row['vehicle_id']; ?>">
                                                    <?= $row['plate_number'].' - '.$row['brand']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Departure Date</label>
                                        <div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
                                                <input name="departure_at" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="departure" required>
											</div>
										</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Arrival Date</label>
                                        <div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
                                                <input name="arrival_at" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="arrival" required>
											</div>
										</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status_id" class="form-control select2-show-search" required>
                                            <option value="">Select Status</option>
                                            <?php foreach ($status as $row) : ?>
                                                <option value="<?= $row['status_id']; ?>">
                                                    <?= $row['status_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('/Shipment'); ?>" class="btn btn-default-light">Cancel</a>
                                <button type="submit" class="btn btn-teal">Save</button>
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

<script type="text/javascript">
<?php if (session()->getFlashdata('success')) {?>
toastr.success("<?php echo session()->getFlashdata('success'); ?>");
<?php }  ?>
</script>

<script>

$('#departure').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: 'yy-mm-dd',
    minDate: 0
});

$('#arrival').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: 'yy-mm-dd',
    minDate: 0
});

$('#supplier_company_program_id').change(function () {

    let company_program_id = $(this).val();

    $('#driver_id').html('<option value="">Loading...</option>');
    $('#vehicle_id').html('<option value="">Loading...</option>');

    if(company_program_id != ''){

        // Driver
        $.get("<?= base_url('shipment/get_driver/') ?>/" + company_program_id, function(response){
            let option = '<option value=""> -- Select Driver -- </option>';

            $.each(response, function(i,row){

                option += '<option value="'+row.driver_id+'">'+ row.driver_name+'</option>';

            });

            $('#driver_id').html(option);

        });

        // Vehicle
        $.get("<?= base_url('shipment/get_vehicle/') ?>/" + company_program_id, function(response){
            let option = '<option value=""> -- Select Driver -- </option>';

            $.each(response, function(i,row){

                option += '<option value="'+row.vehicle_id+'">'+ row.plate_number+' - '+row.brand+'</option>';

            });

            $('#vehicle_id').html(option);
            

        });

    }else{

        $('#driver_id').html('<option value="">Select Driver</option>');
        $('#vehicle_id').html('<option value="">Select Vehicle</option>');
    }

});


$(document).ready(function () {

    $('.select2-show-search').select2({
        width: '100%'
    });

    $('#shipmentForm').submit(function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        console.log(formData);
        Swal.fire({
            title: 'Please Wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "<?= base_url('/shipment/create'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);
                console.log(typeof response); 
                if (response.success == true) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        window.location.href = "<?= base_url('/Shipment'); ?>";
                    });

                } else {

                    let errorMsg = '';

                    $.each(response.message, function(key, value) {
                        errorMsg += value + '<br>';
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
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