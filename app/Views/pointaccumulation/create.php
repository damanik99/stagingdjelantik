<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->

<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />


<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->


<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
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
                    <?= session()->getFlashdata('error'); ?>
                    <form id="claimpoint" action='<?=base_url();?>/pointaccumulation/create' method="post"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Member Full Name <b style="color:red">*</b></label>
                                    <select class="form-control select2-show-search" id="member_full_name"
                                        name="member_full_name" required="">
                                        <option value=''>-- Select One --</option>
                                        <?php
                                            foreach ($member as $members) {
                                        ?>
                                        <option value="<?= $members["member_id"] ?>"><?= $members['full_name'] ?>
                                        </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Code/SN/Qrcode <b style="color:red">*</b></label>
                                    <input type="text" class="form-control" id="code" name="code" required="">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Item <b style="color:red">*</b></label>
                                    <select class="form-control select2-show-search" id="member_full_name" name="item"
                                        required="">
                                        <option value=''>-- Select One --</option>
                                        <?php
                                            foreach ($programitem as $programitems) {
                                        ?>
                                        <option value="<?= $programitems["program_item_id"] ?>">
                                            <?= $programitems['item'] ?>
                                        </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <labe class="form-label">Channel From (Store from)</labe>
                                    <input type="text" class="form-control" name="channel_from">
                                </div>
                                <div class="col-md-6">
                                    <labe class="form-label">Channel To (Store to)</labe>
                                    <input type="text" class="form-control" name="channel_to">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Claim Date <b style="color:red">*</b></label>
                                    <div class="wd-200 mg-b-30">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div><input class="form-control" name="claim_date" id="claim_date"
                                                placeholder="YYYY-MM-DD" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Invoice Number <b style="color:red">*</b></label>
                                    <input type="text" class="form-control" name="invoice_number" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Invoice Date <b style="color:red">*</b></label>
                                    <div class="wd-200 mg-b-30">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="invoice_date"
                                                id="invoice_date" placeholder="YYYY-MM-DD" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Quantity</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity"
                                        placeholder="Only Number Format">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Revenue</label>
                                    <input type="text" class="form-control" id="revenue" name="revenue"
                                        placeholder="Only Number Format">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Point <b style="color:red">*</b></label>
                                    <input type="text" class="form-control" id="point" name="unit_point"
                                        placeholder="Only Number Format" required="">
                                </div>
                            </div>
                            <div class="form-actions text-center mt-5">
                                <a class="btn btn-warning mr-1" href="<?=base_url()?>/pointaccumulation"
                                    role="button"><i class="fa fa-window-close"></i> Cancel</a>
                                <button type="submit" id="submitBtn" value="save" class="btn btn-primary">
                                    <i class="fa fa-save"> </i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
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
$(document).ready(function() {
    $("#quantity").on("input", function() {
        $(this).val($(this).val().replace(/[^0-9]/g, ""));
    });

    $("#point").on("input", function() {
        $(this).val($(this).val().replace(/[^0-9]/g, ""));
    });

    $(document).ready(function() {
        $("#revenue").on("input", function() {
            let value = $(this).val().replace(/\D/g, "");
            $(this).val(new Intl.NumberFormat("id-ID").format(value));
        });
    });

    $('#claimpoint').on('submit', function(e) {
        e.preventDefault(); // Cegah submit awal

        let form = $(this);
        let submitBtn = $('#submitBtn');
        submitBtn.prop('disabled', true); // Disable tombol submit sementara

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3500
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3500
                    });
                    form[0].reset(); // Reset form jika sukses
                }
                submitBtn.prop('disabled', false); // Aktifkan tombol submit kembali
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    text: 'Terjadi Kesalahan, Coba ulangi lagi.',
                    showConfirmButton: false,
                    timer: 3500
                });
                submitBtn.prop('disabled', false);
            }
        });
    });
});

$("#code").keyup(function() {
    $(this).val($(this).val().toUpperCase());
});

$(function() {
    $("#claim_date").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        endDate: "0d", // Membatasi tanggal hingga hari ini
        todayHighlight: true
    });

    $("#invoice_date").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        endDate: "0d", // Membatasi tanggal hingga hari ini
        todayHighlight: true
    });

});
</script>