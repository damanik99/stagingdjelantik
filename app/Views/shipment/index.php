<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />
<!-- INTERNAL  TABS STYLES -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/tabs/tabs.css" rel="stylesheet" />
<!-- CSS END -->

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->

<?php /** @var string $title */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
                <h1 class="page-title">Data Shipment</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/Shipment/create" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> New Create
                </a>
            </div>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="shipmentTable" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SHIPMENT NO</th>
                                        <th>SUPPLIER</th>
                                        <th>BUYER</th>
                                        <th>DRIVER</th>
                                        <th>VEHICLE</th>
                                        <th>STATUS</th>
                                        <th>CREATED DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalDetailShpment" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-teal">
                        <h5 class="modal-title text-white">
                            <i class="fa fa-truck mr-2"></i>
                            Shipment
                        </h5>

                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center py-5" id="loadingDetail">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <br>
                            Loading...
                        </div>

                        <div id="detailShipment"></div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>
<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    $('#shipmentTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        order: [[6, 'desc']],

        ajax: {
            url: "<?= base_url('/shipment/datatables'); ?>",
            type: "POST"
        },

        columns: [
            { data: 'shipment_number' },
            { data: 'supplier_name' },
            { data: 'buyer_name' },
            { data: 'driver_name' },
            { data: 'plate_number' },
            { data: 'status_badge' },
            { data: 'created_date' },
            { data: 'action' }
        ],

        columnDefs: [
            {
                targets: [5,7],
                orderable: false
            }
        ],

        createdRow: function(row, data, dataIndex) {

            $('td:eq(5)', row).html(data.status_badge);
            $('td:eq(7)', row).html(data.action);

        }
    });

});

$(document).on('click', '.btnDetail', function () {

    let id = $(this).data('id');

    $("#detailShipment").html("");
    $("#loadingDetail").show();

    $("#modalDetailShpment").modal("show");

    $.ajax({
        url: "<?= base_url('/shipment/detailShipment')?>/" + id,
        type: "GET",
        success: function(response){

            $("#loadingDetail").hide();
            $("#detailShipment").html(response);

        },
        error:function(){

            $("#loadingDetail").hide();

            $("#detailShipment").html(`
                <div class="alert alert-danger">
                    Failed to load company detail.
                </div>
            `);

        }
    });

});

const base_url = "<?= base_url(); ?>";

$(document).on('click', '.btn-edit-shipment', function () {

    let id = $(this).data('id');
    let url = $(this).data('url');

    Swal.fire({
        title: 'Please wait...',
        text: 'Checking shipment access.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: base_url + '/shipment/checkEditAccess/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            if (response.success) {
                window.location.href = "<?= base_url('/shipment/edit')?>/" + id;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Shipment Status "Berhasil"',
                    text: 'Unable to access the shipment edit page.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function () {
            
            Swal.close();

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred.'
            });
        }
    });

});
</script>