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

<?php /** @var array<string, mixed> $view */ ?>

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
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/QualityControl/create" class="btn btn-primary btn-icon text-white mr-2">
                    <span>
                        <i class="fe fe-plus"></i>
                    </span> Create New
                </a>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white">DATA QUALITY CONTROL</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableQc" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <tbody>
                                    <tr>
                                        <th width="300px">Shipment Number</th>
                                        <td><?= $view['shipment_number'] ?></td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Company Name</th>
                                        <td><?= $view['company_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Company Name</th>
                                        <td><?= $view['company_name'] ?></td>
                                    </tr>
                                </tbody>
                                <tbody>
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