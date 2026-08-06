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
 * @var array $warehouse
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
                                            <th>Warehouse</th>
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

            <select class="form-control select2-route warehouse">

                <option value="">Select Warehouse</option>

                <?php foreach($warehouse as $wh){ ?>

                    <option value="<?= $wh['warehouse_id']; ?>">
                        <?= esc($wh['warehouse_name']); ?>
                    </option>

                <?php } ?>

            </select>

        </td>

        <td>
            <input type="text" class="form-control departure">
        </td>

        <td>
            <input type="text" class="form-control arrival">
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

    let dropoff = $('#routeTable tbody .activity-type').filter(function(){

        return $(this).val() === 'DROPOFF';

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

function resetRoute(){

    let rows = $('#routeTable tbody tr');

    rows.each(function(index) {

        let seq = index + 1;

        let isDropoff = (seq === rows.length);

        //=======================
        // Sequence
        //=======================

        $(this).find('.seq-col span').text(seq);

        $(this).find('.sequence-no')
            .val(seq)
            .attr('name',`route[${index}][sequence_no]`);

        //=======================
        // Activity
        //=======================

        let activity = isDropoff
            ? 'DROPOFF'
            : 'PICKUP';

        $(this).find('.activity-label').text(activity);

        $(this).find('.activity-type')
            .val(activity)
            .attr('name',`route[${index}][activity_type]`);

        //=======================
        // Organization
        //=======================

        $(this).find('.organization-program')
            .attr('name',`route[${index}][organization_program_id]`);

        //=======================
        // Warehouse
        //=======================

        $(this).find('.warehouse')
            .attr('name',`route[${index}][warehouse_id]`);

        //=======================
        // Departure
        //=======================

        $(this).find('.departure')
            .attr('name',`route[${index}][departure_at]`);

        //=======================
        // Arrival
        //=======================

        $(this).find('.arrival')
            .attr('name',`route[${index}][arrival_at]`);

        //=======================
        // B2C Logic
        //=======================

        if(isDropoff) 
        {
            $(this).find('.organization-program').prop('disabled', false);
            $(this).find('.warehouse').prop('disabled', false);
            $(this).find('.btnDelete').hide();
        } 
        else 
        {
            $(this).find('.organization-program').prop('disabled', false);
            $(this).find('.warehouse').val('').trigger('change').prop('disabled', true);
            $(this).find('.btnDelete').show();

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

//save data shipment
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