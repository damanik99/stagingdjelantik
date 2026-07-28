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

<style>

.btn-defaultsx {
    color: #242e4c;
    background: #e9e9e9;
    border-color: #ebedfc;
    box-shadow: none;
}

.page-headersxd {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  margin: 0.5rem 0rem;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 0;
  border-radius: 7px;
  position: relative;
  min-height: 50px;
}

</style>

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->

<?php /** @var string $title */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">

        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shipment</li>
                </ol>
            </div>
        </div>

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div class="mr">
                <a href="#" class="btn btn-radius btn-defaultsx mr-2">
                    <span>
                        <i class="fa fa-cubes mr-2"></i>
                    </span> Collection
                </a>
            </div>
            <div class="mr">
                <a href="<?=base_url()?>ShipmentInbound/index" class="btn btn-radius btn-default mr-2">
                    <span>
                        <i class="fa fa-truck mr-2"></i>
                    </span> Inbound
                </a>
            </div>
            <div class="mr">
                <a href="<?=base_url()?>Organization/pkkindex" class="btn btn-radius btn-default mr-2">
                    <span>
                        <wa-icon name="truck-fast"></wa-icon>
                        <i class="mr-2"></i>
                    </span> Outbound
                </a>
            </div>
            <div class="mr-auto">
                <a href="<?=base_url()?>Organization/pkkindex" class="btn btn-radius btn-default mr-2">
                    <span>
                        <wa-icon name="arrow-right-arrow-left"></wa-icon>
                        <i class="mr-2"></i>
                    </span> Transfer
                </a>
            </div>
        </div>

        <div class="page-headersxd">
            <div>
                <h1 class="page-title">Data Shipment Type Collection</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>Shipment/collectionCreate" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> New Create
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="shipmentTable" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                 <thead>
                                    <tr>
                                        <th>Shipment No</th>
                                        <th>Driver</th>
                                        <th>Vehicle</th>
                                        <th class="text-center">Stop</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th width="120">Action</th>
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
    
        ajax: {
            url: "<?= base_url('shipment/datatables') ?>",
            type: "POST"
        },
    
        columns: [
            { data: 'shipment_number' },
            { data: 'driver_name' },
            { data: 'plate_number' },
            {
                data: 'total_stop',
                className: 'text-center'
            },
            { data: 'status_badge' },
            { data: 'created_date' },
            { data: 'action' }
        ],
        columnDefs: [
            {
                targets: [4, 6],
                orderable: false
            }
        ]
    });
});

$(document).on('click', '.btnDetail', function () {

    let id = $(this).data('id');

    $("#detailShipment").html("");
    $("#loadingDetail").show();

    $("#modalDetailShpment").modal("show");

    $.ajax({
        url: "<?= base_url('shipment/detail')?>/" + id,
        type: "GET",
        success: function(response){

            $("#loadingDetail").hide();
            $("#detailShipment").html(response);

        },
        error:function(){

            $("#loadingDetail").hide();

            $("#detailShipment").html(`
                <div class="alert alert-danger">
                    Failed to load shipment detail.
                </div>
            `);

        }
    });

});

// check status to page edit shipment collection
const base_url = "<?= base_url(); ?>";

$(document).on('click', '.btn-edit-shipment', function () {

    let id = $(this).data('id');
    let url = $(this).data('url');
console.log(id);
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
        url: base_url + 'shipment/checkEditAccess/' + id, 
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            if (response.success) {
                window.location.href = "<?= base_url('/shipment/edit')?>/" + id;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Shipment Status Not "Siap Jalan"',
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