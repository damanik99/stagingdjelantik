<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<style>
th {
    color: white;
    width: 300px;
}
</style>
<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

<?php /** @var array<string, mixed> $detail */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title"></h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>/warehouse">
                            Warehouse
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Detail
                    </li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">
                            <i class="fa fa-info-circle"></i>
                            WAREHOUSE DETAIL
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>COMPANY NAME</th>
                                        <td><?= $detail['company_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>COMPANY TYPE</th>
                                        <td><?= $detail['type_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>PIC NAME</th>
                                        <td>
                                            <?= !empty($detail['pic_name']) ? $detail['pic_name'] : '<i>empty</i>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>PHONE</th>
                                        <td>
                                            <?= !empty($detail['phone']) ? $detail['phone'] : '<i>empty</i>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>EMAIL</th>
                                        <td>
                                            <?= !empty($detail['email']) ? $detail['email'] : '<i>empty</i>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>STATUS</th>
                                        <td>
                                            <?= !empty($detail['status_name']) ? $detail['status_name'] : '<i>empty</i>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ADDRESS</th>
                                        <td>
                                            <?= !empty($detail['address']) ? $detail['address'] : '<i>empty</i>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>LATITUDE</th>
                                        <td>
                                            <?= !empty($detail['latitude']) ? $detail['latitude'] : '<i>empty</i>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>LONGITUDE</th>
                                        <td>
                                            <?= !empty($detail['longitude']) ? $detail['longitude'] : '<i>empty</i>'; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php if(
                            !empty($views['latitude']) &&
                            !empty($views['longitude'])
                        ){ ?>
                        <div class="mt-4">
                            <a href="https://www.google.com/maps?q=<?= $views['latitude'] ?>,<?= $views['longitude'] ?>"
                                target="_blank"
                                class="btn btn-info">

                                <i class="fa fa-map-marker"></i>
                                Open Google Maps
                            </a>
                        </div>
                        <?php } ?>

                        <hr>
                        <a href="<?= base_url() ?>/Company"
                            class="btn btn-warning">

                            <i class="fa fa-arrow-left mr-2"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW END -->
    </div>
</div>

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>