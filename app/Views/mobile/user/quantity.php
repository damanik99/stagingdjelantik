<?= $this->include('mobile/layout/main') ?>

<header class="app-header"><a href="<?= base_url('mobile/user/collectoil') ?>" class="back-btn"><i class="bi bi-arrow-left"></i></a><span class="title">Quantity Pickup</span></header>
<main class="main-content has-action-bar">
    <div id="quantity-message"><?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif ?></div>
    <div class="card-app d-flex align-items-center gap-2"><div class="avatar"><?= esc(strtoupper(substr($resident['resident_name'], 0, 2))) ?></div><div><div class="fw-700 fs-sm"><?= esc($resident['resident_name']) ?></div><div class="fs-xs text-muted"><?= esc($resident['resident_code']) ?></div></div></div>
    <p class="text-center text-muted fw-600 fs-sm mb-3 mt-2">Masukkan jumlah minyak yang dikumpulkan</p>
    <form id="quantity-form">
        <?= csrf_field() ?>
        <input type="hidden" name="resident_id" value="<?= (int) $resident['resident_id'] ?>">
        <input type="hidden" name="unit" value="<?= esc($unit, 'attr') ?>">
        <input type="text" inputmode="decimal" name="qty" class="qty-input-lg" id="qty-input" value="<?= esc($draft['qty'] ?? '') ?>" placeholder="0">
    </form>
    <p class="text-center text-muted fw-700 mt-2 mb-0"><?= esc(ucfirst(strtolower($unit))) ?></p>
    <div class="quick-qty"><span class="chip" data-qty="5">5</span><span class="chip" data-qty="10">10</span><span class="chip" data-qty="15">15</span><span class="chip" data-qty="20">20</span></div>
</main>
<div class="bottom-action-bar"><button type="button" id="btn-documentation" class="btn-action btn-action-primary">LANJUT → DOKUMENTASI</button></div>

<?= $this->include('mobile/layout/footer') ?>
<script>
$(function () {
    function showError(message) { $('#quantity-message').html('<div class="alert alert-danger">' + $('<div>').text(message).html() + '</div>'); }
    $('.chip').on('click', function () { $('#qty-input').val($(this).data('qty')); });
    $('#btn-documentation').on('click', function () {
        const qty = Number($('#qty-input').val()); if (!Number.isFinite(qty) || qty <= 0) { showError('Quantity harus lebih dari 0.'); return; }
        const $button = $(this).prop('disabled', true);
        $.ajax({ url: '<?= base_url('mobile/user/quantitymobile/save') ?>', method: 'POST', data: $('#quantity-form').serialize(), dataType: 'json' })
            .done(function (response) { if (response.success) window.location.href = response.redirect; else { showError(response.message); $button.prop('disabled', false); } })
            .fail(function (xhr) { showError((xhr.responseJSON || {}).message || 'Gagal menyimpan quantity.'); $button.prop('disabled', false); });
    });
});
</script>
