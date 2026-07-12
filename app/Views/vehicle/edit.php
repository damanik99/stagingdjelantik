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
<?php /** @var array<string, mixed> $vehicle */ ?>
<?php /** @var string $title */ ?>
<?php /** @var array $company */ ?>
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Vehicle">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
                <h1 class="page-title">Edit Data Vehicle</h1>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7">
                    </div>
                    <form id="vehicleEdit" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Company <span class="text-danger">*</span></label>
                                        <select name="company_program_id" class="form-control select2-show-search">
                                            <option value="">Choose Company</option>
                                            <?php foreach ($company as $row) : ?>
                                                <option value="<?= $row['company_program_id']; ?>" 
                                                <?= $row['company_program_id'] == $vehicle['company_program_id'] ? 'selected' : ''; ?>>
                                                    <?= $row['company_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Plate Number <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="plate_number" value="<?= $vehicle['plate_number']  ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                                        <select name="vehicle_type" class="form-control">
                                            <option value="">Choose Vehicle Type</option>
                                            <option value="tangki"<?= $vehicle['vehicle_type'] == 'tangki' ? 'selected' : ''; ?>>Mobil Tangki</option>
                                            <option value="pickup"<?= $vehicle['vehicle_type'] == 'pickup' ? 'selected' : ''; ?>>Mobil Pickup</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Merk</label>
                                        <input class="form-control" type="text" name="brand" value="<?= $vehicle['brand']  ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Capacity Weight</label>
                                        <input class="form-control" type="number" step="0.01" name="capacity_weight" value="<?= $vehicle['capacity_weight']  ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Capacity Volume</label>
                                        <input class="form-control" type="number" step="0.01" name="capacity_volume" value="<?= $vehicle['capacity_volume']  ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">STNK Expiry Date</label>
                                        <input type="date"name="stnk_expiry_date" class="form-control" value="<?= date('Y-m-d', strtotime($vehicle['stnk_expiry_date'])); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">KIR Expiry Date</label>
                                        <input type="date" name="kir_expiry_date" class="form-control" value="<?= date('Y-m-d', strtotime($vehicle['kir_expiry_date'])); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control select2-show-search">
                                            <option value="">Choose Status</option>
                                            <option value="available"<?= $vehicle['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                                            <option value="on_delivery" <?= $vehicle['status'] == 'on_delivery' ? 'selected' : ''; ?>>On Delivery</option>
                                            <option value="maintenance" <?= $vehicle['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions text-center mt-5">
                                <a class="btn btn-default-light" href="<?= base_url() ?>/Vehicle">
                                    <i class="fa fa-window-close"></i> Cancel
                                </a>

                                <button type="submit" id="submitBtn" class="btn btn-teal">
                                    <i class="fa fa-save"></i> Save
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
<script src=" <?= base_url() ?>/teamplate/assets/js/select2.js"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js">
</script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$('#vehicleEdit').submit(function(e) {

    e.preventDefault();

    $.ajax({

        url : '<?= base_url('/vehicle/edit/'.$vehicle['vehicle_id']); ?>',
        type : 'POST',
        data : $(this).serialize(),
        dataType : 'json',

        beforeSend : function(){

            $('#submitBtn').prop('disabled', true);

            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

        },

        success : function(response){

            $('#submitBtn').prop('disabled', false);

            Swal.close();

            if(response.status){

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(function(){

                    window.location.href = '<?= base_url('/Vehicle'); ?>';

                });

            }else{

                let msg = '';

                $.each(response.message, function(key, value){

                    msg += value + '<br>';

                });

                Swal.fire({
                    icon : 'error',
                    title : 'Validation Error',
                    html : msg
                });

            }

        },

        error : function(xhr){

            $('#submitBtn').prop('disabled', false);

            Swal.fire({
                icon : 'error',
                title : 'Error',
                text : 'Internal Server Error'
            });

            console.log(xhr.responseText);

        }

    });

});

</script>