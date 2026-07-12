<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />
<!-- CUSTOM SCROLL BAR CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
<!--PERFECT SCROLL CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet" />

<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->
<?php /** @var array $shipmentTrack
 * */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <div><br></div>

                <div class="card">
                    <div class="card-status bg-blue br-tr-7 br-tl-7"></div>
                    <div class="card-body">

                         <div class="form-group mb-4">
                            <h2 class="mb-1  number-font"><?= $shipmentTrack['shipment_number'] ?></h2>
                        </div>

                        <form id="formArrived" enctype="multipart/form-data">

                            <!-- FOTO -->
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
                            <!-- // lokasi -->
                            <div class="row"> 
                                <div class="col-md-12">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" class="form-control" value="<?= $shipmentTrack['supplier'] ?>" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Buyer</label>
                                    <input type="text" class="form-control" value="<?= $shipmentTrack['buyer'] ?>" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control" value="<?= $shipmentTrack['location'] ?>" readonly>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label">Lokasi GPS</label>

                                    <div class="input-group">
                                        <input type="text"
                                            id="location_display"
                                            class="form-control"
                                            readonly
                                            placeholder="Klik Refresh Lokasi">
                                        <div class="input-group-append">
                                            <button type="button"
                                                    id="btnLocation"
                                                    class="btn btn-light border">
                                                <i class="fe fe-refresh-cw"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Latitude</label>

                                    <input type="text"
                                        id="latitude_display"
                                        class="form-control"
                                        readonly>
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Longitude</label>

                                    <input type="text"
                                        id="longitude_display"
                                        class="form-control"
                                        readonly>
                                </div>
                            </div>

                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <input type="hidden" name="location" id="address">
                            <input type="hidden" name="shipment_id" value="<?= $shipmentTrack['shipment_id'] ?>">

                            <!-- CATATAN -->
                            <div class="form-group mb-4">
                                <label class="form-label font-weight-bold">
                                    Catatan (Opsional)
                                </label>

                                <textarea
                                    class="form-control"
                                    rows="4"
                                    name="notes"
                                    placeholder="Contoh: Berangkat dari gudang supplier"></textarea>
                            </div>

                            <!-- BUTTON -->
                            <div class="form-group mb-0">
                                <button type="submit"
                                        id="btnSubmit"
                                        class="btn btn-primary btn-block">
                                    <i class="fe fe-check-circle"></i>
                                    SIMPAN SAMPAI BUYER
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->


<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$('#photo').on('change', function () {

    const file = this.files[0];

    if (!file) {
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {

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

        },

        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }

    );

});

// Save Shipment
$('#formArrived').submit(function(e){

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

        url: "<?= base_url('/ShipmentTracking/arrivedsave/') ?>",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function(response){

            Swal.close();
            console.log(response);
            if(response.success){

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {
                    var shipmentId = "<?= $shipmentTrack['shipment_id'] ?>";
                    window.location.href ="<?= base_url('/ShipmentTracking/checkout') ?>/" +  + shipmentId;

                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });

            }

        },

        error: function(xhr){

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
