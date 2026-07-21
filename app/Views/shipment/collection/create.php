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
 * @var array $organization
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
                <form id="shipmentForm" method="post">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
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
                                        <label class="form-label">Driver <span class="text-danger">*</span></label>
                                        <select name="driver_id" class="form-control select2-show-search" required>
                                            <option value="">-- Select Driver --</option>
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
                                            <option value="">-- Select Vehicle --</option>
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
                            </div>

                            

                        </div>

                        <div class="card-body">
                                <h4>Shipment Route</h4>
                            <button type="button" class="btn btn-primary mb-3" id="btnAddRoute">
                                <i class="fa fa-plus"></i> Add Route
                            </button>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="routeTable">
                                    <thead>
                                        <tr>
                                            <th width="60">Seq</th>
                                            <th width="180">Activity</th>
                                            <th>Organization</th>
                                            <th width="180">Departure</th>
                                            <th width="180">Arrival</th>
                                            <th width="120">Qty</th>
                                            <th width="80"></th>
                                        </tr>
                                    </thead>
    
                                    <tbody>
    
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('/Shipment'); ?>" class="btn btn-default-light">Cancel</a>
                                <button type="submit" class="btn btn-teal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
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

let sequence = 1;

$('#btnAddRoute').click(function () {

    let row = `

<tr>
    <td>
        <input type="hidden" name="route[${sequence}][sequence_no]" value="${sequence}">
        ${sequence}
    </td>

    <td>
        <select name="route[${sequence}][activity_type]" class="form-control">
            <option value="PICKUP">Pickup</option>
            <option value="WAREHOUSE">Warehouse</option>
            <option value="SUPPLIER">Supplier</option>
            <option value="BUYER">Buyer</option>
            <option value="TRANSIT">Transit</option>
        </select>
    </td>

    <td>
        <select name="route[${sequence}][organization_program_id]" class="form-control select2-route">
            <option value="">Select Organization</option>
            <?php foreach($organization as $row){ ?>
            <option value="<?= $row['organization_program_id']; ?>">
            <?= $row['organization_name']; ?>
            </option>
        <?php } ?>
        </select>
    </td>

    <td>
        <input
        type="datetime-local"
        class="form-control"
        name="route[${sequence}][departure_at]">
    </td>

    <td>
        <input type="datetime-local" class="form-control" name="route[${sequence}][arrival_at]">
    </td>

    <td>
        <input type="number" step="0.01" class="form-control" name="route[${sequence}][qty]">
    </td>

    <td>
        <button type="button" class="btn btn-danger btn-sm btnDelete">
        <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>

`;

    $('#routeTable tbody').append(row);

    $('.select2-route').select2({
        width:'100%'
    });

    sequence++;

});

$('#departure').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: 'yy-mm-dd',
});

$('#arrival').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: 'yy-mm-dd',
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
            url: "<?= base_url('/shipment/savecreate'); ?>",
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