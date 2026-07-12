<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />
<!-- CSS END -->

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->

<!--app-content open-->
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title"><?=$title?></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/pointaccumulation/create" class="btn btn-primary btn-icon text-white mr-2">
                    <span>
                        <i class="fe fe-plus"></i>
                    </span> CREATE
                </a>
                <a href="<?=base_url()?>/pointaccumulation/upload" class="btn btn-success btn-icon text-white mr-2">
                    <span>
                        <i class="fa fa-upload"></i>
                    </span>UPLOAD
                </a>
            </div>
        </div>
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create new data Point Accumulation, click
            button<i class="fe fe-plus"></i> create.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create some new data member, click
            button <i class="fa fa-upload"></i> upload and download teamplate upload<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Update data in table column "action",
            click button
            <i class="fa fa-pencil"></i> (icon pencil). <br>
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
                        <h3 class="card-title">DATA POINT ACCUMULATION</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTbls" class="table table-striped table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>MEMBER NAME</th>
                                        <th>SN/CODE NUMBER</th>
                                        <th>ITEM NAME</th>
                                        <th>INVOICE NUMBER</th>
                                        <th>INVOICE DATE</th>
                                        <th>CREATED DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (!empty($dataTable)) 
                                        {
                                            for ($i=0; $i < count($dataTable); $i++) { 
                                                $id = $dataTable[$i]['point_accumulation_id'];
                                                ?>
                                    <tr>
                                        <td><?=$dataTable[$i]['first_name']?></td>
                                        <td><?=$dataTable[$i]['code']?></td>
                                        <td><?=$dataTable[$i]['item']?></td>
                                        <td><?=$dataTable[$i]['invoice_number']?></td>
                                        <td><?=$dataTable[$i]['invoice_date']?></td>
                                        <td><?=$dataTable[$i]['created_date']?></td>
                                        <td>
                                            <a href="<?=base_url()?>/pointaccumulation/edit/<?=$id?>"
                                                class="badge badge-pill badge-success" title="Edit"><i
                                                    class="fa fa-pencil"></i></a>
                                            <a href="<?=base_url()?>/pointaccumulation/view/<?=$id?>"
                                                class="badge badge-pill badge-primary" title="view"><i
                                                    class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                            } 
                                        ?>
                                    <?php
                                        } else { 

                                    ?>
                                    <td colspan="5"><b>Claim data not Found...</b></td>
                                    <?php
                                        }
                                    ?>
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

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/datatable.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>

<script>
$(function(e) {
    //Export Data-table
    var table = $("#dataTbls").DataTable({
        lengthChange: false,
        order: [
            [6, "desc"]
        ],
        // buttons: ["copy", "excel", "pdf", "colvis"],
    });
});
</script>