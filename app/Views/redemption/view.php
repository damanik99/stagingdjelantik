<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<style>
th {
    color: black;
}

required {
    color: red;
}

/* tr.odd {
        background: #E5F1F4;
    } */
</style>

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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/supplier">INDEX</a></li>
                    <li class="breadcrumb-item active" aria-current="page">REDEMPTION <?=$title?></li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title"><i class="fa fa-info-circle"></i> SUPPLIER <?=$title?></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-nowrap w-100">
                                <tbody>
                                    <tr>
                                        <th width="300px" style="color: white;">TRACKING NUMBER</th>
                                        <td>&nbsp;<?php echo $views['tracking_number']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">REDEMPTION CODE</th>
                                        <td>&nbsp;<?php echo $views['redemption_code']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">STATUS</th>
                                        <td>&nbsp;<?php echo $views['status_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">MEMBER NAME</th>
                                        <td>&nbsp;<?php echo $views['member_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">COMPANY</th>
                                        <td>&nbsp;<?php echo $views['company_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ADDRESS</th>
                                        <td>&nbsp;<?php echo $views['domicile_address']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">CITY</th>
                                        <td>&nbsp;<?php echo $views['city']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ITEM SKU</th>
                                        <td>&nbsp;<?php echo $views['sku']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ITEM NAME</th>
                                        <td>&nbsp;<?php echo $views['item_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">APPROVED</th>
                                        <td>&nbsp;<?php echo $views['approved']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">QUANTITY REDEEM</th>
                                        <td>&nbsp;<?php echo $views['quantity']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">POINT REDEEM</th>
                                        <td>&nbsp;<?php echo $views['point_redemp']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">RECEPIENT</th>
                                        <td>&nbsp;<?php echo $views['recipient_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">COURIER</th>
                                        <td>&nbsp;<?php echo $views['courier']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">DELIVERY ORDER</th>
                                        <td>&nbsp;<?php echo $views['noref']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">RECEIVE BY</th>
                                        <td>&nbsp;<?php echo $views['receive_by']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">POD</th>
                                        <td>&nbsp;<?php echo $views['pod']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">NOTE 1</th>
                                        <td>&nbsp;<?php echo $views['note1']; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="<?= base_url() ?>/Redemption" type="button" class="btn btn-warning"><i
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