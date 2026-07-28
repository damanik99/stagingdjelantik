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
                                        <input type="text" name="shipment_number"
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
                                        <label class="form-label">Vehicle <span class="text-danger">*</span></label>
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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Shipment Type <span class="text-danger">*</span></label>
                                        <select name="shipment_type" class="form-control" required>
                                            <option value="">-- Select Shipment Type --</option>
                                                <option value="COLLECTION"> Collection</option>
                                                <option value="INBOUND">Inbound</option>
                                                <option value="OUTBOUND">Outbound</option>
                                                <option value="TRANSFER">Transfer</option>
                                        </select>
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
            <option value="DROPOFF">Drop Off</option>
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
            type="text"
            class="form-control departure"
            name="route[${sequence}][departure_at]">
    </td>

    <td>
        <input
            type="text"
            class="form-control arrival"
            name="route[${sequence}][arrival_at]">
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

    $('.departure').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd',
    });

    $('.arrival').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd',
    });

    sequence++;

});

$(document).ready(function () {

    $('.select2-show-search').select2({
        width: '100%'
    });

    $('#shipmentForm').submit(function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        Swal.fire({
            title: 'Please Wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "<?= base_url('/shipment/save'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                console.log('test',response);
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

                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation',
                        text: response.message
                    });

                    return;

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

// Delete Row
$(document).on('click','.btnDelete',function(){

    $(this).closest('tr').remove();

    resetSequence();

});
// Reset Sequence number
function resetSequence(){

    let no = 1;

    $('#routeTable tbody tr').each(function(){

        $(this).find('td:first').html(`
            <input type="hidden"
                   name="route[${no}][sequence_no]"
                   value="${no}">
            ${no}
        `);

        $(this).find('select:eq(0)')
               .attr('name',`route[${no}][activity_type]`);

        $(this).find('select:eq(1)')
               .attr('name',`route[${no}][organization_program_id]`);

        $(this).find('input:eq(1)')
               .attr('name',`route[${no}][departure_at]`);

        $(this).find('input:eq(2)')
               .attr('name',`route[${no}][arrival_at]`);

        $(this).find('input:eq(3)')
               .attr('name',`route[${no}][qty]`);

        no++;

    });

    sequence = no;

}
</script>