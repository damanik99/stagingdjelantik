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
 * @var array<string, mixed> $warehouse
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
                                        <select name="shipment_type" class="form-control" disabled>
                                            <option value="">-- Select Shipment Type --</option>
                                                <option value="COLLECTION" <?= $shipment['shipment_type'] == 'COLLECTION' ? 'selected' : ''; ?>> Collection</option>
                                                <option value="INBOUND" <?= $shipment['shipment_type'] == 'INBOUND' ? 'selected' : ''; ?>>Inbound</option>
                                                <option value="OUTBOUND" <?= $shipment['shipment_type'] == 'OUTBOUND' ? 'selected' : '';?>>Outbound</option>
                                                <option value="TRANSFER" <?= $shipment['shipment_type'] == 'TRANSFER' ? 'selected' : '';?>>Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="shipment_type" value="<?= $shipment['shipment_type']; ?>">
                            </div>
                        </div>

                        <div class="card-body">
                            <h4>Shipment Route</h4>
                            <!-- button route -->
                            <button type="button" class="btn btn-primary mb-3" id="btnAddRoute">
                                <i class="fa fa-plus"></i> Add Pickup
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
                                                    name="route[<?= $index ?>][organization_program_id]">

                                                        <option value="">Select Organization</option>

                                                        <?php foreach($organization as $org): ?>

                                                            <option
                                                                value="<?= $org['organization_program_id']; ?>"
                                                                <?= $org['organization_program_id'] == $row['organization_program_id']
                                                                    ? 'selected':'';
                                                                ?>>

                                                                <?= esc($org['organization_name']); ?>

                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>

                                                </td>

                                                <!-- Warehouse -->
                                                <td>
                                                    <select
                                                        class="form-control select2-route warehouse"
                                                        name="route[<?= $index ?>][warehouse_id]">

                                                        <option value="">Select Warehouse</option>

                                                        <?php foreach($warehouse as $wh): ?>
                                                            <option
                                                                value="<?= $wh['warehouse_id']; ?>"
                                                                <?= $wh['warehouse_id'] == $row['warehouse_id']
                                                                    ? 'selected'
                                                                    : ''; ?>>

                                                                <?= esc($wh['warehouse_name']); ?>

                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>
                                                </td>

                                                <!-- Departure -->
                                                <td>

                                                    <input type="text" class="form-control departure" name="route[<?= $index ?>][departure_at]"
                                                        value="<?= $row['departure_at']; ?>">

                                                </td>

                                                <!-- Arrival -->
                                                <td>

                                                    <input type="text" class="form-control arrival" name="route[<?= $index ?>][arrival_at]"
                                                        value="<?= $row['arrival_at']; ?>">
                                                </td>

                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btnDelete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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

/*
|--------------------------------------------------------------------------
| Shipment Rule
|--------------------------------------------------------------------------
|
| Business Rule:
|
| COLLECTION
|   PICKUP    -> Organization
|   PICKUP    -> Organization
|   ...
|   DROPOFF   -> Organization / Warehouse
|
| INBOUND
|   PICKUP    -> Organization
|   DROPOFF   -> Warehouse
|
| OUTBOUND
|   PICKUP    -> Warehouse
|   DROPOFF   -> Organization
|
| TRANSFER
|   PICKUP    -> Warehouse
|   DROPOFF   -> Warehouse
|
|--------------------------------------------------------------------------
*/

const ShipmentRule = {

    COLLECTION: {

        allowAdd: true,

        pickup: {
            organization: true,
            warehouse: false,
            delete: true
        },

        dropoff: {
            organization: true,
            warehouse: true,
            delete: false
        }

    },


    INBOUND: {

        allowAdd: false,

        pickup: {
            organization: true,
            warehouse: false,
            delete: false
        },

        dropoff: {
            organization: false,
            warehouse: true,
            delete: false
        }

    },


    OUTBOUND: {

        allowAdd: false,

        pickup: {
            organization: false,
            warehouse: true,
            delete: false
        },

        dropoff: {
            organization: true,
            warehouse: false,
            delete: false
        }

    },


    TRANSFER: {

        allowAdd: false,

        pickup: {
            organization: false,
            warehouse: true,
            delete: false
        },

        dropoff: {
            organization: false,
            warehouse: true,
            delete: false
        }

    }

};


