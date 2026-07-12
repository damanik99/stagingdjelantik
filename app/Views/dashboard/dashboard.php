<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->
 
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

<!-- CSS -->
<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />
<!-- CUSTOM SCROLL BAR CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
<!--PERFECT SCROLL CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet" />

<!-- INTERNAL GALLERY CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/gallery/gallery.css" rel="stylesheet">

<style>
.gear-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    padding: 0;
    /* z-index: 1000; */
    color: white;
}

.ui-datepicker,
.datepicker,
.bootstrap-datepicker,
.datetimepicker-dropdown,
.flatpickr-calendar {
    z-index: 9999 !important;
}

.card-title+small {
    margin-top: 4px;
}

.count-badge {
    display: inline-block;
    background-color: #14365b;
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    text-align: center;
    line-height: 22px;
    font-weight: bold;
    margin-right: 1px;
}

@media (max-width: 768px) {
    .ml-auto.pageheader-btn a {
        margin-bottom: 0px;
        /* Menambahkan jarak bawah di tombol */
    }

    /* Menambahkan jarak spesifik antara tombol "Attendance Visit" dan "Selling" */
    .btn-cyan {
        margin-top: 10px;
        /* Menambahkan jarak atas pada tombol selling */
    }
}
.pagess-headerdashboard {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    margin: 13px 0px;
    -ms-flex-wrap: wrap;
    justify-content: space-between;
    padding: 0;
    border-radius: 7px;
    position: relative;
    min-height: 50px;
}

/* galery Image*/
#shipmentGallery{
    column-count:4;
    column-gap:12px;
}

#shipmentGallery .gallery-item{
    break-inside:avoid;
    margin-bottom:12px;
}

#shipmentGallery img{
    width:100%;
    height:auto;
    display:block;
    border-radius:8px;
}
</style>

<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->
<?php /** @var string $programId */ ?>
<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="pagess-headerdashboard">
            <div>
                <h1 class="page-title text-center">Hi! Welcome To Dashboard</h1>
            </div>
        </div>
        <?php if($programId == NULL || $programId == '') { ?>
        <div class="alert alert-warning" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i> Warning!<br>
            Program Not Set
        </div>
        <?php } ?>

        <div class="row">
            <?= $this->include('dashboard/shipmenttracking')?>
        </div>
        <?= $this->include('dashboard/modalimage/modal')?>
    </div>
</div>
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>

<!-- INTERNAL GALLERY JS -->
<!-- <script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/picturefill.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lightgallery.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lightgallery-1.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lg-pager.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lg-autoplay.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lg-fullscreen.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lg-zoom.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lg-hash.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/gallery/lg-share.js"></script> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.css">

<script>
$(document).ready(function () {
    $('#datashipmenttracking').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('ShipmentTracking/datatables') ?>",
            type: "POST"
        },
        columns: [
            { data: 'action', orderable: false, searchable: false },
            { data: 'shipment_number' },
            { data: 'purchase_order_number', defaultContent: '-' },
            { data: 'supplier' },
            { data: 'buyer' },
            { data: 'driver_name' },
            { data: 'plate_number' },
            { data: 'qty_checkin' },
            { data: 'unit_checkin' },
            { data: 'qty_checkout' },
            { data: 'unit_checkout' },
            { data: 'departure_at' },
            { data: 'arrival_at' },
            { data: 'status_badge', orderable: false }
            // { data: 'action', orderable: false, searchable: false }
        ]
    });
});

$(document).on('click', '.btnImage', function () {

    let id = $(this).data('id');

    $("#detailimage").html("");
    $("#loadingDetailImage").show();

    $("#modalImage").modal("show");

    $.ajax({
        url: "<?= base_url('/ShipmentTracking/detailimage')?>/" + id,
        type: "GET",
        success: function(response){

            $("#loadingDetailImage").hide();
            $("#detailimage").html(response);

            if (typeof initShipmentGallery === "function") {
                initShipmentGallery();
            }

        },
        error:function(){

            $("#loadingDetailImage").hide();

            $("#detailimage").html(`
                <div class="alert alert-danger">
                    Failed to load image detail.
                </div>
            `);

        }
    });

});

</script>

<script type="module">

import PhotoSwipeLightbox from "https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.min.js";

window.initShipmentGallery = function () {

    const gallery = document.querySelector('#shipmentGallery');

    if (!gallery) return;

    const lightbox = new PhotoSwipeLightbox({
        gallery: '#shipmentGallery',
        children: 'a',
        pswpModule: () => import("https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.esm.min.js")
    });

    lightbox.init();
};

</script>

