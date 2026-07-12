<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->


<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/pointaccumulation">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="mb-0 card-title">CREATE POINT ACCUMULATION</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-nowrap w-100">
                                <tbody>
                                    <tr>
                                        <th width="300px" style="color: white;">MEMBER FULL NAME</th>
                                        <td>&nbsp;<?php echo $views->first_name.''.$views->last_name; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ITEM NAME</th>
                                        <td>&nbsp;<?php echo $views->item; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">CODE/SN/QRCODE</th>
                                        <td>&nbsp;<?php echo $views->code; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">CLAIM DATE</th>
                                        <td>&nbsp;<?php echo $views->claim_date; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">INVOICE NUMBER</th>
                                        <td>&nbsp;<?php echo $views->invoice_number; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">INVOICE DATE</th>
                                        <td>&nbsp;<?php echo $views->invoice_date; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">REVENUE</th>
                                        <td>&nbsp;<?php echo number_format($views->revenue, 0, ',', '.'); ?></td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">QUANTITY</th>
                                        <td>&nbsp;<?php echo $views->quantity; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">POINT</th>
                                        <td>&nbsp;<?php echo $views->unit_point; ?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <th width="300px" style="color: white;">APPROVED</th>
                                        <td>&nbsp;<?php // echo $views->approved ? 'Approved' : 'Invalid'; ?>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <th width="300px" style="color: white;">CREATED DATE</th>
                                        <td>&nbsp;<?php echo $views->created_date; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <a href="<?= base_url() ?>/Pointaccumulation" type="button" class="btn btn-warning"><i
                                class="fa fa-arrow-left mr-2"></i>Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->