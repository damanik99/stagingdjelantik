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
    <div class="side-app">        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Privilege</li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/privilege/create" class="btn btn-primary btn-icon text-white mr-2">
                    <span>
                        <i class="fe fe-plus"></i>
                    </span> CREATE
                </a>
            </div>
        </div>
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create new data item, click
            button<i class="fe fe-plus"></i> create.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create some new data item, click
            button <i class="fa fa-upload"></i> upload.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Download All data item, click
            button <i class="fa fa-download"></i> download.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Update data in table column "action",
            click button
            <i class="fa fa-pencil"></i> (icon pencil).<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>View detail data in table column
            "action", click
            button <i class="fa fa-eye"></i> (icon eye).<br>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">DATA ITEM</h3>
                    </div>
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
            url: "<?= base_url() ?>/privilege/datatables", // endpoint backend
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