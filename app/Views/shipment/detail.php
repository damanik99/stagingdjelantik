<?php /** @var array<string, mixed> $views */ ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Shipment No</th>
                <td><?= $views['shipment_number']; ?></td>
            </tr>

            <tr>
                <th>Supplier Name</th>
                <td><?= $views['supplier']; ?></td>
            </tr>

            <tr>
                <th>Buyer</th>
                <td><?= $views['buyer']; ?></td>
            </tr>

            <tr>
                <th>Driver</th>
                <td><?= $views['driver_name']; ?></td>
            </tr>

            <tr>
                <th>Vehicle</th>
                <td><?= $views['plate_number']; ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td><?= $views['status']; ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td><?= $views['status']; ?></td>
            </tr>

            <tr>
                <th>QTY Check In</th>
                <td><?= $views['qty_checkin']; ?> <?= $views['unit_checkin']; ?></td>
            </tr>

            <tr>
                <th>QTY Check Out</th>
                <td><?= $views['qty_checkout']; ?> <?= $views['unit_checkout']; ?></td>
            </tr>

            <tr>
                <th>Departure At</th>
                <td><?= $views['departure_at']; ?></td>
            </tr>

            <tr>
                <th>Arrival At</th>
                <td><?= $views['arrival_at']; ?></td>
            </tr>

            <tr>
                <th>Created Date</th>
                <td><?= $views['created_date']; ?></td>
            </tr>

        </tbody>
    </table>
</div>
