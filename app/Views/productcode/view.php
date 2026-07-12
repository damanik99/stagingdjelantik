<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->


<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->
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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/productcode">index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Code Information</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title"><i class="fa fa-info-circle"></i> PRODUCT CODE INFORMATION
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-nowrap w-100">
                                <tbody>
                                    <tr>
                                        <th width="300px" style="color: white;">ITEM NAME</th>
                                        <td>&nbsp;<?php echo $views[0]['item_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">CODE</th>
                                        <td>&nbsp;<?php echo $views[0]['code']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">STATUS</th>
                                        <td>&nbsp;<?php echo $views[0]['status'] ? 'Active' : 'Inactive'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">CREATED DATE</th>
                                        <td>&nbsp;<?php echo $views[0]['created_date']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">MODIFIED DATE</th>
                                        <td>&nbsp;<?php echo $views[0]['modified_date']; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="<?= base_url() ?>/ProductCode" type="button" class="btn btn-warning"><i
                                class="fa fa-arrow-left mr-2"></i>Back</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>
</div>

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->