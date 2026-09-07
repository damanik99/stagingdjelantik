<?= $this->include('mobile/layout/main') ?>

<style>
    .mobile-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        opacity: 0;
        visibility: hidden;
        transition: all .25s ease;
        z-index: 9998
    }

    .mobile-bottom-sheet {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        max-width: 600px;
        margin: auto;
        background: #fff;
        border-radius: 20px 20px 0 0;
        transform: translateY(110%);
        transition: transform .3s ease;
        z-index: 9999;
        max-height: 90vh;
        display: flex;
        flex-direction: column
    }

    .mobile-modal-overlay.show {
        opacity: 1;
        visibility: visible
    }

    .mobile-bottom-sheet.show {
        transform: translateY(0)
    }

    .bottom-sheet-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1
    }

    .bottom-sheet-footer {
        padding: 16px 20px;
        border-top: 1px solid #eee;
        background: #fff
    }
</style>

<header class="app-header">
    <a href="<?= base_url('mobile/user/home') ?>" class="back-btn"><i class="bi bi-arrow-left"></i></a>
    <span class="title">Collect Minyak Jelantah</span>
</header>

<main class="main-content has-action-bar">
    <div id="page-message"><?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif ?></div>

    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" class="form-control" placeholder="Cari nama / kode warga..." id="search-input">
    </div>

    <input type="hidden" id="selected-resident-id" value="<?= esc($draft['resident_id'] ?? '') ?>">
    <div class="card-app d-none" id="selected-card" style="background:var(--primary-light);border:1.5px solid var(--primary);">
        <div class="d-flex align-items-center gap-2">
            <div class="check-circle"><i class="bi bi-check"></i></div>
            <div>
                <div class="fw-700 fs-sm" id="sel-name"></div>
                <div class="fs-xs text-muted" id="sel-id"></div>
            </div>
        </div>
    </div>

    <div class="fw-700 fs-sm mb-2 mt-2">Pilih Warga</div>
    <div id="resident-results">
        <?php foreach ($residents as $resident): ?>
            <div class="warga-item" data-resident-id="<?= (int) $resident['resident_id'] ?>" data-resident-name="<?= esc($resident['resident_name'], 'attr') ?>" data-resident-code="<?= esc($resident['resident_code'], 'attr') ?>">
                <div class="avatar"><?= esc(strtoupper(substr($resident['resident_name'], 0, 2))) ?></div>
                <div class="warga-info">
                    <div class="warga-name"><?= esc($resident['resident_name']) ?></div>
                    <div class="warga-id">PKK Resident ID: <?= esc($resident['resident_code']) ?></div>
                </div>
                <div class="check-circle"><i class="bi bi-check"></i></div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="section-label mb-2">Warga baru?</div>
    <button type="button" id="btnTambahWarga" class="btn btn-sm text-white" style="background-color:#138496;border-color:#138496;"><i class="bi bi-person-plus"></i> Tambah Warga</button>

    <div id="modalTambahWargaOverlay" class="mobile-modal-overlay"></div>
    <div id="modalTambahWarga" class="mobile-bottom-sheet" role="dialog" aria-modal="true" aria-labelledby="modalTambahWargaTitle">
        <form id="resident-form">
            <?= csrf_field() ?>
            <div class="bottom-sheet-body">
                <h5 id="modalTambahWargaTitle" class="fw-700 mb-3">Tambah Warga</h5>
                <div id="resident-form-message"></div>
                <div class="mb-3"><label class="form-label">Nama Warga <span class="text-danger">*</span></label><input type="text" name="resident_name" id="resident_name" class="form-control" maxlength="150" required></div>
                <div class="mb-3"><label class="form-label">Nomor WhatsApp / HP <span class="text-danger">*</span></label><input type="text" name="phone" id="resident_phone" class="form-control" maxlength="30" required></div>
                <div class="mb-3"><label class="form-label">Address <span class="text-danger">*</span></label><textarea name="address" id="resident_address" class="form-control" rows="3" required></textarea></div>
            </div>
            <div class="bottom-sheet-footer">
                <button type="button" id="btnCancelTambahWarga" class="btn btn-light w-100 mb-2">Batal</button>
                <button type="submit" id="btnSimpanWarga" class="btn btn-primary w-100">Simpan Warga</button>
            </div>
        </form>
    </div>
</main>

