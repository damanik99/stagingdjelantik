<?php /** @var array<string, mixed>|null $views */ ?>

<?php if (empty($views)) : ?>
    <div class="alert alert-warning mb-0">
        Data storage container tidak ditemukan.
    </div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <th>CONTAINER CODE</th>
                    <td><?= esc($views['container_code'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>CONTAINER NAME</th>
                    <td><?= esc($views['container_name'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>CONTAINER TYPE</th>
                    <td><?= esc($views['container_type_name'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>WAREHOUSE</th>
                    <td><?= esc($views['warehouse_name'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>CAPACITY</th>
                    <td>
                        <?= !empty($views['capacity'])
                            ? esc(number_format((float) $views['capacity'], 0, ',', '.').' '.($views['capacity_unit'] ?? ''))
                            : '-'; ?>
                    </td>
                </tr>
                <tr>
                    <th>STATUS</th>
                    <td>
                        <?php if (($views['status_code'] ?? '') === 'AVB') : ?>
                            <span class="badge badge-success"><?= esc($views['status_name'] ?? 'AVAILABLE'); ?></span>
                        <?php elseif (($views['status_code'] ?? '') === 'MNTC') : ?>
                            <span class="badge badge-danger"><?= esc($views['status_name'] ?? 'MAINTENANCE'); ?></span>
                        <?php elseif (($views['status_code'] ?? '') === 'CLNG') : ?>
                            <span class="badge badge-danger"><?= esc($views['status_name'] ?? 'CLEANING'); ?></span>
                        <?php else : ?>
                            <span class="badge badge-secondary"><?= esc($views['status_name'] ?? '-'); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>NOTE</th>
                    <td><?= !empty($views['note']) ? esc($views['note']) : '-'; ?></td>
                </tr>
                <tr>
                    <th>CREATED DATE</th>
                    <td>
                        <?= !empty($views['created_date'])
                            ? date('d M Y H:i', strtotime($views['created_date']))
                            : '-'; ?>
                    </td>
                </tr>
                <tr>
                    <th>MODIFIED DATE</th>
                    <td>
                        <?= !empty($views['modified_date'])
                            ? date('d M Y H:i', strtotime($views['modified_date']))
                            : '-'; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif; ?>
