<?php /** @var array<string, mixed> $views 
 * @var array<string, mixed> $driverGroupId 
 * @var array<string, mixed> $companies 
 * @var array<string, mixed> $driver */ ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th width="30%">Username</th>
                <td><?= esc($views['username']); ?></td>
            </tr>

            <tr>
                <th>Full Name</th>
                <td><?= esc($views['fullname']); ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= esc($views['email']); ?></td>
            </tr>

            <tr>
                <th>Phone</th>
                <td><?= esc($views['phone']); ?></td>
            </tr>

            <tr>
                <th>Title</th>
                <td><?= esc($views['title']); ?></td>
            </tr>

            <tr>
                <th>Group</th>
                <td><?= esc($views['group']); ?></td>
            </tr>

            <tr>
                <th>Data Level</th>
                <td><?= esc($views['data_level']); ?></td>
            </tr>

            <tr>
                <th>Province</th>
                <td><?= esc($views['provinsi']); ?></td>
            </tr>

            <tr>
                <th>City</th>
                <td><?= esc($views['kabupaten_kota']); ?></td>
            </tr>

            <tr>
                <th>District</th>
                <td><?= esc($views['kecamatan']); ?></td>
            </tr>

            <tr>
                <th>Village</th>
                <td><?= esc($views['kelurahan']); ?></td>
            </tr>

            <tr>
                <th>Address</th>
                <td><?= nl2br(esc($views['address'])); ?></td>
            </tr>

            <?php if (($views['group_id'] ?? 0) == $driverGroupId): ?>

                <tr class="table-secondary">
                    <th colspan="2">Driver Information</th>
                </tr>

                <tr>
                    <th>Driver Type</th>
                    <td><?= esc($views['driver_type']); ?></td>
                </tr>

                <?php if (($views['driver_type'] ?? '') === 'SUPPLIER'): ?>

                <tr>
                    <th>Supplier</th>
                    <td><?= esc($companies['company_name']); ?></td>
                </tr>

                <?php endif; ?>

                <tr>
                    <th>Driver Name</th>
                    <td><?= esc($driver['driver_name']); ?></td>
                </tr>

                <tr>
                    <th>License Number</th>
                    <td><?= esc($driver['license_number']); ?></td>
                </tr>

                <tr>
                    <th>License Type</th>
                    <td><?= esc($driver['license_type']); ?></td>
                </tr>

                <tr>
                    <th>License Expiry</th>
                    <td><?= esc($driver['license_expiry_date']); ?></td>
                </tr>

            <?php endif; ?>

        </tbody>
    </table>
</div>