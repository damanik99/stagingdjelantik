<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>LogiMove — Shipment Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/mobile.css" rel="stylesheet" />

    <?php /** @var array $shipment */ ?>
    <?php /** @var string $completedDestination */ ?>
    <?php /** @var string $totalDestination */ ?>
    <?php /** @var string $progress */ ?>
    <?php /** @var array $details */ ?>

</head>

<body>

    <div class="phone-frame">
        <div class="screen" style="display:flex;">
            <!-- Header -->
            <div class="app-header">
                <a href="<?= base_url('driver/index') ?>" class="back-btn">
                    <i class="bi bi-arrow-left"></i>
                </a>

                <span class="title">Shipment Detail</span>
            </div>

            <!-- Main Content -->
            <div class="main-content has-action-bar">
                <!-- Summary Card -->
                <div class="dest-summary mb-12">
                    <div class="d-flex justify-between align-center mb-8">
                        <span class="fw-700" style="font-size:0.95rem;">
                            <?= esc($shipment['shipment_number']) ?>
                        </span>

                        <?php
                        $shipmentStatus = strtoupper(
                            $shipment['status_code'] ?? ''
                        );

                        if ($shipmentStatus === 'SCMPL') {
                            $badgeClass = 'badge-completed';
                            $dotClass = 'green';
                            $statusText = 'COMPLETED';
                        } elseif ($shipmentStatus === 'RTDT') {
                            $badgeClass = 'badge-on-delivery';
                            $dotClass = 'orange';
                            $statusText = 'IN PROGGRES';
                        } elseif ($shipmentStatus === 'SDLPN') {
                            $badgeClass = 'badge-delivery';
                            $dotClass = 'green';
                            $statusText = 'DELIVERY';
                        } else {
                            $badgeClass = 'badge-pending';
                            $dotClass = 'gray';
                            $statusText = $shipmentStatus ?: 'PENDING';
                        }
                        ?>

                        <span class="badge-status <?= $badgeClass ?>">
                            <span class="status-dot <?= $dotClass ?>"></span>
                            <?= esc($statusText) ?>
                        </span>

                    </div>


                    <!-- Driver & Vehicle -->
                    <div class="d-flex gap-8 align-center mb-8" style="font-size:0.85rem;">
                        <span>
                            👤
                            <strong>
                                <?= esc($shipment['driver_name'] ?? '-') ?>
                            </strong>
                        </span>

                        <span>
                            🚛
                            <strong>
                                <?= esc($shipment['plate_number'] ?? '-') ?>
                            </strong>
                        </span>
                    </div>


                    <!-- Progress -->
                    <span style="font-size:0.85rem;font-weight:600;">
                        <?= $completedDestination ?>
                        /
                        <?= $totalDestination ?>
                        Tujuan
                    </span>

                    <div class="progress-custom mt-8">
                        <div
                            class="fill"
                            style="width:<?= $progress ?>%;"></div>
                    </div>

                </div>

                <?php
                $allPickupCompleted = true;

                foreach ($details as $detail) {
                    $activityType = strtoupper($detail['activity_type'] ?? '');
                    $detailStatus = strtoupper($detail['status_code'] ?? '');

                    if (
                        $activityType === 'PICKUP'
                        && $detailStatus !== 'SCMPL'
                    ) {
                        $allPickupCompleted = false;
                        break;
                    }
                }
                ?>

                <!-- Destination List -->
                <?php foreach ($details as $index => $detail): ?>

                    <?php
                    $activityType = strtoupper(
                        $detail['activity_type'] ?? ''
                    );

                    $detailStatus = strtoupper(
                        $detail['status_code'] ?? ''
                    );


                    /*
                    * Nama destination
                    */
                    if ($activityType === 'PICKUP') {

                        $destinationName =
                            $detail['organization_name'] ?? '-';
                    } elseif ($activityType === 'DROPOFF') {

                        $destinationName =
                            $detail['warehouse_name'] ?? '-';
                    } else {

                        $destinationName =
                            $detail['warehouse_name']
                            ?? $detail['organization_name']
                            ?? '-';
                    }

                    /*
                    * Address
                    */
                    if ($activityType === 'PICKUP') {

                        $destinationAddress =
                            $detail['address'] ?? '-';
                    } else {

                        $destinationAddress =
                            $detail['warehouse_address']
                            ?? $detail['address']
                            ?? '-';
                    }

                    /*
                    * Status UI
                    */
                    if ($detailStatus === 'SCMPL') {

                        $timelineClass = 'completed';
                        $statusClass   = 'done';
                        $statusText    = '✓ Completed';
                    } elseif (
                        $detailStatus === 'RTDT'
                        || $detailStatus === 'INPRS'
                    ) {

                        $timelineClass = '';
                        $statusClass   = 'now';

                        if ($activityType === 'PICKUP') {
                            $statusText = '● Pickup';
                        } else {
                            $statusText = '● Pending';
                        }
                    } elseif ($detailStatus === 'SDLPN') {

                        $timelineClass = '';
                        $statusClass   = 'delivery';
                        $statusText    = '● Delivery';
                    } else {

                        $timelineClass = '';
                        $statusClass   = 'wait';
                        $statusText    = '○ Pending';
                    }

                    /*
                    * Tentukan apakah destination boleh diklik
                    *
                    * PICKUP:
                    *   RTDT / INPRS / SDLPN → boleh
                    *
                    * DROPOFF:
                    *   hanya boleh setelah semua PICKUP SCMPL
                    *   dan statusnya RTDT / INPRS / SDLPN
                    */
                    $isCurrent = false;

                    if ($activityType === 'PICKUP') {

                        if (
                            $detailStatus === 'RTDT'
                            || $detailStatus === 'INPRS'
                            || $detailStatus === 'SDLPN'
                        ) {
                            $isCurrent = true;
                        }
                    } elseif ($activityType === 'DROPOFF') {

                        if (
                            $allPickupCompleted
                            && (
                                $detailStatus === 'RTDT'
                                || $detailStatus === 'INPRS'
                                || $detailStatus === 'SDLPN'
                            )
                        ) {
                            $isCurrent = true;
                        }
                    }
                    ?>


                    <?php if ($isCurrent): ?>

                        <a
                            href="<?= base_url(
                                        'driver/destination/' .
                                            $detail['shipment_detail_id']
                                    ) ?>"
                            class="timeline-item <?= $timelineClass ?>">

                        <?php else: ?>

                            <div class="timeline-item <?= $timelineClass ?>">

                            <?php endif; ?>


                            <!-- Activity -->
                            <div class="timeline-label">
                                <?= esc($activityType) ?>
                            </div>


                            <!-- Destination Name -->
                            <div class="timeline-name">
                                <?= esc($destinationName) ?>
                            </div>


                            <!-- Address -->
                            <div class="timeline-addr">
                                <?= esc($destinationAddress) ?>
                            </div>


                            <!-- Status -->
                            <div class="timeline-status <?= $statusClass ?>">
                                <?= esc($statusText) ?>
                            </div>


                            <!-- Action -->
                            <?php if ($isCurrent): ?>

                                <span class="btn-timeline-action">
                                    Lihat Tujuan →
                                </span>

                            <?php endif; ?>


                            <?php if ($isCurrent): ?>

                        </a>

                    <?php else: ?>

            </div>

        <?php endif; ?>

    <?php endforeach; ?>
        </div>

        <!-- Bottom Action Bar -->
        <?php
        /*
                * Cari destination pertama yang belum COMPLETED.
                * Ini yang akan menjadi tujuan berikutnya.
                */
        $nextDestination = null;

        foreach ($details as $detail) {

            $activityType = strtoupper(
                $detail['activity_type'] ?? ''
            );

            $detailStatus = strtoupper(
                $detail['status_code'] ?? ''
            );

            if ($detailStatus === 'SCMPL') {
                continue;
            }

            /*
                * PICKUP boleh dimulai.
                */
            if ($activityType === 'PICKUP') {

                $nextDestination = $detail;
                break;
            }

            /*
                * DROPOFF hanya boleh dimulai
                * setelah semua PICKUP selesai.
                */
            if (
                $activityType === 'DROPOFF'
                && $allPickupCompleted
            ) {

                $nextDestination = $detail;
                break;
            }
        }
        ?>

        <?php if ($nextDestination): ?>
            <div class="bottom-action-bar">
                <a href="<?= base_url(
                                'driver/destination/' . $nextDestination['shipment_detail_id']
                            ) ?>"
                    class="btn-action btn-action-primary d-block text-center">
                    MULAI TUJUAN
                    <?= esc($nextDestination['sequence_no']) ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
    </div>
</body>

</html>