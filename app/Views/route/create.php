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

<?php /** 
 * @var array $groups 
 * @var array $pages 
 * @var array $actions 
 * */ ?>

<div class="app-content">
    <div class="side-app">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>Route">Route</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Create
                    </li>
                </ol>
            </div>
        </div>
        <!-- PAGE HEADER END -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>

                    <form id="routeForm" action="<?= base_url('route/save'); ?>" method="post">
                        <div class="card-body">
                            <div class="row">
                                <!-- PAGE -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Page</label>
                                        <select name="page_id" id="page_id" class="form-control" required>
                                            <option value="">-- Select Page --</option>
                                            <?php foreach ($pages as $page): ?>
                                                <option
                                                    value="<?= $page['page_id']; ?>"
                                                    <?= old('page_id') == $page['page_id'] ? 'selected' : ''; ?>>
                                                    <?= esc($page['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- ACTION -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Action / Permission</label>
                                        <select name="action_id" id="action_id" class="form-control" required>
                                            <option value=""> -- Select Action -- </option>
                                            <?php foreach ($actions as $action): ?>
                                                <option
                                                    value="<?= $action['action_id']; ?>"
                                                    <?= old('action_id') == $action['action_id'] ? 'selected' : ''; ?>>
                                                    <?= esc(ucfirst($action['name'])); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- HTTP METHOD -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"> HTTP Method</label>
                                        <select name="http_method" id="http_method" class="form-control" required>
                                            <option value=""> -- Select HTTP Method --</option>
                                            <option value="GET"
                                                <?= old('http_method') === 'GET' ? 'selected' : ''; ?>>
                                                GET
                                            </option>

                                            <option value="POST"
                                                <?= old('http_method') === 'POST' ? 'selected' : ''; ?>>
                                                POST
                                            </option>

                                            <option value="PUT"
                                                <?= old('http_method') === 'PUT' ? 'selected' : ''; ?>>
                                                PUT
                                            </option>

                                            <option value="PATCH"
                                                <?= old('http_method') === 'PATCH' ? 'selected' : ''; ?>>
                                                PATCH
                                            </option>

                                            <option value="DELETE"
                                                <?= old('http_method') === 'DELETE' ? 'selected' : ''; ?>>
                                                DELETE
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <!-- URI -->
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label class="form-label">
                                            URI
                                        </label>

                                        <input type="text" name="uri" id="uri" class="form-control"
                                            value="<?= old('uri'); ?>"
                                            placeholder="organization/detail/(:num)"
                                            required>

                                        <small class="text-muted">
                                            Contoh:organization, organization/create, organization/detail/(:num)
                                        </small>

                                    </div>
                                </div>


                                <!-- CONTROLLER -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Controller</label>
                                        <input type="text" name="controller" id="controller"
                                            class="form-control"
                                            value="<?= old('controller'); ?>"
                                            placeholder="Organization"
                                            required>

                                    </div>
                                </div>


                                <!-- METHOD -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Controller Method</label>
                                        <input type="text" name="method" id="method" class="form-control"
                                            value="<?= old('method'); ?>"
                                            placeholder="index"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <!-- BUTTON -->
                            <div class="text-center mt-5">
                                <a href="<?= base_url('route'); ?>" class="btn btn-default-light">
                                    <i class="fa fa-window-close"></i>
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-teal">
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

<!--INTERNAL  FORMELEMENTS JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

<!-- INTERNAL  FILE UPLOADES JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/fileupload.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/fileuploads/js/file-upload.js"></script>

<!-- INTERNAL ACCORDION JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/accordion/accordion.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#page_id').on('change', function() {

        const pageName = $(this)
            .find('option:selected')
            .text()
            .trim();

        if (!pageName || pageName === '-- Select Page --') {
            $('#controller').val('');
            return;
        }

        $('#controller').val(pageName);
    });

    $(document).ready(function() {

        /*
        |--------------------------------------------------------------------------
        | PAGE → CONTROLLER
        |--------------------------------------------------------------------------
        */
        $('#page_id').on('change', function() {

            const pageName = $('#page_id option:selected').text().trim();

            if (!pageName || pageName === '-- Select Page --') {
                $('#controller').val('');
                return;
            }

            $('#controller').val(pageName);
        });


        /*
        |--------------------------------------------------------------------------
        | SUBMIT FORM
        |--------------------------------------------------------------------------
        */

        $('#routeForm').on('submit', function(e) {

            e.preventDefault();

            const form = $(this);
            const btn = $('#btnSave');

            /*
            |--------------------------------------------------------------------------
            | HTML5 VALIDATION
            |--------------------------------------------------------------------------
            */
            if (!this.checkValidity()) {
                this.reportValidity();
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CONFIRM
            |--------------------------------------------------------------------------
            */
            Swal.fire({
                title: 'Save Route?',
                text: 'Data route akan disimpan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Save',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | DISABLE BUTTON
                |--------------------------------------------------------------------------
                */
                btn.prop('disabled', true);
                btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');


                /*
                |--------------------------------------------------------------------------
                | AJAX
                |--------------------------------------------------------------------------
                */
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href =
                                    '<?= base_url('route'); ?>';
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Gagal menyimpan route.'
                            });
                        }
                    },

                    error: function(xhr) {
                        let message = 'Terjadi kesalahan server.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    },

                    complete: function() {
                        btn.prop('disabled', false);
                        btn.html('<i class="fa fa-save"></i> Save');
                    }
                });
            });
        });
    });
</script>