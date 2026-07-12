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
<?php /** @var array<string, mixed> $warehouse */ ?>
    <?php /** @var string $title */ ?>
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Warehose">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
                <h1 class="page-title">Vehicle</h1>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <form id="warehouseEdit" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Warehouse Code<b style="color:red">*</b></label>
                                        <input class="form-control" type="text" name="warehouse_code"
                                            value="<?= $warehouse['warehouse_code']; ?>"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label">Warehouse Name<b style="color:red">*</b></label>
                                        <input class="form-control" type="text" name="warehouse_name"
                                            value="<?= $warehouse['warehouse_name']; ?>"
                                            required>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" rows="4"
                                            name="address"><?= $warehouse['address']; ?>
                                        </textarea>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Latitude</label>

                                        <input class="form-control" type="text" name="latitude"
                                            value="<?= $warehouse['latitude']; ?>">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Longitude</label>
                                        <input class="form-control" type="text" name="longitude"
                                            value="<?= $warehouse['longitude']; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>

                                        <select name="is_active" class="form-control">
                                            <option value="1"
                                                <?= ($warehouse['is_active'] == 1 ? 'selected' : '') ?>>
                                                Active
                                            </option>
                                            <option value="0"
                                                <?= ($warehouse['is_active'] == 0 ? 'selected' : '') ?>>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions text-center mt-5">
                                <a class="btn btn-default-light mr-1" href="<?= base_url() ?>/Warehouse">
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

$('#warehouseEdit').submit(function(e) {

    e.preventDefault();

    $.ajax({

        url : '<?= base_url('/warehouse/update/'.$warehouse['warehouse_id']); ?>',

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

                    window.location.href =
                        '<?= base_url('/Warehouse'); ?>';

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