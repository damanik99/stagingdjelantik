<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
 <!--- FONT-ICONS CSS -->
<link href="<?= base_url() ?>/teamplate/assets/css/icons.css" rel="stylesheet"/>
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
  -ms-flex-wrap: wrap;
  justify-content: space-between;
  padding: 0;
  border-radius: 7px;
  position: relative;
  min-height: 50px;
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
                    <li class="breadcrumb-item active" aria-current="page">Organization</li>
                </ol>
                <!-- <h1 class="page-title">Data Organization</h1> -->
            </div>
            <!-- <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/Organization/create" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> Create New
                </a>
            </div> -->
        </div>

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div class="mr">
                <a href="<?=base_url()?>/Organization/create" class="btn btn-radius btn-defaultsx mr-2">
                    <span>
                        <i class="fa fa-truck mr-2"></i>
                    </span> Supplier
                </a>
            </div>
            <div class="mr">
                <a href="<?=base_url()?>/Organization/create" class="btn btn-radius btn-default mr-2">
                    <span>
                        <i class="fa fa-industry mr-2"></i>
                    </span> Buyer
                </a>
            </div>
            <div class="mr-auto">
                <a href="<?=base_url()?>/Organization/create" class="btn btn-radius btn-default mr-2">
                    <span>
                        <i class="fa fa-solid fa-users mr-2"></i>
                    </span> PKK
                </a>
            </div>
        </div>

        <!-- PAGE-HEADER -->
        <div class="page-headersxd">
            <div>
                <h1 class="page-title">Data Supplier</h1>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/Organization/create" class="btn btn-success-light btn-icon mr-2">
                    <span>
                        <i class="fa fa-plus mr-2"></i>
                    </span> Create New
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="companyTable" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Pic Name</th>
                                        <th>State</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Picture</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
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
        <div class="modal fade" id="modalDetailOrgz" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-teal">
                        <h5 class="modal-title text-white">
                            <i class="fa fa-building mr-2"></i>
                            Organization Detail
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

                        <div id="detailOrgzContent"></div>

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
    
</script>