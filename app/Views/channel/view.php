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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/supplier">View</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Information</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title"><i class="fa fa-info-circle"></i> CHANNEL <?=$title?></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-nowrap w-100">
                                <tbody>
                                    <tr>
                                        <th width="300px" style="color: white;">CODE</th>
                                        <td>&nbsp;<?php echo $views['channel_code']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">NAME</th>
                                        <td>&nbsp;<?php echo $views['channel_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">IS MANAGED</th>
                                        <td>&nbsp;<?php echo $views['managed']; ?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                                    <th width="300px" style="color: white;">MEMBER OF</th>
                                                    <td>&nbsp;<?php // echo $views['member_of']; ?>
                                                    </td>
                                                </tr> -->
                                    <tr>
                                        <th width="300px" style="color: white;">TYPE</th>
                                        <td>&nbsp;<?php echo $views['type']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">OWNERSHIP</th>
                                        <td>&nbsp;<?php echo $views['ownership']; ?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                                    <th width="300px" style="color: white;">OPEN SINCE</th>
                                                    <td>&nbsp;<?php // echo $views['open_since']; ?>
                                                    </td>
                                                </tr> -->
                                    <!-- <tr>
                                                    <th width="300px" style="color: white;">SIZE</th>
                                                    <td>&nbsp;<?php // echo $views['size']; ?>
                                                    </td>
                                                </tr> -->
                                    <tr>
                                        <th width="300px" style="color: white;">PHONE</th>
                                        <td>&nbsp;<?php echo $views['phone']; ?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                                    <th width="300px" style="color: white;">FAX</th>
                                                    <td>&nbsp;<?php // echo $views['fax']; ?>
                                                    </td>
                                                </tr> -->
                                    <tr>
                                        <th width="300px" style="color: white;">EMAIL</th>
                                        <td>&nbsp;<?php echo $views['email']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">WEBSITE</th>
                                        <td>&nbsp;<?php echo $views['website']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ADDRESS</th>
                                        <td>&nbsp;<?php echo $views['address']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">BUILDING NAME</th>
                                        <td>&nbsp;<?php echo $views['building_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">FLOOR NUMBER</th>
                                        <td>&nbsp;<?php echo $views['floor_number']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">STREET NAME</th>
                                        <td>&nbsp;<?php echo $views['street_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">STREET NUMBER</th>
                                        <td>&nbsp;<?php echo $views['street_number']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">COUNTRY</th>
                                        <td>&nbsp;<?php echo $views['country']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">STATE</th>
                                        <td>&nbsp;<?php echo $views['state']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">CITY</th>
                                        <td>&nbsp;<?php echo $views['city']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ZONE</th>
                                        <td>&nbsp;<?php echo $views['zone']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">POSTAL CODE</th>
                                        <td>&nbsp;<?php echo $views['post_code']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">OWNER NAME</th>
                                        <td>&nbsp;<?php echo $views['owner_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">OWNER PHONE</th>
                                        <td>&nbsp;<?php echo $views['owner_phone']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">CONTACT EMAIL</th>
                                        <td>&nbsp;<?php echo $views['contact_email']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">TAX NUMBER</th>
                                        <td>&nbsp;<?php echo $views['tax_number']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">TAX NAME</th>
                                        <td>&nbsp;<?php echo $views['tax_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ACCOUNT BANK</th>
                                        <td>&nbsp;<?php echo $views['account_bank']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ACCOUNT NUMBER</th>
                                        <td>&nbsp;<?php echo $views['account_number']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">ACCOUNT NAME</th>
                                        <td>&nbsp;<?php echo $views['account_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">DESCRIPTION</th>
                                        <td>&nbsp;<?php echo $views['description']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">NOTE 1</th>
                                        <td>&nbsp;<?php echo $views['note1']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">NOTE 2</th>
                                        <td>&nbsp;<?php echo $views['note2']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px" style="color: white;">NOTE 3</th>
                                        <td>&nbsp;<?php echo $views['note3']; ?>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <a href="<?= base_url() ?>/Channel" type="button" class="btn btn-warning"><i
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