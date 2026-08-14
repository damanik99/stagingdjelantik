<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Djelantik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/mobile.css" rel="stylesheet" />
</head>

<?php /** @var array $shipments */ ?>

<body>

    <div class="phone-frame">

        <!-- Offline Banner (hidden by default) -->
        <div class="offline-banner" id="offline-banner" style="display:none;">
            <i class="bi bi-wifi-off"></i> Offline — Data akan dikirim ketika koneksi tersedia.
        </div>

        <!-- Sync Banner (hidden by default) -->
        <div class="sync-banner" id="sync-banner" style="display:none;">
            <i class="bi bi-arrow-repeat"></i> Syncing...
        </div>

        <div class="screen" style="display:flex;">
            <!-- Header -->
            <div class="app-header">
                <span class="title">Djelantik Driver</span>
                <button class="more-btn"><i class="bi bi-bell"></i></button>
            </div>

            <!-- Main Content -->
            <div class="main-content">

                <!-- Filter Pills -->
                <div class="filter-pills">
                    <span class="filter-pill active">Semua</span>
                    <span class="filter-pill">Aktif</span>
                    <span class="filter-pill">Selesai</span>
                </div>

                <?php foreach ($shipments as $shipment): ?>

                    <?php
                        $statusCode = strtoupper($shipment['status_code'] ?? '');

                        // Status badge
                        switch ($statusCode) {
                            case 'SCMPL':
                                $badgeClass = 'badge-completed';
                                $dotClass   = 'green';
                                $statusText = 'COMPLETED';
                                break;

                            case 'RTDT':
                                $badgeClass = 'badge-on-delivery';
                                $dotClass   = 'orange';
                                $statusText = 'IN PROGGRES';
                                break;
                            case 'SDLPN':
                                $badgeClass = 'badge-delivery';
                                $dotClass = 'green';
                                $statusText = 'DELIVERY';
                                break;
                            default:
                                $badgeClass = 'badge-pending';
                                $dotClass   = 'gray';
                                $statusText = $statusCode ?: 'PENDING';
                                break;
                        }

                        $totalDestination     = $shipment['total_destination'] ?? count($shipment['details']);
                        $completedDestination = $shipment['completed_destination'] ?? 0;
                        $progress             = $shipment['progress'] ?? 0;
                    ?>

                    <a href="<?= base_url('driver/detail/' . $shipment['shipment_id']) ?>"
                        class="card-shipment">

                        <!-- Shipment Header -->
                        <div class="d-flex justify-between align-center mb-8">
                            <span class="shipment-id">
                                <?= esc($shipment['shipment_number']) ?>
                            </span>

                            <span class="badge-status <?= $badgeClass ?>">
                                <span class="status-dot <?= $dotClass ?>"></span>
                                <?= esc($statusText) ?>
                            </span>

                        </div>


                        <!-- Route -->
                        <div class="route-mini">
                            <?php foreach ($shipment['details'] as $index => $detail): ?>
                                <?php
                                    $isLast = ($index === count($shipment['details']) - 1);
                                    /*
                                    * PICKUP  -> organization
                                    * DROPOFF -> warehouse
                                    * TRANSFER -> warehouse / organization
                                    */
                                    if ($detail['activity_type'] === 'PICKUP') {
                                        $destination = $detail['organization_name'] ?? '-';
                                    } elseif ($detail['activity_type'] === 'DROPOFF') {
                                        $destination = $detail['warehouse_name'] ?? '-';
                                    } else {
                                        $destination =
                                            $detail['warehouse_name']
                                            ?? $detail['organization_name']
                                            ?? '-';
                                    }

                                    // Warna dot berdasarkan status detail
                                    $detailStatus = strtoupper($detail['status_code'] ?? '');
                                    // var_dump($detail['status_code']);exit;
                                    if ($detailStatus === 'SCMPL') {
                                        $dotColor = '#4caf91';
                                    } elseif ($detailStatus === 'RTDT') {
                                        $dotColor = '#f57c00';
                                    } else {
                                        $dotColor = '#9ca3af';
                                    }
                                ?>

                                <div class="route-stop">
                                    <span
                                        class="dot-mini"
                                        style="background:<?= $dotColor ?>;"
                                    ></span>

                                    <?= esc($destination) ?>
                                </div>

                                <?php if (!$isLast): ?>
                                    <div class="route-arrow">↓</div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>


                        <!-- Footer -->
                        <div class="d-flex justify-between align-center mt-8">

                            <span style="font-size:0.78rem;color:var(--text-muted);">
                                <?= $completedDestination ?>
                                /
                                <?= $totalDestination ?>
                                tujuan
                            </span>

                            <span style="font-size:0.78rem;font-weight:600;color:var(--primary);">
                                Lihat Detail →
                            </span>

                        </div>


                        <!-- Progress -->
                        <div class="progress-custom mt-8">
                            <div
                                class="fill"
                                style="width:<?= $progress ?>%;"
                            ></div>
                        </div>

                    </a>

                <?php endforeach; ?>

            </div>

            <!-- Bottom Navigation -->
            <div class="bottom-nav">
                <a href="shipment-list.html" class="nav-item active">
                    <i class="bi bi-house-door-fill"></i> Home
                </a>
                <a href="shipment-list.html" class="nav-item">
                    <i class="bi bi-box-seam-fill"></i> Shipment
                </a>
                <a href="#" class="nav-item">
                    <i class="bi bi-clock-history"></i> History
                </a>
                <a href="#" class="nav-item">
                    <i class="bi bi-person"></i> Profile
                </a>
            </div>
        </div><!-- /screen -->

    </div><!-- /phone-frame -->

    <script>
        // ── Filter Pills ──
        document.querySelectorAll('.filter-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                // In real app: filter shipment cards based on selection
            });
        });
        // ── Offline Simulation (toggle with comment/uncomment) ──
        // Uncomment below to test offline banner:
        // document.getElementById('offline-banner').style.display = 'flex';
        // document.getElementById('sync-banner').style.display = 'flex';
    </script>

</body>

</html>