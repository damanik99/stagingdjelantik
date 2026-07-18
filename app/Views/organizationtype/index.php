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
                <h1 class="page-title">
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Organization Type</li>
                </ol>
                <h1 class="page-title">Data Organization Type</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/companytype/create" class="btn btn-success-light btn-icon mr-2">
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
                                        <th>TYPE CODE</th>
                                        <th>TYPE NAME</th>
                                        <th>DESCRIPTION</th>
                                        <th width="10%">STATUS</th>
                                        <th width="20%">CREATED DATE</th>
                                        <th width="10%">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php 
                                            if (!empty($organizationType)) 
                                            {
                                                foreach ($organizationType as $row) {
                                                    $id = $row['organization_type_id'];
                                                ?>
                                    <tr>
                                            <td><?= $row['type_code'] ?></td>
                                            <td><?= $row['type_name'] ?></td>
                                            <td><?= $row['description'] ?></td>
                                            <td><?= $row['status'] ?></td>
                                            <td><?= $row['created_date'] ?></td>
                                            <td>
                                                <a href="<?=base_url()?>/OrganizationType/edit/<?=$id?>"
                                                    class="badge badge-pill badge-success" title="Edit"><i
                                                        class="fa fa-pencil"></i></a>
                                                <a href="<?=base_url()?>/OrganizationType/view/<?=$id?>"
                                                    class="badge badge-pill badge-primary" title="view"><i
                                                        class="fa fa-eye"></i></a>
                                            </td>
                                               <?php } ?>
                                               
                                    </tr>
                                    <?php } else { ?>
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
    </div>
</div>

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>
