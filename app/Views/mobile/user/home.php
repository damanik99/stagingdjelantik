<!-- MAIN -->
<?= $this->include('mobile/layout/main') ?>
<!-- MAIN END -->

<header class="app-header">
    <div class="greeting-wrap">
        <div>
            <div class="greeting-label">Selamat Datang,</div>
            <div class="greeting-name">PKK 001</div>
        </div>
    </div>
    <div class="avatar" style="cursor:pointer;" onclick="location.href='profile.html'">PK</div>
</header>

<main class="main-content">

    <!-- Active pickup request -->
    <div class="active-request">
        <div class="ar-icon"><i class="bi bi-truck"></i></div>
        <div class="ar-info">
            <div class="fw-700 fs-sm">Pickup Request Aktif</div>
            <div class="fs-sm fw-700 text-primary-c">125 Liter</div>
            <div class="fs-xs text-muted">● Menunggu driver · REQ-20260821-001</div>
        </div>

        <a href="pickup-status.html" class="btn-outline" style="width:auto;padding:8px 14px;font-size:0.75rem;flex-shrink:0;">
            LIHAT STATUS
        </a>
    </div>

    <!-- Total minyak terkumpul -->
    <div class="summary-card">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="summary-label">Total Minyak Terkumpul</div>
                <div class="big-number">1,250 <span class="unit">Liter</span></div>
            </div>
            <i class="bi bi-droplet-fill" style="font-size:1.6rem;color:var(--primary-light);"></i>
        </div>
        <div class="mt-2">
            <span class="trend-chip"><i class="bi bi-arrow-up-short"></i> +125 Liter bulan ini</span>
        </div>
    </div>

    <!-- Collection hari ini -->
    <div class="mini-stats mb-2">
        <div class="mini-stat">
            <div class="stat-value">125</div>
            <div class="stat-label">Liter Hari Ini</div>
        </div>
        <div class="mini-stat">
            <div class="stat-value">5</div>
            <div class="stat-label">Rumah</div>
        </div>
        <div class="mini-stat">
            <div class="stat-value">14:30</div>
            <div class="stat-label">Terakhir</div>
        </div>
    </div>

    <!-- Quick action -->
    <div class="quick-actions mt-3">
        <a href="collect-oil.html" class="quick-action-btn qa-primary">
            <div class="qa-icon"><i class="bi bi-plus-lg"></i></div>
            <div class="qa-label">Collect Oil</div>
        </a>
        <a href="request-pickup.html" class="quick-action-btn">
            <div class="qa-icon"><i class="bi bi-truck"></i></div>
            <div class="qa-label">Request Pickup</div>
        </a>
    </div>

    <!-- Ranking mini -->
    <div class="card-app d-flex align-items-center" onclick="location.href='top-rank.html'" style="margin-top:2px;">
        <div class="rank-badge rx" style="width:40px;height:40px;">#08</div>
        <div class="flex-1 ms-2">
            <div class="fw-700 fs-sm">Ranking PKK Anda</div>
            <div class="fs-xs text-muted">Peringkat #8 dari 24 PKK</div>
        </div>
        <i class="bi bi-chevron-right text-muted"></i>
    </div>

</main>

<!-- MAIN -->
<?= $this->include('mobile/layout/footer') ?>
<!-- MAIN END -->