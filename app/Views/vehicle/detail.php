<?php /** @var array<string, mixed> $views */ ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>COMPANY NAME</th>
                <td><?= $views['company_name']; ?></td>
            </tr>

            <tr>
                <th>PLATE NUMBER</th>
                <td><?= $views['plate_number']; ?></td>
            </tr>

            <tr>
                <th>VEHICLE TYPE</th>
                <td>
                    <?= $views['vehicle_type']; ?>
                </td>
            </tr>

            <tr>
                <th>MERK</th>
                <td>
                    <?= $views['brand']; ?>
                </td>
            </tr>
            <tr>
                <th>CAPACITY WEIGHT</th>
                <td>
                    <?= $views['capacity_weight']; ?>
                </td>
            </tr>
            <tr>
                <th>CAPACITY VOLUME</th>
                <td>
                    <?= $views['capacity_volume']; ?>
                </td>
            </tr>
            <tr>
                <th>STATUS</th>
                <td>
                    <?php if($views['status'] == 'available'){ ?>
                    <span class="badge badge-success">
                        Available
                    </span>
                    <?php } elseif($views['status'] == 'on_delivery'){ ?>
                    <span class="badge badge-primary">
                        On Delivery
                    </span>
                    <?php } else { ?>
                    <span class="badge badge-danger">
                        Maintenance
                    </span>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th>CREATED DATE</th>
                <td>
                    <?= date(
                        'd M Y H:i',
                        strtotime($views['created_date'])
                    ); ?>
                </td>
            </tr>
            <tr>
                <th>MODIFIED DATE</th>
                <td>
                    <?= date(
                        'd M Y H:i',
                        strtotime($views['modified_date'])
                    ); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
