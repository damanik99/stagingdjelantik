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
                <h1 class="page-title">
                    <?//=$title?>
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>/productcode/index">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/ProductCode/create" class="btn btn-primary btn-icon text-white">
                    <span>
                        <i class="fe fe-plus"></i>
                    </span> CREATE
                </a>
                <a href="<?=base_url()?>/ProductCode/upload" class="btn btn-success btn-icon text-white mr-2">
                    <span>
                        <i class="fa fa-upload"></i>
                    </span>UPLOAD
                </a>
            </div>
        </div>
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create new data product code, klik
            button<i class="fe fe-plus"></i> create.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create some new data product code,
            klik
            button <i class="fa fa-upload"></i> upload.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Update data in table column "action",
            klick button
            <i class="fa fa-pencil"></i> (icon pencil).<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>View detail data in table column
            "action", klik
            button <i class="fa fa-eye"></i> (icon eye).<br>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">DATA PRODUCT CODE</h3>
                    </div>
                    <div class="card-body">
                        <?= session()->getFlashdata('message'); ?>
                        <div class="table-responsive">
                            <table id="dataTbls" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>ITEM NAME</th>
                                        <th>CODE</th>
                                        <th>STATUS</th>
                                        <th>CREATED DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                                        if(!empty($dataPC))
                                                        {
                                                            for($a=0 ; $a<count($dataPC) ; $a++)
                                                            { 
                                                                $id = $dataPC[$a]['product_code_id'];
                                                    ?>
                                        <td><?=$dataPC[$a]['item_name']?></td>
                                        <td><?=$dataPC[$a]['code']?></td>
                                        <td><?=$dataPC[$a]['status'] ? 'Active' : 'Inactive'; ?></td>
                                        <td><?=$dataPC[$a]['created_date'] ?></td>
                                        <td>
                                            <a href="<?=base_url()?>/ProductCode/edit/<?=$id?>"
                                                class="badge badge-pill badge-success" title="Edit"><i
                                                    class="fa fa-pencil"></i></a>
                                            <a href="<?=base_url()?>/ProductCode/view/<?=$id?>"
                                                class="badge badge-pill badge-primary" title="view"><i
                                                    class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr>
                                        <td colspan="5"><b>Tidak ada data product code di temukan...</b>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>

<script type="text/javascript">
$(function(e) {
    //Export Data-table
    var table = $("#dataTbls").DataTable({
        lengthChange: false,
        order: [
            [3, "desc"]
        ],
        // buttons: ["copy", "excel", "pdf", "colvis"],
    });
});
</script>