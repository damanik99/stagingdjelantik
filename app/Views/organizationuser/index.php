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
                    <li class="breadcrumb-item active" aria-current="page">Users Organization</li>
                </ol>
            </div>
        </div>
        <div class="page-headersxd">
            <div>
                <h1 class="page-title">Data Users Organization</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?= base_url() ?>OrganizationUser/upload" class="btn btn-primary-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-upload mr-2"></i>
                    </span> Upload
                </a>
                <a href="<?= base_url() ?>OrganizationUser/create" class="btn btn-success-light btn-icon mr-2">
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
                                        <th>Organization Name</th>
                                        <th>Program Name</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th class="text-center">Phone</th>
                                        <th>Email</th>
                                        <th>status_badge</th>
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
        <div class="modal fade" id="modalDetailOrgzUsr" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-teal">
                        <h5 class="modal-title text-white">
                            Users Organization
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

                        <div id="detailOrgzUsr"></div>
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
    $(document).ready(function() {

        $('#shipmentTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,

            ajax: {
                url: "<?= base_url('organizationuser/datatables') ?>",
                type: "POST"
            },
            "order": [
                [0, 'desc']
            ],

            columns: [{
                    data: 'organization_name'
                },
                {
                    data: 'name'
                },
                {
                    data: 'username'
                },
                {
                    data: 'fullname'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'email'
                },
                {
                    data: 'status_badge'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                targets: [4, 7],
                orderable: false
            }]
        });
    });

    $(document).on('click', '.btnDetail', function() {

        let id = $(this).data('id');

        $("#detailOrgzUsr").html("");
        $("#loadingDetail").show();

        $("#modalDetailOrgzUsr").modal("show");

        $.ajax({
            url: "<?= base_url('organizationuser/detail') ?>/" + id,
            type: "GET",
            success: function(response) {

                $("#loadingDetail").hide();
                $("#detailOrgzUsr").html(response);

            },
            error: function() {

                $("#loadingDetail").hide();

                $("#detailOrgzUsr").html(`
                <div class="alert alert-danger">
                    Failed to load company detail.
                </div>
            `);

            }
        });

    });
</script>