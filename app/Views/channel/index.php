<!-- MAIN -->
<?php echo $this->include('layout/main'); ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?php echo base_url(); ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css"
    rel="stylesheet" />
<style>
td.channel-address {
    white-space: normal !important;
    word-wrap: break-word;
    max-width: 200px;
}
</style>
<!-- CSS END -->

<!-- MAIN -->
<?php echo $this->include('layout/body'); ?>
<!-- MAIN END -->

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title"></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Channel</li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <?php //if ($low == 'high') {?>
                <a href="<?php echo base_url(); ?>/channel/add" class="btn btn-primary btn-icon text-white mr-2">
                    <span>
                        <i class="fe fe-plus"></i>
                    </span> CREATE
                </a>
                <a href="<?php echo base_url(); ?>/channel/upload" class="btn btn-success btn-icon text-white mr-2">
                    <span>
                        <i class="fa fa-upload"></i>
                    </span> UPLOAD
                </a>
                <a href="<?php echo base_url(); ?>/channel/report" class="btn btn-cyan btn-icon text-white mr-2">
                    <span>
                        <i class="fa fa-download"></i>
                    </span> DOWNLOAD
                </a>
                <?php //}?>
            </div>
        </div>
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create new data channel, click
            button<i class="fe fe-plus"></i> create.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create some new data channel, click
            button <i class="fa fa-upload"></i> upload.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Download All data channel, click
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
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="card-title">DATA CHANNEL</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTbls" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">CHANNEL CODE</th>
                                        <th class="wd-15p">CHANNEL NAME</th>
                                        <th class="wd-20p">CHANNEL ADDRESS</th>
                                        <th class="wd-15p">CITY</th>
                                        <th class="wd-15p">CREATED DATE</th>
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
        <!-- ROW-CLOSED-->
    </div>
</div>

<!-- FOOTER -->
<?php echo $this->include('layout/footers'); ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?php echo base_url(); ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>

<script>
$(function(e) {
    $('#dataTbls').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url(); ?>/channel/datatables", // endpoint backend
            type: 'POST'
        },
        columns: [{
                data: 'channel_code'
            },
            {
                data: 'channel_name'
            },
            {
                data: 'channel_address',
                className: 'channel-address'
            },
            {
                data: 'channel_city'
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
</script>