/*
|--------------------------------------------------------------------------
| Apply Shipment Rule
|--------------------------------------------------------------------------
*/

function applyShipmentRule(row)
{
    const shipmentType =
        $('[name="shipment_type"]').val();

    const activity =
        row.find('.activity-type').val();

    const rule =
        ShipmentRule[shipmentType];

    if (!rule) {
        return;
    }

    const config =
        activity === 'PICKUP'
            ? rule.pickup
            : rule.dropoff;


    const organization =
        row.find('.organization-program');

    const warehouse =
        row.find('.warehouse');

    const btnDelete =
        row.find('.btnDelete');


    /*
    |--------------------------------------------------------------------------
    | Organization
    |--------------------------------------------------------------------------
    */

    organization.prop(
        'disabled',
        !config.organization
    );

    if (!config.organization) {

        organization
            .val('')
            .trigger('change');

    }


    /*
    |--------------------------------------------------------------------------
    | Warehouse
    |--------------------------------------------------------------------------
    */

    warehouse.prop(
        'disabled',
        !config.warehouse
    );

    if (!config.warehouse) {

        warehouse
            .val('')
            .trigger('change');

    }


    /*
    |--------------------------------------------------------------------------
    | Delete Button
    |--------------------------------------------------------------------------
    */

    btnDelete
        .prop(
            'disabled',
            !config.delete
        )
        .toggleClass(
            'btn-danger',
            config.delete
        )
        .toggleClass(
            'btn-secondary',
            !config.delete
        );

}


/*
|--------------------------------------------------------------------------
| Initialize Row
|--------------------------------------------------------------------------
*/

function initRow(scope)
{
    scope.find('.select2-route').each(function () {

        if ($(this).hasClass('select2-hidden-accessible')) {
            return;
        }

        $(this).select2({
            width: '100%'
        });

    });


    scope.find('.departure').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd'
    });


    scope.find('.arrival').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd'
    });
}


/*
|--------------------------------------------------------------------------
| Reset Route
|--------------------------------------------------------------------------
|
| IMPORTANT:
| resetRoute() TIDAK mengubah activity.
|
| Activity berasal dari:
| - database untuk route existing
| - ShipmentRule untuk route baru
|
| resetRoute hanya:
| - sequence
| - name attribute
|
|--------------------------------------------------------------------------
*/

function resetRoute()
{
    const rows =
        $('#routeTable tbody tr');


    rows.each(function(index) {

        const seq =
            index + 1;


        /*
        |--------------------------------------------------------------------------
        | Activity dari row
        |--------------------------------------------------------------------------
        */

        const activity =
            $(this)
                .find('.activity-type')
                .val();


        /*
        |--------------------------------------------------------------------------
        | Sequence
        |--------------------------------------------------------------------------
        */

        $(this)
            .find('.seq-col span')
            .text(seq);


        $(this)
            .find('.sequence-no')
            .val(seq)
            .attr(
                'name',
                `route[${index}][sequence_no]`
            );


        /*
        |--------------------------------------------------------------------------
        | Activity
        |--------------------------------------------------------------------------
        */

        $(this)
            .find('.activity-type')
            .attr(
                'name',
                `route[${index}][activity_type]`
            );


        /*
        |--------------------------------------------------------------------------
        | Organization
        |--------------------------------------------------------------------------
        */

        $(this)
            .find('.organization-program')
            .attr(
                'name',
                `route[${index}][organization_program_id]`
            );


        /*
        |--------------------------------------------------------------------------
        | Warehouse
        |--------------------------------------------------------------------------
        */

        $(this)
            .find('.warehouse')
            .attr(
                'name',
                `route[${index}][warehouse_id]`
            );


        /*
        |--------------------------------------------------------------------------
        | Departure
        |--------------------------------------------------------------------------
        */

        $(this)
            .find('.departure')
            .attr(
                'name',
                `route[${index}][departure_at]`
            );


        /*
        |--------------------------------------------------------------------------
        | Arrival
        |--------------------------------------------------------------------------
        */

        $(this)
            .find('.arrival')
            .attr(
                'name',
                `route[${index}][arrival_at]`
            );


        /*
        |--------------------------------------------------------------------------
        | Apply Business Rule
        |--------------------------------------------------------------------------
        */

        applyShipmentRule($(this));

    });
}


