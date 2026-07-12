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
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
                <h1 class="page-title">Data Warehose</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/Warehouse/create" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> Create New
                </a>
            </div>
        </div>

        <!-- PAGE-HEADER END -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTbls" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Warehouse Code</th>
                                        <th>Warehouse Name</th>
                                        <th>Address</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Created Date</th>
                                        <th>Action</th>
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
        <div class="modal fade" id="modalDetailWareHouse" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-teal">
                        <h5 class="modal-title text-white">
                            <i class="fa fa-building mr-2"></i>
                            Warehose
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

                        <div id="detailWareContent"></div>

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


<script>

$(function () {

    $('#dataTbls').DataTable({

        processing: true,
        serverSide: true,

        ajax: {
            url: '<?= base_url() ?>/warehouse/datatables',
            type: 'POST'
        },

        columns: [
            {
                data: 'no',
                orderable: false
            },
            {
                data: 'warehouse_code'
            },
            {
                data: 'warehouse_name'
            },
            {
                data: 'address'
            },
            {
                data: 'status'
            },
            {
                data: 'created_date'
            },
            {
                data: 'action',
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

    $("#modalDetailWareHouse").modal("show");

    $.ajax({
        url: "<?= base_url('/warehouse/detail')?>/" + id,
        type: "GET",
        success: function(response){

            $("#loadingDetail").hide();
            $("#detailWareContent").html(response);

        },
        error:function(){

            $("#loadingDetail").hide();

            $("#detailWareContent").html(`
                <div class="alert alert-danger">
                    Failed to load company detail.
                </div>
            `);

        }
    });

});

</script>