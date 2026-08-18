<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Destination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/teamplate/assets/mobile.css" rel="stylesheet" />
    <?php /** @var array $destination */ ?>
    <?php /** @var array $totalDestination */ ?>
    <?php /** @var array $destinationStatus */ ?>
</head>

<body>

    <?php

    /*
        * Data destination
        */
    $activityType = strtoupper($destination['activity_type'] ?? '');

    $destinationStatus = strtoupper(
        $destination['status_code'] ?? ''
    );

    /*
        * Tentukan nama destination
        */
    if ($activityType === 'PICKUP') {

        $destinationName =
            $destination['organization_name'] ?? '-';

        $destinationAddress =
            $destination['organization_address'] ?? '-';

        $latitude =
            $destination['organization_latitude'] ?? null;

        $longitude =
            $destination['organization_longitude'] ?? null;
    } elseif ($activityType === 'DROPOFF') {

        $destinationName =
            $destination['warehouse_name'] ?? '-';

        $destinationAddress =
            $destination['warehouse_address'] ?? '-';

        $latitude =
            $destination['warehouse_latitude'] ?? null;

        $longitude =
            $destination['warehouse_longitude'] ?? null;
    } else {

        $destinationName =
            $destination['organization_name']
            ?? $destination['warehouse_name']
            ?? '-';

        $destinationAddress =
            $destination['organization_address']
            ?? $destination['warehouse_address']
            ?? '-';

        $latitude =
            $destination['organization_latitude']
            ?? $destination['warehouse_latitude']
            ?? null;

        $longitude =
            $destination['organization_longitude']
            ?? $destination['warehouse_longitude']
            ?? null;
    }


    /*
      * Google Maps
      */
    if ($latitude && $longitude) {

        $googleMapsUrl =
            'https://www.google.com/maps/search/?api=1'
            . '&query='
            . urlencode($latitude . ',' . $longitude);
    } else {

        $googleMapsUrl =
            'https://www.google.com/maps/search/?api=1'
            . '&query='
            . urlencode($destinationAddress);
    }

    /*
      * Sequence
      */
    $sequence = (int) ($destination['sequence_no'] ?? 0);

    ?>

    <div class="phone-frame">

        <div class="screen" style="display:flex;">

            <!-- Header -->
            <div class="app-header">

                <a
                    href="<?= base_url(
                                'driver/detail/' .
                                    $destination['shipment_id']
                            ) ?>"
                    class="back-btn">
                    <i class="bi bi-arrow-left"></i>
                </a>

                <span class="title">
                    Destination
                </span>

                <a
                    href="<?= esc($googleMapsUrl) ?>"
                    target="_blank"
                    class="more-btn">
                    <i class="bi bi-geo-alt"></i>
                </a>
            </div>


            <!-- Main Content -->
            <div class="main-content has-action-bar">

                <!-- Destination Info -->
                <div class="dest-summary mb-12">
                    <span class="badge-status badge-current mb-8">
                        <span class="status-dot blue"></span>
                        <?= esc($activityType) ?>
                    </span>

                    <?php if ($destinationStatus === 'SDLPN'): ?>

                        <span class="badge-status badge-delivery mb-8">
                            <span class="status-dot green"></span>
                            Delivery
                        </span>

                    <?php endif; ?>
                    <h5 class="fw-700 mt-8 mb-4" style="font-size:1.25rem;">
                        <?= esc($destinationName) ?>
                    </h5>


                    <p class="text-muted mb-0" style="font-size:0.85rem;">
                        📍 <?= esc($destinationAddress) ?>
                    </p>

                </div>

                <!-- Google Maps -->
                <a href="<?= esc($googleMapsUrl) ?>" target="_blank" class="btn-outline-custom mt-8 mb-12">
                    <i class="bi bi-geo-alt-fill"></i>Buka Google Maps
                </a>


                <!-- Activity & Sequence -->
                <div class="d-flex gap-8 mb-12">

                    <!-- Activity -->
                    <div class="dest-summary flex-fill text-center">
                        <div class="section-label">
                            Activity
                        </div>
                        <div class="section-value">
                            <?= esc($activityType) ?>
                        </div>
                    </div>


                    <!-- Sequence -->
                    <div class="dest-summary flex-fill text-center">
                        <div class="section-label">
                            Sequence
                        </div>

                        <div class="section-value">
                            <?= sprintf('%02d', $sequence) ?>
                            /
                            <?= sprintf(
                                '%02d',
                                $totalDestination
                            ) ?>

                        </div>

                    </div>
                </div>

                <div class="mb-12">
                    <?php if ($destinationStatus === 'SDLPN'): ?>
                        <div class="dest-summary text-center mb-12" style="background: #deffdd;">
                            <div class="section-label">
                                Status
                            </div>
                            <div class="section-value" style="color: #0f810b;">
                                Delivery
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>


            <!-- Bottom Action Bar -->

            <div class="bottom-action-bar">
                <?php if ($destinationStatus === 'SDLPN'): ?>
                    <div class="d-flex gap-8">
                        <form action="<?= base_url('driver/arrival/' . $destination['shipment_detail_id']) ?>"
                            method="post"
                            class="flex-fill">
                            <?= csrf_field() ?>

                            <button type="submit"
                                class="btn-action btn-action-delivery w-100">
                                SUDAH SAMPAI
                            </button>
                        </form>

                        <form
                            action="<?= base_url(
                                        'driver/cancelDelivery/' .
                                            $destination['shipment_detail_id']
                                    ) ?>"
                            method="post"
                            class="flex-fill">
                            <?= csrf_field() ?>

                            <button type="submit" class="btn-action w-100"
                                style="
                                background:#fff;
                                color:#0f810b;
                                border:1px solid #0f810b;
                            ">
                                BATALKAN
                            </button>
                        </form>
                    </div>
                <?php else: ?>

                    <form
                        action="<?= base_url(
                                    'driver/startDelivery/' .
                                        $destination['shipment_detail_id']
                                ) ?>"
                        method="post">
                        <?= csrf_field() ?>

                        <button type="submit" class="btn-action btn-action-primary d-block text-center w-100">
                            MULAI TUJUAN
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>