/*
|--------------------------------------------------------------------------
| Create New Route Row
|--------------------------------------------------------------------------
|
| Digunakan hanya ketika user menambahkan PICKUP baru.
|
|--------------------------------------------------------------------------
*/

function createRouteRow(config)
{
    let row = $(`
        <tr>

            <!-- Sequence -->
            <td class="text-center seq-col">

                <span></span>

                <input
                    type="hidden"
                    class="sequence-no">

            </td>


            <!-- Activity -->
            <td>

                <input
                    type="hidden"
                    class="activity-type">

                <span class="activity-label"></span>

            </td>


            <!-- Organization -->
            <td>

                <select
                    class="form-control select2-route organization-program">

                    <option value="">
                        Select Organization
                    </option>

                    <?php foreach ($organization as $org): ?>

                        <option value="<?= $org['organization_program_id']; ?>">

                            <?= esc($org['organization_name']); ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </td>


            <!-- Warehouse -->
            <td>

                <select
                    class="form-control select2-route warehouse">

                    <option value="">
                        Select Warehouse
                    </option>

                    <?php foreach ($warehouse as $wh): ?>

                        <option value="<?= $wh['warehouse_id']; ?>">

                            <?= esc($wh['warehouse_name']); ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </td>


            <!-- Departure -->
            <td>

                <input
                    type="text"
                    class="form-control departure">

            </td>


            <!-- Arrival -->
            <td>

                <input
                    type="text"
                    class="form-control arrival">

            </td>


            <!-- Delete -->
            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-danger btn-sm btnDelete">

                    <i class="fa fa-trash"></i>

                </button>

            </td>

        </tr>
    `);


    /*
    |--------------------------------------------------------------------------
    | Activity
    |--------------------------------------------------------------------------
    */

    row.find('.activity-label')
        .text(config.activity);


    row.find('.activity-type')
        .val(config.activity);


    /*
    |--------------------------------------------------------------------------
    | Organization
    |--------------------------------------------------------------------------
    */

    row.find('.organization-program')
        .prop(
            'disabled',
            !config.organization
        );


    if (!config.organization) {

        row.find('.organization-program')
            .val('')
            .trigger('change');

    }


    /*
    |--------------------------------------------------------------------------
    | Warehouse
    |--------------------------------------------------------------------------
    */

    row.find('.warehouse')
        .prop(
            'disabled',
            !config.warehouse
        );


    if (!config.warehouse) {

        row.find('.warehouse')
            .val('')
            .trigger('change');

    }


    /*
    |--------------------------------------------------------------------------
    | Delete Button
    |--------------------------------------------------------------------------
    */

    row.find('.btnDelete')
        .prop(
            'disabled',
            !config.delete
        )
        .toggleClass(
            'btn-danger',
            config.delete
        )
        .toggleClass(
            'btn-secondary',
            !config.delete
        );


    /*
    |--------------------------------------------------------------------------
    | Initialize Select2 / Datepicker
    |--------------------------------------------------------------------------
    */

    initRow(row);


    return row;
}


/*
|--------------------------------------------------------------------------
| Append Pickup
|--------------------------------------------------------------------------
|
| Collection:
|
| Pickup
| Pickup
| Pickup
| Dropoff
|
| Pickup baru selalu diletakkan sebelum Dropoff.
|
|--------------------------------------------------------------------------
*/

function appendPickup()
{
    const row =
        createRouteRow({

            activity: 'PICKUP',

            organization: true,

            warehouse: false,

            delete: true

        });


    const dropoff =
        $('#routeTable tbody .activity-type')
            .filter(function () {

                return $(this).val() === 'DROPOFF';

            })
            .closest('tr');


    if (dropoff.length) {

        row.insertBefore(dropoff);

    } else {

        $('#routeTable tbody')
            .append(row);

    }


    resetRoute();
}


/*
|--------------------------------------------------------------------------
| Add Route Button
|--------------------------------------------------------------------------
*/

