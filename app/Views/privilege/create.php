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
                        <a href="<?= base_url() ?>Privilege">Privilege</a>
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

                    <div class="card-header">
                        <h3 class="card-title">
                            Privilege Management
                        </h3>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <!-- GROUP -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Group
                                    </label>

                                    <select
                                        name="group_id"
                                        id="group_id"
                                        class="form-control">
                                        <option value="">
                                            -- Select Group --
                                        </option>

                                        <?php foreach ($groups as $group): ?>
                                            <option value="<?= $group['group_id']; ?>">
                                                <?= esc($group['group_name']); ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>

                        </div>


                        <!-- PERMISSION -->
                        <div class="row mt-4">

                            <div class="col-md-12">

                                <div class="table-responsive">

                                    <table
                                        id="privilegeTable"
                                        class="table table-bordered table-hover">

                                        <thead>
                                            <tr>

                                                <th style="width: 30%;">
                                                    Page
                                                </th>

                                                <?php foreach ($actions as $action): ?>

                                                    <th class="text-center">
                                                        <?= esc(ucfirst($action['name'])); ?>

                                                        <div class="mt-2">

                                                            <input
                                                                type="checkbox"
                                                                class="check-all-action"
                                                                data-action-id="<?= $action['action_id']; ?>">

                                                        </div>
                                                    </th>

                                                <?php endforeach; ?>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php foreach ($pages as $page): ?>

                                                <tr>

                                                    <td>
                                                        <strong>
                                                            <?= esc($page['name']); ?>
                                                        </strong>
                                                    </td>

                                                    <?php foreach ($actions as $action): ?>

                                                        <td class="text-center">

                                                            <input
                                                                type="checkbox"
                                                                class="permission-checkbox"
                                                                data-page-id="<?= $page['page_id']; ?>"
                                                                data-action-id="<?= $action['action_id']; ?>">

                                                        </td>

                                                    <?php endforeach; ?>

                                                </tr>

                                            <?php endforeach; ?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>


                        <!-- BUTTON -->
                        <div class="text-center mt-5">

                            <a
                                href="<?= base_url('/Privilege'); ?>"
                                class="btn btn-default-light">
                                <i class="fa fa-window-close"></i>
                                Cancel
                            </a>

                            <button
                                type="button"
                                id="btnSave"
                                class="btn btn-teal"
                                disabled>
                                <i class="fa fa-save"></i>
                                Save
                            </button>

                        </div>

                    </div>
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
    let currentGroupId = null;

    /*
    |--------------------------------------------------------------------------
    | GROUP CHANGE
    |--------------------------------------------------------------------------
    */
    $('#group_id').on('change', function() {

        const groupId = $(this).val();
        currentGroupId = groupId;

        /*
         * Reset checkbox
         */
        $('.permission-checkbox').prop('checked', false);
        $('.check-all-action').prop('checked', false);

        /*
         * Enable / disable save
         */
        $('#btnSave').prop(
            'disabled',
            !groupId
        );

        if (!groupId) {
            return;
        }

        /*
         * Get existing permission
         */
        $.ajax({

            url: '<?= base_url('Privilege/getByGroup'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                group_id: groupId
            },

            success: function(response) {

                if (!response.status) {
                    return;
                }
                /*
                 * Set checked permission
                 */
                $.each(
                    response.permission,
                    function(key) {

                        const parts = key.split('_');

                        const pageId = parts[0];
                        const actionId = parts[1];

                        $(
                            '.permission-checkbox' +
                            '[data-page-id="' + pageId + '"]' +
                            '[data-action-id="' + actionId + '"]'
                        ).prop(
                            'checked',
                            true
                        );

                    }
                );

                refreshCheckAll();

            },

            error: function() {

                alert(
                    'Gagal mengambil permission.'
                );

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | CHECK ALL ACTION
    |--------------------------------------------------------------------------
    */
    $(document).on(
        'change',
        '.check-all-action',
        function() {

            const actionId = $(this).data('action-id');
            const checked = $(this).is(':checked');

            $('.permission-checkbox' + '[data-action-id="' + actionId + '"]').prop(
                'checked', checked
            );

        }
    );

    /*
    |--------------------------------------------------------------------------
    | CHECKBOX CHANGE
    |--------------------------------------------------------------------------
    */
    $(document).on(
        'change',
        '.permission-checkbox',
        function() {

            refreshCheckAll();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | REFRESH CHECK ALL
    |--------------------------------------------------------------------------
    */
    function refreshCheckAll() {
        $('.check-all-action').each(function() {

            const actionId = $(this).data('action-id');

            const total = $(
                '.permission-checkbox' +
                '[data-action-id="' + actionId + '"]'
            ).length;

            const checked = $(
                '.permission-checkbox' +
                '[data-action-id="' + actionId + '"]:checked'
            ).length;


            $(this).prop(
                'checked',
                total > 0 && total === checked
            );

        });
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    */
    $('#btnSave').on('click', function() {

        if (!currentGroupId) {

            alert('Silakan pilih group terlebih dahulu.');

            return;
        }

        const permissions = [];

        $('.permission-checkbox:checked').each(
            function() {

                permissions.push({
                    page_id: $(this).data('page-id'),
                    action_id: $(this).data('action-id')

                });
            }
        );

        $.ajax({

            url: '<?= base_url('Privilege/save'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                group_id: currentGroupId,
                permission: permissions
            },
            beforeSend: function() {
                $('#btnSave').prop(
                    'disabled',
                    true
                );
            },
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan permission.');
            },
            complete: function() {
                $('#btnSave').prop(
                    'disabled',
                    false
                );
            }
        });
    });
</script>