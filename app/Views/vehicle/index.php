<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css"
    rel="stylesheet" />
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
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
                <h1 class="page-title">Data Vehicle</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/Vehicle/create" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> Create New
                </a>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="vehicleTable" class="table table-striped table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Plate Number</th>
                                        <th>Vehicle Type</th>
                                        <th>Mer</th>
                                        <th>Capacity Weight</th>
                                        <th >Status</th>
                                        <th>Created Date</th>
                                        <th width="120">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalDetailVehicle" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-teal">
                        <h5 class="modal-title text-white">
                            <i class="fa fa-truck mr-2"></i>
                            Vehicle
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

                        <div id="detailVehicleContent"></div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<!-- CONTAINER END -->
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function () {

        $('#vehicleTable').DataTable({
            processing: true,
            serverSide: true,
            // responsive: true,
            // autoWidth: false,

            ajax: {
                url: "<?= base_url('/vehicle/datatables') ?>",
                type: "POST"
            },

            "order": [
                [0, 'desc']
            ],

            columns: [
                { data: "company_name" },
                { data: "plate_number" },
                { data: "vehicle_type" },
                { data: "brand" },
                { data: "capacity_weight" },
                { data: "status_badge" },
                { data: "created_date" },
                { 
                    data: "action",
                    orderable: false,
                    searchable: false
                }
            ]
        });

    });

$(document).on('click', '.btnDetail', function () {

    let id = $(this).data('id');

    $("#detailCompanyContent").html("");
    $("#loadingDetail").show();

    $("#modalDetailVehicle").modal("show");

    $.ajax({
        url: "<?= base_url('/Vehicle/detail')?>/" + id,
        type: "GET",
        success: function(response){

            $("#loadingDetail").hide();
            $("#detailVehicleContent").html(response);

        },
        error:function(){

            $("#loadingDetail").hide();

            $("#detailCompanyContent").html(`
                <div class="alert alert-danger">
                    Failed to load company detail.
                </div>
            `);

        }
    });

});
</script>