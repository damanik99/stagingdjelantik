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
<style>
/* Memastikan teks pada kolom message dibungkus dan tidak memanjang */
table td {
    word-wrap: break-word;
    /* Memungkinkan teks panjang untuk terputus dan membungkus ke baris baru */
}

table td.message-column {
    word-wrap: break-word;
    white-space: normal;
}
</style>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Module Update</li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/ModuleUpdate/create" class="btn btn-primary btn-icon text-white mr-2">
                    <span>
                        <i class="fe fe-plus"></i>
                    </span> CREATE
                </a>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">DATA MODULE UPDATE</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTbls" class="table table-striped table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">Type</th>
                                        <th class="wd-15p">Message</th>
                                        <th class="wd-15p">Created Date</th>
                                        <th class="wd-25p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($moduleUpdate as $row) : ?>
                                    <tr>
                                        <td><?= $row['type'] ?></td>
                                        <td class="message-column"><?= $row['message'] ?></td>
                                        <td><?= $row['created_date'] ?></td>
                                        <td>
                                            <a href="<?=base_url()?>/ModuleUpdate/edit/<?= $row['module_updates_id'] ?>"
                                                class="badge badge-pill badge-success" title="Edit"><i
                                                    class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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