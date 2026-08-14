<?php /** @var array<string, mixed> $shipment 
 * @var array<string, mixed> $routes
 * */ ?>
<div class="table-responsive">
    <h5 class="modal-title">
        Shipment Number <?= $shipment['shipment_number']; ?>
    </h5>
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Driver</th>
                <td><?= esc($shipment['driver_name']) ?></td>
            </tr>

            <tr>
                <th>Vehicle</th>
                <td><?= esc($shipment['plate_number']) ?></td>
            </tr>

        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Activity</th>
                <th>Organization</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($routes as $row) : ?>

            <tr>
                <td><?= esc($row['sequence_no']) ?></td>
                <td><?= esc($row['activity_type']) ?></td>
                <td><?= esc($row['organization_name']) ?></td>
                <td><?= esc($row['departure_at']) ?></td>
                <td><?= esc($row['arrival_at']) ?></td>
                <td><?= esc($row['qty']) . ' ' . esc($row['unit']) ?></td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>
</div>
