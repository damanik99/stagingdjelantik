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

<?php /** @var array<string, mixed> $shipment, 
 * @var array<string, mixed> $driver 
 * @var array<string, mixed> $vehicle 
 * @var array<string, mixed> $routes
 * @var array<string, mixed> $organization
 * */ 
?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Shipment">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Shipment</li>
                </ol>
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
                                            value="<?= $shipment['shipment_number'] ?>"
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
                                                <option value="<?= $row['driver_id']; ?>" 
                                                <?= $row['driver_id'] == $shipment['driver_id'] ? 'selected' : ''; ?>>
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
                                                <option value="<?= $row['vehicle_id']; ?>" 
                                                <?= $row['vehicle_id'] == $shipment['vehicle_id'] ? 'selected' : ''; ?>>
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
                                                <option value="COLLECTION" <?= $shipment['shipment_type'] == 'COLLECTION' ? 'selected' : ''; ?>> Collection</option>
                                                <option value="INBOUND" <?= $shipment['shipment_type'] == 'INBOUND' ? 'selected' : ''; ?>>Inbound</option>
                                                <option value="OUTBOUND" <?= $shipment['shipment_type'] == 'OUTBOUND' ? 'selected' : '';?>>Outbound</option>
                                                <option value="TRANSFER" <?= $shipment['shipment_type'] == 'TRANSFER' ? 'selected' : '';?>>Transfer</option>
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
                                        <tbody>
                                            <?php foreach ($routes as $index => $row): ?>

                                            <tr>

                                                <!-- Sequence -->
                                                <td class="text-center seq-col">

                                                    <input
                                                        type="hidden"
                                                        class="sequence-no"
                                                        name="route[<?= $index ?>][sequence_no]"
                                                        value="<?= $row['sequence_no']; ?>">

                                                    <span><?= $row['sequence_no']; ?></span>

                                                </td>

                                                <!-- Activity -->
                                                <td>
                                                    <input
                                                        type="hidden"
                                                        class="activity-type"
                                                        name="route[<?= $index ?>][activity_type]"
                                                        value="<?= $row['activity_type']; ?>">

                                                    <span class="activity-label">
                                                        <?= $row['activity_type']; ?>
                                                    </span>

                                                </td>
                                                <!-- Organization -->
                                                <td>
                                                    <select class="form-control select2-route organization-program"
                                                    name="route[<?= $index ?>][organization_program_id]">>

                                                        <option value="">Select Organization</option>

                                                        <?php foreach($organization as $org): ?>

                                                            <option
                                                                value="<?= $org['organization_program_id']; ?>"
                                                                <?= $org['organization_program_id']==$row['organization_program_id']
                                                                    ? 'selected':'';
                                                                ?>>

                                                                <?= esc($org['organization_name']); ?>

                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>

                                                </td>

                                                <!-- Departure -->
                                                <td>

                                                    <input
                                                        type="text"
                                                        class="form-control departure"
                                                        name="route[<?= $index ?>][departure_at]"
                                                        value="<?= $row['departure_at']; ?>">

                                                </td>

                                                <!-- Arrival -->
                                                <td>

                                                    <input
                                                        type="text"
                                                        class="form-control arrival"
                                                        name="route[<?= $index ?>][arrival_at]"
                                                        value="<?= $row['arrival_at']; ?>">

                                                </td>

                                                <td class="text-center">

                                                    <button
                                                        type="button"
                                                        class="btn btn-danger btn-sm btnDelete">

                                                        <i class="fa fa-trash"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                            <?php endforeach; ?>

                                            </tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('/Shipment'); ?>" class="btn btn-default-light">Cancel</a>
                                <button type="submit" class="btn btn-teal">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
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

function createRouteRow() {

    let row = $(`
        <tr>

            <td class="seq-col">
                <span></span>
                <input type="hidden" class="sequence-no">
            </td>

            <td class="activity-col">

                <span class="activity-label">PICKUP</span>

                <input
                    type="hidden"
                    class="activity-type"
                    value="PICKUP">

            </td>

            <td>

                <select class="form-control select2-route organization-program">

                    <option value="">Select Organization</option>

                    <?php foreach($organization as $org){ ?>

                        <option value="<?= $org['organization_program_id']; ?>">
                            <?= esc($org['organization_name']); ?>
                        </option>

                    <?php } ?>

                </select>

            </td>

            <td>

                <input
                    type="text"
                    class="form-control departure">

            </td>

            <td>

                <input
                    type="text"
                    class="form-control arrival">

            </td>

            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-danger btn-sm btnDelete">

                    <i class="fa fa-trash"></i>

                </button>

            </td>

        </tr>
    `);

    initRow(row);

    return row;

}

function appendPickup(){

    let row = createRouteRow();

    // cari row Dropoff
    let dropoff = $('#routeTable tbody .activity-type').filter(function(){

        return $(this).val() == 'DROPOFF';

    }).closest('tr');

    if(dropoff.length){

        row.insertBefore(dropoff);

    }else{

        $('#routeTable tbody').append(row);

    }

    resetRoute();

}

$('#btnAddRoute').click(function(){

    appendPickup();

});

function resetRoute() {

    let rows = $('#routeTable tbody tr');

    rows.each(function(index){

        let seq = index + 1;

        let activity = (seq === rows.length)
            ? 'DROPOFF'
            : 'PICKUP';

        // Sequence
        $(this).find('.seq-col span')
               .text(seq);

        $(this).find('.sequence-no')
               .val(seq)
               .attr('name', `route[${index}][sequence_no]`);

        // Activity
        $(this).find('.activity-label')
               .text(activity);

        $(this).find('.activity-type')
               .val(activity)
               .attr('name', `route[${index}][activity_type]`);

        // Organization
        $(this).find('.organization-program')
               .attr('name', `route[${index}][organization_program_id]`);

        // Departure
        $(this).find('.departure')
               .attr('name', `route[${index}][departure_at]`);

        // Arrival
        $(this).find('.arrival')
               .attr('name', `route[${index}][arrival_at]`);

        // Tombol Delete
        if (activity === 'DROPOFF') {

            $(this).find('.btnDelete')
                .prop('disabled', true)
                .removeClass('btn-danger')
                .addClass('btn-secondary');

        } else {

            $(this).find('.btnDelete')
                .prop('disabled', false)
                .removeClass('btn-secondary')
                .addClass('btn-danger');

        }

    });

}

function initRow(scope){

    scope.find('.select2-route').select2({
        width:'100%'
    });

    scope.find('.departure').datepicker({
        showOtherMonths:true,
        selectOtherMonths:true,
        dateFormat:'yy-mm-dd'
    });

    scope.find('.arrival').datepicker({
        showOtherMonths:true,
        selectOtherMonths:true,
        dateFormat:'yy-mm-dd'
    });

}

$(function(){

    initRow($(document));

    resetRoute();

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
        url: "<?= base_url('/shipment/updateCollection/'.$shipment['shipment_id']); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
            
            if (response.status == true) {

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

$(document).on('click', '.btnDelete', function () {

    let row = $(this).closest('tr');

    if (row.find('.activity-type').val() === 'DROPOFF') {
        return;
    }

    row.remove();

    resetRoute();

});


</script>
