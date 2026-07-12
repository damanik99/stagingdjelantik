<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->

<!-- INTERNAL  FILE UPLODE CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet"
    type="text/css" />

<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

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
                <!-- <h1 class="page-title">ITEM ADD</h1> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/moduleupdate">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Module Update</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="mb-0 card-title">CREATE</h3>
                    </div>
                    <form id="modulePost" action='<?=base_url();?>/ModuleUpdate/create' method="post"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Type</label>
                                        <select class="form-control" id="type" name="type" required="">
                                            <option value="bug_fix">Bug Fix</option>
                                            <option value="module_addition">Module Addition</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="3" name="message"
                                            required=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-center mt-5">
                                <a class="btn btn-warning mr-1" href="<?=base_url()?>/ModuleUpdate" role="button"><i
                                        class="fa fa-window-close"></i> Cancel</a>
                                <button type="submit" name="submit" value="save" class="btn btn-primary">
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

<!-- INTERNAL ACCORDION JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
<?php if (session()->getFlashdata('success')) {?>
toastr.success("<?php echo session()->getFlashdata('success'); ?>");
<?php }  ?>
</script>

<script>
// Insert database
$('#modulePost').on('submit', function(e) {
    e.preventDefault(); // Cegah submit awal

    let form = $(this);
    let submitBtn = $('#submitBtn');
    submitBtn.prop('disabled', true); // Disable tombol submit sementara

    // Hapus alert jika ada sebelumnya
    $('#alert-container').html('');

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'error') {

                if (response.message === 'Program Not selected yet') {
                    // Jika program belum dipilih, tampilkan alert di atas form
                    $('#alert-container').html(`
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Warning!</strong> ${response.message}
                            </div>
                        `);
                } else {
                    // Jika error lain, tampilkan di SweetAlert
                    Swal.fire({
                        icon: 'error',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

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
</script>