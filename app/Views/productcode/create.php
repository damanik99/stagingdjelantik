<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->

<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

<style>
required {
    color: red;
}
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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/productcode">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Product Code</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="mb-0 card-title">CREATE PRODUCT CODE</h3>
                    </div>
                    <form action='<?=base_url();?>/productcode/create' method="post">

                        <div class="card-body">
                            <?= session()->getFlashdata('message'); ?>
                            <?= session()->getFlashdata('error'); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">ITEM NAME <required>*</required></label>
                                        <select class="form-control select2-show-search" id="item_name" name="item_name"
                                            required>
                                            <option value="">--Select One--</option>
                                            <?php foreach($item as $row): ?>
                                            <option value="<?php echo $row['program_item_id'];?>" id="item_name">
                                                <?php echo $row['namaitem'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">CODE <required>*</required>
                                        </label>
                                        <input type="text" class="form-control" name="code" placeholder="code">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-center mt-5">
                                <a class="btn btn-warning mr-1" href="<?=base_url()?>/ProductCode/index"
                                    role="button"><i class="fa fa-window-close"></i> Cancel</a>
                                <button type="submit" name="submit" value="save" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- COL END -->
        </div>
        <!-- ROW-1 CLOSED -->


    </div>
</div>
<!-- CONTAINER END -->
</div>

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!--INTERNAL  FORMELEMENTS JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
<?php if (session()->getFlashdata('success')) {?>
alert("<?php echo session()->getFlashdata('success'); ?>");
<?php }  ?>

<?php if (session()->getFlashdata('error')) {?>
alert("<?php echo session()->getFlashdata('error'); ?>");
<?php }  ?>

jQuery(document).ready(function() {
    jQuery('#newClient').click(function() {
        clientForm();
    });

    jQuery('#createClient').click(function() {
        createClient();
    });

});

function clientForm() {
    var x = document.getElementById("clientForm");

    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";

        // clear form new create client
        var clientName = $("#client_name").val("");
        var contactName = $("#contact_name").val("");
        var contactPhone = $("#contact_phone").val("");
        var contactEmail = $("#contact_email").val("");
        var city = $("#city").val("");
        var address = $("#address").val("");
        // Finish clear form new create client

        $("#client").prop("disabled", false); //disabled 
        $("#text_client").hide();
    }
}

function createClient() {
    var clientName = $("#client_name").val();
    var CompanyName = $("#company_name").val();
    var contactName = $("#contact_name").val();
    var contactPhone = $("#contact_phone").val();
    var contactEmail = $("#contact_email").val();
    var city = $("#city").val();
    var address = $("#address").val();

    var mailformat =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    var client = $("#client").val();

    var uri = '<?=base_url()?>/wizard/saveClient';

    if (clientName == "") {
        alert("Client Name Empty");
    } else if (CompanyName != CompanyName.toUpperCase()) {
        alert("Company Letters can't be big");
    } else if (CompanyName == "") {
        alert("Company Can Not Empty");
    } else if (contactPhone == "") {
        alert("Contact Phone Can Not Empty");
    } else if (contactEmail == "") {
        alert("Contact Email Can Not Empty");
    } else if (city == "") {
        alert("City Can Not Empty");
    } else if (address == "") {
        alert("Address Can Not Empty");
    } else if (!contactEmail.match(mailformat)) {
        console.log(contactEmail);
        alert("You have entered an invalid email address!");
    } else {
        $.ajax({
            type: 'POST',
            async: false,
            dataType: "json",
            url: uri,
            data: {
                clientName: clientName,
                CompanyName: CompanyName,
                contactName: contactName,
                contactPhone: contactPhone,
                contactEmail: contactEmail,
                city: city,
                address: address
            },
            success: function(result) {
                if (result == '"not"') {
                    alert("already exists");
                } else {
                    var x = document.getElementById("client");
                    var cek = 0;

                    console.log(x);
                    var cek = 0;
                    for (i = 0; i < x.length; i++) {
                        console.log(i);
                        // document.getElementById(tablelist.toLowerCase()+"_id");
                        if (x.options[i].text == clientName)
                            cek = cek + 1;
                    }

                    if (cek == 0) {
                        var name = CompanyName;
                        var myselect = document.getElementById("client");
                        myselect.add(new Option(name.toUpperCase()), myselect.options[1]);
                        console.log(myselect);
                    }
                }
            }
        });
    }
}

function createProgram() {
    var client = $("#client").val();
    var programCode = $("#program_code").val();
    var programName = $("#program_name").val();

    var autoMembership = $("#auto_membership:checked").val();
    var moduleClaim = $("#auto_claim_:checked").val();
    var moduleRedeem = $("#auto_redeem:checked").val();

    var moduleAtt = $("#module_att:checked").val();
    var moduleAct = $("#module_act:checked").val();
    var moduleInb = $("#module_inb:checked").val();
    var moduleDst = $("#module_dst:checked").val();
    var moduleDis = $("#module_dis:checked").val();
    var moduleTrn = $("#module_trn:checked").val();
    var moduleSll = $("#module_sll:checked").val();
    var moduleRdm = $("#module_rdm:checked").val();

    var viewAct = $("#view_act:checked").val();
    var viewDis = $("#view_dis:checked").val();
    var viewOrder = $("#view_order:checked").val();
    var viewAtt = $("#view_att:checked").val();
    var viewTrn = $("#view_trn:checked").val();
    var viewSll = $("#view_sll:checked").val();
    var viewMnct = $("#view_mnct:checked").val();

    if (client == "") {
        alert("Client Can Not Empty");
    } else if (programCode == "") {
        alert("Program Code Can Not Empty");
    } else if (programName == "") {
        alert("Program Name Can Not Empty");
    } else {
        var uri = '<?=base_url()?>/wizard/save';

        $.ajax({

            type: 'POST',
            url: uri,
            data: {
                client: client,
                programCode: programCode,
                programName: programName,
                autoMembership: autoMembership,
                moduleClaim: moduleClaim,
                moduleRedeem: moduleRedeem,
                moduleAtt: moduleAtt,
                moduleAct: moduleAct,
                moduleInb: moduleInb,
                moduleDst: moduleDst,
                moduleDis: moduleDis,
                moduleTrn: moduleTrn,
                moduleSll: moduleSll,
                moduleRdm: moduleRdm,
                viewAct: viewAct,
                viewDis: viewDis,
                viewOrder: viewOrder,
                viewAtt: viewAtt,
                viewTrn: viewTrn,
                viewSll: viewSll,
                viewMnct: viewMnct
            },
            success: function(result) {
                console.log(result);
                if (result != "NULL") {
                    var id = result;
                    alert('saved successfully');
                    // get value last id || program_id
                    // console.log('/wizard/privilage/'+id);
                    window.location.href = '/wizard/privilage/' + result;
                } else {
                    alert('saved not successfully');
                }
            }
        });

    }

}
</script>