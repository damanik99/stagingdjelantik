<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />
<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

<?php /** @var array<string, mixed> $container */ ?>
<?php /** @var array $warehouse */ ?>
<?php /** @var array $containertype */ ?>
<?php /** @var array $status */ ?>

<div class="app-content">
    <div class="side-app">
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>StorageContainer">Storage Container</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
                <h1 class="page-title">Edit Storage Container</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <form id="storageContainerEdit" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Container Code</label>
                                        <input type="text" name="container_code" class="form-control" value="<?= esc($container['container_code']); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Container Name <span class="text-danger">*</span></label>
                                        <input type="text" name="container_name" class="form-control" id="container_name" value="<?= esc($container['container_name']); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Container Type <span class="text-danger">*</span></label>
                                        <select name="container_type_id" class="form-control select2-show-search" required>
                                            <option value="">-- Select Container --</option>
                                            <?php foreach ($containertype as $row) : ?>
                                                <option value="<?= $row['container_type_id']; ?>" <?= ($container['container_type_id'] == $row['container_type_id'] ? 'selected' : '') ?>>
                                                    <?= esc($row['container_type_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                                        <select name="warehouse_id" class="form-control select2-show-search" required>
                                            <option value="">-- Select Warehouse --</option>
                                            <?php foreach ($warehouse as $row) : ?>
                                                <option value="<?= $row['warehouse_id']; ?>" <?= ($container['warehouse_id'] == $row['warehouse_id'] ? 'selected' : '') ?>>
                                                    <?= esc($row['warehouse_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Capacity <span class="text-danger">*</span></label>
                                        <input type="text" name="capacity" class="form-control" value="<?= esc($container['capacity']); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Unit <span class="text-danger">*</span></label>
                                        <select name="capacity_unit" class="form-control" required>
                                            <option value="">-- Select Unit --</option>
                                            <option value="kg" <?= (strtolower($container['capacity_unit']) === 'kg' ? 'selected' : '') ?>>Kg</option>
                                            <option value="liter" <?= (strtolower($container['capacity_unit']) === 'liter' ? 'selected' : '') ?>>Liter</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="">-- Select Status --</option>
                                            <?php foreach ($status as $row) : ?>
                                                <option value="<?= $row['status_id']; ?>" <?= ($container['status_id'] == $row['status_id'] ? 'selected' : '') ?>>
                                                    <?= esc($row['status_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Note</label>
                                        <textarea name="note" class="form-control" rows="4"><?= esc($container['note'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <a href="<?= base_url('StorageContainer') ?>" class="btn btn-default-light">
                                    <i class="fa fa-window-close"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-teal" id="submitBtn">
                                    <i class="fa fa-save"></i>
                                    Save
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

<script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('#container_name').on('input', function () {
    this.value = this.value.toUpperCase();
});

$('#storageContainerEdit').on('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const payload = Object.fromEntries(formData.entries());

    $.ajax({
        url: '<?= base_url('/StorageContainer/update/'.$container['storage_container_id']); ?>',
        type: 'POST',
        data: JSON.stringify(payload),
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            $('#submitBtn').prop('disabled', true);
            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function(response) {
            $('#submitBtn').prop('disabled', false);
            Swal.close();

            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {
                    window.location.href = '<?= base_url('/StorageContainer'); ?>';
                });
                return;
            }

            let msg = response.message || 'Validation Error';

            if (response.errors) {
                msg = '';
                $.each(response.errors, function(key, value) {
                    msg += value + '<br>';
                });
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: msg
            });
        },
        error: function(xhr) {
            $('#submitBtn').prop('disabled', false);
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Internal Server Error'
            });
            console.log(xhr.responseText);
        }
    });
});
</script>
