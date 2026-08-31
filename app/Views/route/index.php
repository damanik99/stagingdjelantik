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
<!--app-content open-->
<div class="app-content">
    <div class="side-app"> <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Route</li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?= base_url() ?>Route/create" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> New Create
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
                            <table id="dataTbls"
                                class="table table-striped table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">Group</th>
                                        <th class="wd-15p">Page</th>
                                        <th class="wd-15p">Actions</th>
                                        <th class="wd-15p">Group Plan</th>
                                        <th class="wd-25p">Action</th>
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
        <!-- ROW-4 CLOSED-->
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

<script type="text/javascript">
    $(function(e) {
        $('#dataTbls').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url() ?>route/datatables", // endpoint backend
                type: 'POST'
            },
            "order": [
                [0, 'desc']
            ],
            columns: [{
                    data: 'group'
                },
                {
                    data: 'page'
                },
                {
                    data: 'actions'
                },
                {
                    data: 'groupplan'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>