<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css"
    rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
<!-- CSS END -->

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->

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
                    <li class="breadcrumb-item"><a href="#">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                </ol>
            </div>
            <div class="ml-auto pageheader-btn">
                <a href="<?=base_url()?>/redemption/add" class="btn btn-primary btn-icon text-white mr-2">
                    <span>
                        <i class="fe fe-plus"></i>
                    </span> CREATE
                </a>
                <a href="<?=base_url()?>/redemption/upload" class="btn btn-success btn-icon text-white mr-2">
                    <span>
                        <i class="fa fa-upload"></i>
                    </span> UPLOAD
                </a>
                <a href="<?=base_url()?>/redemption/report" class="btn btn-cyan btn-icon text-white mr-2">
                    <span>
                        <i class="fa fa-download"></i>
                    </span> DOWNLOAD
                </a>
            </div>
        </div>
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create new data redemption, click
            button<i class="fe fe-plus"></i> create.<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Create some new data redemption, click
            button <i class="fa fa-upload"></i> upload and download teamplate upload<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Update data in table column
            "action",
            click button
            <i class="fa fa-pencil"></i> (icon pencil).<br>
            <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>View detail data in table column
            "action", click
            button <i class="fa fa-eye"></i> (icon eye).<br>
        </div>
        <!-- PAGE-HEADER END -->
        <!-- ROW-4 -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="card-title">DATA REDEMPTION</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTbls" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">Tracking Number</th>
                                        <th class="wd-15p">Member Name</th>
                                        <th class="wd-20p">Item Name</th>
                                        <th class="wd-10p">Status</th>
                                        <th class="wd-15p">Created Date</th>
                                        <th class="wd-15p">No Refrence</th>
                                        <th class="wd-10p">Pod</th>
                                        <th class="wd-25p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-4 CLOSED-->
    </div>
</div>

<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

<?php if (session()->getFlashdata('error')): ?>
<?= session()->getFlashdata('error') ?>
<?php endif; ?>

<script type="text/javascript">
$(function(e) {
    $('#dataTbls').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url() ?>/redemption/datatables", // endpoint backend
            type: 'POST'
        },
        "order": [
            [0, 'desc']
        ],
        columns: [{
                data: 'tracking_number'
            },
            {
                data: 'member_name'
            },
            {
                data: 'item_name'
            },
            {
                data: 'status_name'
            },
            {
                data: 'createddate'
            },
            {
                data: 'noref',
                render: function(data, type, row) {
                    return `<a href="javascript:void(0);" onclick="checkReferenceAvailability('${data}')">${data}</a>`;
                }
            },
            {
                data: 'pod',
                render: function(data, type, row) {
                    if (!data || data === null || data === '') {
                        // If POD photo is unavailable, return a "preview" link with an event
                        return `<a href="javascript:void(0);" onclick="showNoPhotoAlert()" style="color: red;">POD photo is unavailable</a>`;
                    } else {
                        // If POD photo is available, return the normal preview link
                        return `<a href="${data}" target="_blank">preview</a>`;
                    }
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
});

// Function to show an alert when "preview" is clicked, but no POD photo is available
function showNoPhotoAlert() {
    Swal.fire({
        icon: 'error',
        text: "POD Photo Unavailable",
        showConfirmButton: false,
        timer: 3500
    });
}

function checkReferenceAvailability(noref) {
    $.ajax({
        url: '<?= base_url() ?>/redemption/detail_ref/' + noref, // URL API tracking
        method: 'GET',
        success: function(response) {
            if (response.status === 'error') {
                // Jika API gagal, tampilkan alert
                Swal.fire({
                    icon: 'error',
                    title: 'Maintenance',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 3500
                });
            } else {
                // Jika API berhasil, lanjutkan ke detail halaman
                window.location.href = '<?= base_url() ?>/redemption/detail_ref/' + noref;
            }
        },
        error: function() {
            // Jika ada error saat AJAX
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching the reference data.',
            });
        }
    });
}
</script>