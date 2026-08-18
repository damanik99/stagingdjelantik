<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>LogiMove — Pickup Quantity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/assets/css/icons.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/teamplate/assets/mobile.css" rel="stylesheet" />

    <style>
        /* ── Additional quantity page specific styles ── */
        .qty-section {
            padding-top: 8px;
        }
    </style>

</head>

<?php /** @var string $shipmentDetailId */ ?>

<body>
    <div class="phone-frame">
        <div class="screen" style="display:flex;">

            <!-- Header -->
            <div class="app-header">
                <a href="<?= base_url('driver/destination/' . $shipmentDetailId) ?>" class="back-btn"><i class="bi bi-arrow-left"></i></a>
                <span class="title">Pickup</span>
            </div>

            <!-- Main Content -->
            <div class="main-content no-nav qty-section">
                <p class="text-muted text-center fw-600 mb-16" style="font-size:0.85rem;">

                </p>
                <form id="formCheckin" enctype="multipart/form-data">
                    <!-- FOTO -->
                    <div class="row">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                Foto Bukti <span class="text-danger">*</span>
                            </label>

                            <div class="position-relative">
                                <img id="previewImage"
                                    src="<?= base_url('assets/images/no-image.png'); ?>"
                                    class="img-fluid rounded border"
                                    style="width:100%;height:250px;object-fit:cover;">

                                <label for="photo"
                                    class="btn btn-dark rounded-circle position-absolute"
                                    style="bottom:10px;right:10px;width:55px;height:55px;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                                    <i class="fe fe-camera fs-20"></i>
                                </label>

                                <input type="file"
                                    id="photo"
                                    name="photo"
                                    accept="image/*"
                                    capture="environment"
                                    class="d-none">
                            </div>

                            <small class="text-muted">
                                Ambil foto dari kamera atau pilih dari galeri.
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <label class="form-label">Lokasi GPS</label>

                            <div class="input-group">
                                <input type="text" id="location_display" name="location" class="form-control"
                                    readonly
                                    placeholder="Klik Refresh Lokasi">
                                <div class="input-group-append">
                                    <button type="button" id="btnLocation" class="btn btn-light border">
                                        <i class="fe fe-refresh-cw"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Latitude</label>
                                <input type="text" id="latitude_display" name="latitude" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Longitude</label>
                                <input type="text" id="longitude_display" name="longitude" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Volume *</label>
                                <input type="text" class="form-control" name="volume" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Unit <span class="text-danger">*</span></label>
                                <select name="unit" class="form-control select2-show-search" required>
                                    <option value="">-- Select Unit --</option>
                                    <option value="kg">KG</option>
                                    <option value="liter">Liter</option>
                                </select>
                            </div>
                        </div>
                        <!-- CATATAN -->
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Note (Opsional)</label>
                            <textarea class="form-control" rows="4" name="notes">
                            </textarea>
                        </div>
                    </div>
                    <!-- Action Button -->
                    <button class="btn btn-primary btn-block" id="btn-confirm"
                        onclick="openBottomSheet()">
                        KONFIRMASI PICKUP
                    </button>
                </form>


            </div>

        </div><!-- /screen -->

    </div><!-- /phone-frame -->

    <!-- ═════ BOTTOM SHEET ═════ -->
    <div class="bottom-sheet-overlay" id="bottom-sheet-overlay">
        <div class="bottom-sheet" onclick="event.stopPropagation()">
            <div class="sheet-handle"></div>

            <h6 class="fw-700 mb-12">Confirm Pickup</h6>

            <div class="d-flex justify-between align-center mb-8">
                <span class="text-muted" style="font-size:0.85rem;">Lokasi</span>
                <span class="fw-700" style="font-size:0.85rem;">PKK 002</span>
            </div>

            <div class="d-flex justify-between align-center mb-16">
                <span class="text-muted" style="font-size:0.85rem;">volume</span>
                <span class="fw-700" style="font-size:1rem;" id="sheet-qty">125 Liter</span>
            </div>

            <p class="text-muted mb-16 text-center" style="font-size:0.82rem;">
                Apakah data sudah benar?
            </p>

            <button class="btn-outline-custom mb-8" onclick="closeBottomSheet()">
                Batal
            </button>
            <a href="camera.html" class="btn-action btn-action-success d-block text-center w-100">
                Konfirmasi
            </a>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ── Quick Quantity Chips ──
        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', function() {
                const qty = this.getAttribute('data-qty');
                document.getElementById('qty-input').value = qty;
                document.getElementById('qty-input').focus();
            });
        });

        // ── Bottom Sheet ──
        function openBottomSheet() {
            const qtyVal = document.getElementById('qty-input').value || '0';
            document.getElementById('sheet-qty').textContent = qtyVal + ' Liter';
            document.getElementById('bottom-sheet-overlay').classList.add('show');
        }

        function closeBottomSheet() {
            document.getElementById('bottom-sheet-overlay').classList.remove('show');
        }

        document.getElementById('bottom-sheet-overlay').addEventListener('click', function(e) {
            if (e.target === this) closeBottomSheet();
        });

        $('#photo').on('change', function() {

            const file = this.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {

                $('#previewImage').attr('src', e.target.result);

                $('#previewImage').removeClass('d-none');

            };

            reader.readAsDataURL(file);

        });

        $('#btnLocation').click(function() {

            navigator.geolocation.getCurrentPosition(
                async function(position) {
                        let lat = position.coords.latitude;
                        let lon = position.coords.longitude;

                        // Tampil ke user
                        $('#location_display').val('Mengambil alamat...');
                        $('#latitude_display').val(lat);
                        $('#longitude_display').val(lon);

                        // Hidden untuk submit
                        $('#latitude').val(lat);
                        $('#longitude').val(lon);

                        try {

                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`
                            );

                            const data = await response.json();

                            if (data.display_name) {
                                $('#location_display').val(data.display_name);
                                $('#address').val(data.display_name ?? '');

                            } else {
                                $('#location_display').val(lat + ', ' + lon);
                            }

                        } catch (error) {
                            $('#address').val('');

                        }
                    },
                    function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'GPS Gagal',
                            text: 'Tidak dapat mengambil lokasi saat ini.'
                        });

                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }

            );

        });

        // Save Shipment
        $('#formCheckin').submit(function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Loading...',
                text: 'Menyimpan data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({

                url: "<?= base_url('/driver/arrivalCreate/' . $shipmentDetailId) ?>",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',

                success: function(response) {

                    Swal.close();
                    console.log(response);
                    if (response.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {

                            window.location.href = "<?= base_url('/driver/index') ?>";

                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {

                    Swal.close();

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem.'
                    });

                }

            });

        });
    </script>

</body>

</html>