<div class="bottom-action-bar"><button type="button" id="btn-quantity" class="btn-action btn-action-primary">LANJUT KE QUANTITY</button></div>

<?= $this->include('mobile/layout/footer') ?>

<script>
    $(function() {
        let searchTimer;
        const $modal = $('#modalTambahWarga');
        const $overlay = $('#modalTambahWargaOverlay');

        function showMessage(selector, message, type) {
            $(selector).html('<div class="alert alert-' + type + '">' + $('<div>').text(message).html() + '</div>');
        }

        function openModal() {
            $modal.addClass('show');
            $overlay.addClass('show');
            $('body').css('overflow', 'hidden');
        }

        function closeModal() {
            $modal.removeClass('show');
            $overlay.removeClass('show');
            $('body').css('overflow', '');
        }

        function initials(name) {
            return name.trim().split(/\s+/).slice(0, 2).map(function(word) {
                return word.charAt(0);
            }).join('').toUpperCase();
        }

        function escapeHtml(value) {
            return $('<div>').text(value).html();
        }

        function escapeAttribute(value) {
            return escapeHtml(value).replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        function residentHtml(resident) {
            return '<div class="warga-item" data-resident-id="' + Number(resident.resident_id) + '" data-resident-name="' + escapeAttribute(resident.resident_name) + '" data-resident-code="' + escapeAttribute(resident.resident_code) + '">' +
                '<div class="avatar">' + escapeHtml(initials(resident.resident_name)) + '</div><div class="warga-info"><div class="warga-name">' + escapeHtml(resident.resident_name) + '</div><div class="warga-id">PKK Resident ID: ' + escapeHtml(resident.resident_code) + '</div></div><div class="check-circle"><i class="bi bi-check"></i></div></div>';
        }

        function selectResident($item) {
            $('.warga-item').removeClass('selected');
            $item.addClass('selected');
            $('#selected-resident-id').val($item.data('resident-id'));
            $('#sel-name').text($item.data('resident-name'));
            $('#sel-id').text($item.data('resident-code'));
            $('#selected-card').removeClass('d-none');
        }

        $(document).on('click', '.warga-item', function() {
            selectResident($(this));
        });
        $('#btnTambahWarga').on('click', openModal);
        $('#btnCancelTambahWarga, #modalTambahWargaOverlay').on('click', closeModal);
        $('#search-input').on('input', function() {
            const keyword = $(this).val();
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                $.getJSON('<?= base_url('mobile/user/collectoil/search-resident') ?>', {
                        q: keyword
                    })
                    .done(function(response) {
                        $('#resident-results').html(response.residents.length ? response.residents.map(residentHtml).join('') : '<div class="text-muted fs-sm">Warga tidak ditemukan.</div>');
                    })
                    .fail(function() {
                        showMessage('#page-message', 'Gagal mencari warga. Periksa koneksi Anda.', 'danger');
                    });
            }, 400);
        });
        $('#resident-form').on('submit', function(event) {
            event.preventDefault();
            const $button = $('#btnSimpanWarga');
            $button.prop('disabled', true);
            $('#resident-form-message').empty();
            $.ajax({
                    url: '<?= base_url('mobile/user/collectoil/save-resident') ?>',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json'
                })
                .done(function(response) {
                    if (!response.success) {
                        showMessage('#resident-form-message', response.message, 'danger');
                        return;
                    }
                    const $item = $(residentHtml(response.resident));
                    $('#resident-results').prepend($item);
                    selectResident($item);
                    $('#resident-form')[0].reset();
                    closeModal();
                    showMessage('#page-message', response.message, 'success');
                }).fail(function(xhr) {
                    const response = xhr.responseJSON || {};
                    showMessage('#resident-form-message', response.message || 'Gagal menyimpan warga.', 'danger');
                })
                .always(function() {
                    $button.prop('disabled', false);
                });
        });
        $('#btn-quantity').on('click', function() {
            const residentId = $('#selected-resident-id').val();
            if (!residentId) {
                showMessage('#page-message', 'Warga belum dipilih.', 'danger');
                return;
            }
            window.location.href = '<?= base_url('mobile/user/quantitymobile') ?>?resident_id=' + encodeURIComponent(residentId);
        });

        const selectedId = $('#selected-resident-id').val();
        if (selectedId) {
            const $selected = $('.warga-item[data-resident-id="' + selectedId + '"]');
            if ($selected.length) selectResident($selected);
        }
    });
</script>