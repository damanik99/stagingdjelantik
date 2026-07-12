<?php /** @var array<string, mixed> $views */ ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>WAREHOUSE CODE</th>
                <td><?= $views['warehouse_code']; ?></td>
            </tr>

            <tr>
                <th>WAREHOUSE NAME</th>
                <td><?= $views['warehouse_name']; ?></td>
            </tr>

            <tr>
                <th>ADDRESS</th>
                <td>
                    <?= !empty($views['address']) ? $views['address'] : '-'; ?>
                </td>
            </tr>

            <tr>
                <th>LATITUDE</th>
                <td>
                    <?= !empty($views['latitude']) ? $views['latitude'] : '-'; ?>
                </td>
            </tr>
            <tr>
                <th>LONGITUDE</th>
                <td>
                    <?= !empty($views['longitude']) ? $views['longitude'] : '-'; ?>
                </td>
            </tr>
            <tr>
                <th>STATUS</th>
                <td>
                    <?php if($views['is_active'] == 1){ ?>
                    <span class="badge badge-success">
                        Active
                    </span>
                    <?php } else { ?>
                    <span class="badge badge-danger">
                        Inactive
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

<?php if(
    !empty($views['latitude']) &&
    !empty($views['longitude'])
){ ?>

<div class="mt-4">
    <a href="https://www.google.com/maps?q=<?= $views['latitude'] ?>,<?= $views['longitude'] ?>"
        target="_blank"
        class="btn btn-info">

        <i class="fa fa-map-marker"></i>
        Open Google Maps
    </a>
</div>
<?php } ?>