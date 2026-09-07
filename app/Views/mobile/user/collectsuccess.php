<?= $this->include('mobile/layout/main') ?>

<main class="main-content no-nav text-center d-flex flex-column justify-content-center" style="min-height:100dvh;">
    <div class="completed-check"><i class="bi bi-check-lg"></i></div>
    <h5 class="fw-800 mb-2">Pickup Completed</h5>
    <div class="card-app" style="max-width:300px;margin:0 auto 12px;">
        <div class="info-row"><span class="info-label">Collected by</span><span class="info-value"><?= esc($collection['fullname']) ?></span></div>
        <div class="info-row"><span class="info-label">Quantity</span><span class="info-value text-primary-c"><?= esc(number_format((float) $collection['qty'], 3, '.', '')) ?> <?= esc(ucfirst(strtolower($collection['unit']))) ?></span></div>
        <div class="info-row"><span class="info-label">Date</span><span class="info-value"><?= esc(date('d M Y · H:i', strtotime($collection['visit_date'] . ' ' . $collection['visit_time']))) ?></span></div>
    </div>
    <div class="card-app" style="max-width:300px;margin:0 auto 20px;background:var(--primary-light);border:1.5px solid var(--primary);">
        <div class="section-label">Total Minyak Terkumpul</div>
        <div class="section-value" style="font-size:1.4rem;color:var(--primary);"><?= esc(number_format((float) $collection['total_qty'], 3, '.', '')) ?> Liter</div>
        <div class="fs-xs text-muted">Stok di PKK sudah diambil driver</div>
    </div>
    <a href="<?= base_url('mobile/user/home') ?>" class="btn-action btn-action-primary" style="width:100%;max-width:300px;margin:0 auto;text-decoration:none;">KEMBALI KE HOME</a>
</main>

<?= $this->include('mobile/layout/footer') ?>