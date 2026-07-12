<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->

<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

<style>
    .separator {
        position: relative;
        text-align: center;
    }


    .separator:before {
        content: '';
        border-style: solid;
        border-width: 0 0 1px 0;
        position: absolute;
        left: 0;
        top: 0%;
        width: 100%;
        border-color: #c5c9e6;
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
                <h1 class="page-title"><?=$title?></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Add</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
            </div>
        </div>
        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="card-title text-white">Privilage</h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <!-- <ul>
                                    <li><a href="#step-3">Picklist</a></li>
                                    <li><a href="#step-4">Privilage</a></li>
                                </ul> -->

                            <div>
                                <!-- Finish Step Module -->
                                <!-- Step Picklist -->
                                <div id="step-3" class="">
                                    <div class="alert alert-info" role="alert">
                                        Privilege adalah untuk menambahkan menu akses user<br>
                                        Langkah - langkahnya adalah :<br>
                                        <ol class="list-order-style">
                                            <li>
                                                Buat data group baru, klik button create new group.
                                            </li>
                                            <li>
                                                klik dropdown group name dengan pilihan group,
                                                klik dropdown page dan pilih menu yang di butuhkan dan pilih
                                                action yang di butuhkan.
                                            </li>
                                            <ol>
                                    </div>

                                    <button type="button" id="newGroup" class="btn btn-primary"><i
                                            class="fa fa-plus mr-2"></i>Create new group</button>
                                    <br>
                                    <div id="groupForm" style="display:none;">
                                        <br>
                                        <form method="post" class="form-pikclist" id="form-pikclist">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Group</label>
                                                        <input type="text" class="form-control" placeholder="Enter Group Name" name="nameGroup" id="nameGroup">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="clearChoose" style="display:none;">
                                        </div>

                                        <div id="infoAtt" style="display:none;">
                                            <div class="alert alert-info alert-dismissible fade show"
                                                role="alert">
                                                <span class="alert-inner--text"><strong>Example Attendance
                                                        Type!</strong>
                                                    <br>- visit
                                                    <br>- go_home
                                                    <br>- in_sick
                                                    <br>- off_day
                                                    <br>- personal Leave
                                                </span>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6" id="tablesx">

                                                    </div>
                                                </div>
                                            </div>
                                            <table
                                                class="table table-striped table-hover table-bordered table-condensed"
                                                id="previews">
                                                <caption>Preview</caption>
                                                <thead>
                                                    <tr>
                                                        <th>name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="alert alert-info alert-dismissible fade show"
                                            role="alert" id="infoDelivery" style="display:none;">
                                            <span class="alert-inner--text"><strong>Example Delivery
                                                    Method!</strong>
                                                <br>- Courier
                                                <br>- Delivery by Vendor
                                                <br>- okri
                                            </span>
                                        </div>

                                        <div class="alert alert-info alert-dismissible fade show"
                                            role="alert" id="infoGroup">
                                            <span class="alert-inner--text"><strong>Example Group!</strong>
                                                <br>- ACCOUNT_EXECUTIVE
                                                <br>- ACCOUNT_MANAGER
                                                <br>- ADMINISTRATOR
                                                <br>- ADMINISTRATOR_PROGRAM
                                            </span>
                                        </div>

                                        <div class="alert alert-info alert-dismissible fade show"
                                            role="alert" id="infoPage" style="display:none;">
                                            <span class="alert-inner--text"><strong>Example Action!</strong>
                                                <br>- Action
                                                <br>- Activity
                                                <br>- Attendance
                                                <br>- Attendance
                                            </span>
                                        </div>

                                        <div class="alert alert-info alert-dismissible fade show"
                                            role="alert" id="infoStatus" style="display:none;">
                                            <span class="alert-inner--text"><strong>Example Status!</strong>
                                                <br>- Active
                                                <br>- Cancel
                                                <br>- Open
                                                <br>- close
                                            </span>
                                        </div>
                                        <!-- Button Group -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <button type="button" id="createGroup" class="btn btn-success">
                                                        <i class="fa fa-save mr-2"></i>Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Finish Button Group -->
                                    </div>
                                    <!-- Garis Pembatas -->
                                    <div class="row">
                                        <div class="border-bottom col-md-12">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Finish garis Pembatas -->

                                    <h6>Privilage</h6>
                                    <div class="separator"></div>
                                    <form action='<?=base_url();?>/wizard/savePrivilege' method="post" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Group</label>
                                                    <select class="form-control" name="group_id" id="group_id">
                                                        <option value="">-- Chooose One --</option>
                                                        <?php foreach($group as $groups): ?>
                                                        <option value="<?= $groups["group_id"];?>">
                                                            <?= $groups['group_name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Page</label>
                                                    <select class="form-control" name="page_id" id="page_id">
                                                        <option value="">-- Chooose One --</option>
                                                        <?php foreach($page as $pages): ?>
                                                        <option value="<?= $pages["page_id"];?>">
                                                            <?= $pages['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Action</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php foreach($action as $actions): ?>
                                            <div class="col-md-4">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="action_id" name="checkbox[]"
                                                        value="<?= $actions["action_id"];?>">
                                                    <span
                                                        class="custom-control-label"><?= $actions['name'];?></span>
                                                </label>
                                            </div>
                                            <?php endforeach;?>

                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label><br></label>
                                                    <button type="button" id="add_privilege"
                                                        class="btn btn-primary">
                                                        <i class="fa fa-plus mr-2"></i>Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="col-md-12">
                                                <table
                                                    class="table table-striped table-hover table-bordered table-condensed"
                                                    id="preview">
                                                    <thead>
                                                        <tr>
                                                            <th>Group</th>
                                                            <th>Page</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><br></label>
                                                    <button type="submit" name="submit" value="save"
                                                        id="add_privilege" class="btn btn-success">
                                                        <i class="fa fa-save mr-2"></i>Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Finish Step Picklist -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>
</div>
<!-- CONTAINER END -->
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
    jQuery(document).ready(function() {
        jQuery('#newGroup').click(function() {
            groupForm();
        });

        jQuery('#add_privilege').click(function() {
            add_privilege();
        });

    });

    document.getElementById("nameGroup").addEventListener("input", function () {

    let value = this.value;

    // spasi menjadi underscore
    value = value.replace(/\s+/g, "_");

    // hanya huruf, angka, underscore
    value = value.replace(/[^a-zA-Z0-9_]/g, "");

    // uppercase
    value = value.toUpperCase();

    // rapikan underscore ganda
    value = value.replace(/_+/g, "_");

    this.value = value;
});

    $("#pickname").change(function() {

        var pickname = document.getElementById("pickname").value;

        if (pickname == "chooseOne") {
            var clearChoose = document.getElementById("clearChoose");
            var infoAtt = document.getElementById("infoAtt");
            var infoDelivery = document.getElementById("infoDelivery");
            var infoGroup = document.getElementById("infoGroup");
            var infoPage = document.getElementById("infoPage");
            var infoStatus = document.getElementById("infoStatus");
            var statustype = document.getElementById("statustype");

            if (clearChoose.style.display === "none") {
                statustype.style.display = "none";
                clearChoose.style.display = "none";
                infoAtt.style.display = "none";
                infoDelivery.style.display = "none";
                infoGroup.style.display = "none";
                infoPage.style.display = "none";
                infoStatus.style.display = "none";
            }
        } else if (pickname == "AttendanceTypeModel") {
            var x = document.getElementById("infoAtt");
            var infoDelivery = document.getElementById("infoDelivery");
            var infoGroup = document.getElementById("infoGroup");
            var infoPage = document.getElementById("infoPage");
            var infoStatus = document.getElementById("infoStatus");
            var statustype = document.getElementById("statustype");

            if (x.style.display === "none") {
                x.style.display = "block";
                statustype.style.display = "none";
                infoDelivery.style.display = "none";
                infoGroup.style.display = "none";
                infoPage.style.display = "none";
                infoStatus.style.display = "none";
            } else {
                x.style.display = "none";
            }
        } else if (pickname == "deliveryMethod") {
            var x = document.getElementById("infoDelivery");
            var infoAtt = document.getElementById("infoAtt");
            var infoGroup = document.getElementById("infoGroup");
            var infoPage = document.getElementById("infoPage");
            var infoStatus = document.getElementById("infoStatus");
            var statustype = document.getElementById("statustype");

            if (x.style.display === "none") {
                x.style.display = "block";
                statustype.style.display = "none";
                infoAtt.style.display = "none";
                infoGroup.style.display = "none";
                infoPage.style.display = "none";
                infoStatus.style.display = "none";
            } else {
                x.style.display = "none";
            }
        } else if (pickname == "group") {
            var x = document.getElementById("infoGroup");
            var infoAtt = document.getElementById("infoAtt");
            var infoDelivery = document.getElementById("infoDelivery");
            var infoPage = document.getElementById("infoPage");
            var infoStatus = document.getElementById("infoStatus");
            var statustype = document.getElementById("statustype");

            if (x.style.display === "none") {
                x.style.display = "block";
                statustype.style.display = "none";
                infoAtt.style.display = "none";
                infoDelivery.style.display = "none";
                infoPage.style.display = "none";
                infoStatus.style.display = "none";
            } else {
                x.style.display = "none";
            }
        } else if (pickname == "page") {
            var x = document.getElementById("infoPage");
            var infoGroup = document.getElementById("infoGroup");
            var infoAtt = document.getElementById("infoAtt");
            var infoDelivery = document.getElementById("infoDelivery");
            var infoPage = document.getElementById("infoPage");
            var infoStatus = document.getElementById("infoStatus");
            var statustype = document.getElementById("statustype");

            if (x.style.display === "none") {
                x.style.display = "block";
                statustype.style.display = "none";
                infoAtt.style.display = "none";
                infoDelivery.style.display = "none";
                infoGroup.style.display = "none";
                infoStatus.style.display = "none";
            } else {
                x.style.display = "none";
            }
        } else if (pickname == "status") {
            var x = document.getElementById("infoStatus");
            var infoGroup = document.getElementById("infoGroup");
            var infoAtt = document.getElementById("infoAtt");
            var infoDelivery = document.getElementById("infoDelivery");
            var infoPage = document.getElementById("infoPage");
            var statustype = document.getElementById("statustype");

            if (x.style.display === "none") {
                x.style.display = "block";
                statustype.style.display = "block";
                infoAtt.style.display = "none";
                infoDelivery.style.display = "none";
                infoGroup.style.display = "none";
                infoPage.style.display = "none";
            } else {
                x.style.display = "none";
            }
        }

    });

    $("#createGroup").click(function() {
        var group_id = $("#group_id").val();
        var program_id = $("#program_id").val();
        var pickname = 'group';
        var nameGroup = $("#nameGroup").val();

        var uri = '<?=base_url()?>/privilege/createNewGroup';

        if (pickname == "") {
            alert("Picklist not selected");
        } else if (nameGroup == "") {
            alert("Name Can Not Empty");
        } else {
            $.ajax({
                type: 'POST',
                url: uri,
                data: {
                    nameGroup: nameGroup,
                    pickname: pickname,
                    program_id: program_id
                },
                success: function(result) 
                {

                    if(result == '"program_null"'){
                        alert("Program ID tidak boleh kosong");
                        return;
                    }

                    if (pickname == "group") {

                        if (result == '"ok"') {
                            var name = nameGroup.replace(" ", "_");
                            var myselect = document.getElementById(pickname.toLowerCase() + "_id");

                            myselect.add(new Option(name.toUpperCase(), result.group_id));

                            alert('Saved successfully');
                        } else {
                            alert("Group Name exist");
                        }
                    }
                }
            });
        }
    });

    function add_privilege() {
        var group_id = $("#group_id").val();
        var group_name = $("#group_id :selected").text();
        var page_id = $("#page_id").val();
        var page_name = $("#page_id :selected").text();
        var action_id = $("#action_id:checked").val();
        var action_name = $("input[type='checkbox']:checked:last").next().text();
        var program_id = $("#program_id").val();
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        var checkedData = [];

        if (group_id == "")
            alert("Group Tidak Boleh Kosong");
        else if (page_id == "")
            alert("Page Tidak Boleh Kosong");
        else if (action_id == "")
            alert("Action Tidak Boleh Kosong");
        else {
            var uri = '<?=base_url()?>/wizard/checkPrivilege';
            jQuery.ajax({
                type: 'POST',
                async: false,
                dataType: "json",
                url: uri,
                data: {
                    group_id: group_id,
                    page_id: page_id,
                    action_id: action_id,
                    program_id: program_id
                },
                success: function(result) {
                    console.log(result);

                    if (result == "Not") {

                        var tablePreview = $("#preview tbody");
                        var strContent = "<tr>";
                        var arr = [];

                        $('input[type=checkbox]:checked').each(function() {
                            var action_name = $(this).next().text();
                            var action_id = $(this).val();

                            strContent = strContent + "<td>" + group_name +
                                "<input type='hidden' name='group_id[]' value=" + group_id +
                                "></td>";
                            strContent = strContent + "<td>" + page_name +
                                "<input type='hidden' name='page_id[]' value=" + page_id + "></td>";
                            strContent = strContent + "<td>" + action_name +
                                "<input type='hidden' name='action_id[]' value=" + action_id +
                                "></td>";
                            strContent = strContent + "<td style='display:none;'>" + program_id +
                                "<input type='hidden' name='program_id[]' value=" + program_id +
                                "></td>";
                            strContent = strContent + "<td><a href='' id='removeColumn'>" +
                                "remove" +
                                "</a></td>";
                            strContent = strContent + "</tr>";

                            tablePreview.find('tr').each(function(i) {
                                var tds = $(this).find('td'),
                                    unique0 = tds.eq(0).text(),
                                    unique1 = tds.eq(1).text(),
                                    unique2 = tds.eq(2).text();
                                console.log(tds);
                                arr.push(unique0 + unique1 + unique2);
                            });
                        });

                        if (arr.length <= 0)
                            tablePreview.append(strContent);
                        else {
                            if (jQuery.inArray(group_name + page_name + action_name, arr) == -1)
                                tablePreview.append(strContent);
                            else
                                alert(group_name + ', ' + page_name + ' and ' + action_name +
                                    ' already added.');
                        }

                    } else
                        alert(group_name + ', ' + page_name + ' and ' + result + ' already exist.');
                }
            });
        }
    }

    $(document).on('click', '#removeColumn', function() {
        $(this).closest('tr').remove();
        return false;
    });

    function groupForm() 
    {
        var x = document.getElementById("groupForm");

        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>