$('#btnAddRoute').on('click', function () {

    const shipmentType =
        $('[name="shipment_type"]').val();


    const rule =
        ShipmentRule[shipmentType];


    if (!rule || !rule.allowAdd) {

        return;

    }


    appendPickup();

});


/*
|--------------------------------------------------------------------------
| Delete Route
|--------------------------------------------------------------------------
*/

$(document).on(
    'click',
    '.btnDelete',
    function () {

        const button =
            $(this);

        /*
        |--------------------------------------------------------------------------
        | Jangan hapus Dropoff
        |--------------------------------------------------------------------------
        */

        if (button.prop('disabled')) {

            return;

        }


        const row =
            button.closest('tr');


        const activity =
            row.find('.activity-type').val();


        if (activity === 'DROPOFF') {

            return;

        }


        row.remove();


        resetRoute();

    }
);


/*
|--------------------------------------------------------------------------
| Shipment Type
|--------------------------------------------------------------------------
|
| Pada Edit shipment type disabled.
| Jadi event change sebenarnya tidak diperlukan,
| tetapi function ini tetap aman jika nanti field di-enable.
|
|--------------------------------------------------------------------------
*/

$('[name="shipment_type"]').on(
    'change',
    function () {

        resetRoute();

    }
);


/*
|--------------------------------------------------------------------------
| Initialize Existing Shipment
|--------------------------------------------------------------------------
|
| PENTING:
|
| Jangan generateRoute() di sini.
|
| Karena route sudah berasal dari database.
|
|--------------------------------------------------------------------------
*/

$(function () {
    /*
    |--------------------------------------------------------------------------
    | Select2 Header
    |--------------------------------------------------------------------------
    */
    $('.select2-show-search').select2({
        width: '100%'
    });
    /*
    |--------------------------------------------------------------------------
    | Initialize Existing Rows
    |--------------------------------------------------------------------------
    */
    initRow(
        $('#routeTable')
    );
    /*
    |--------------------------------------------------------------------------
    | Apply Existing Shipment Rule
    |--------------------------------------------------------------------------
    */
    resetRoute();
    /*
    |--------------------------------------------------------------------------
    | Button Add Route
    |--------------------------------------------------------------------------
    */
    const shipmentType =
        $('[name="shipment_type"]').val();
    const rule =
        ShipmentRule[shipmentType];
    if (rule && rule.allowAdd) {

        $('#btnAddRoute')
            .show()
            .html(
                '<i class="fa fa-plus"></i> Add Pickup'
            );
    } else {
        $('#btnAddRoute').hide();
    }

});
/*
|--------------------------------------------------------------------------
| Submit Edit Shipment
|--------------------------------------------------------------------------
*/
$('#shipmentForm').on(
    'submit',
    function (e) {
        e.preventDefault();

        resetRoute();

        const formData =
            $(this).serialize();
        Swal.fire({
            title: 'Please Wait...',

            allowOutsideClick: false,

            didOpen: () => {

                Swal.showLoading();

            }

        });


        $.ajax({

            url: "<?= base_url('/shipment/updateCollection/'.$shipment['shipment_id']); ?>",

            type: 'POST',

            data: formData,

            dataType: 'json',

            success: function (response) {

                console.log('=== UPDATE SHIPMENT RESPONSE ===');
                console.log(response);
                console.log('status:', response.status);
                console.log('message:', response.message);

                if (response.status === true) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {

                        window.location.href =
                            "<?= base_url('/Shipment'); ?>";

                    });

                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation',
                        text: response.message || 'Validation failed.'
                    });

                }

            },

            error: function(xhr) {

            console.log('HTTP ERROR:', xhr.status);
            console.log('RAW RESPONSE:', xhr.responseText);

            let message = 'Internal Server Error';

            /*
            * Coba ambil JSON dari response
            */
            if (xhr.responseJSON) {

                message =
                    xhr.responseJSON.message ||
                    message;

            } else {

                /*
                * Jika response berupa string JSON
                */
                try {

                    const response =
                        JSON.parse(xhr.responseText);

                    message =
                        response.message ||
                        message;

                } catch (e) {

                    console.error(
                        'Response bukan JSON:',
                        xhr.responseText
                    );

                }

            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });

        }

        });
    }
);

</script>
