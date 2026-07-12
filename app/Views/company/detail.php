<?php /** @var array<string, mixed> $detail */ ?>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th width="30%">COMPANY NAME</th>
                <td><?= $detail['company_name']; ?></td>
            </tr>
            <tr>
                <th>COMPANY TYPE</th>
                <td><?= $detail['type_name']; ?></td>
            </tr>
            <tr>
                <th>PIC NAME</th>
                <td><?= !empty($detail['pic_name']) ? $detail['pic_name'] : '<i>empty</i>'; ?></td>
            </tr>
            <tr>
                <th>PHONE</th>
                <td><?= !empty($detail['phone']) ? $detail['phone'] : '<i>empty</i>'; ?></td>
            </tr>
            <tr>
                <th>EMAIL</th>
                <td><?= !empty($detail['email']) ? $detail['email'] : '<i>empty</i>'; ?></td>
            </tr>
            <tr>
                <th>STATUS</th>
                <td><?= !empty($detail['status_name']) ? $detail['status_name'] : '<i>empty</i>'; ?></td>
            </tr>
            <tr>
                <th>ADDRESS</th>
                <td><?= !empty($detail['address']) ? $detail['address'] : '<i>empty</i>'; ?></td>
            </tr>
            <tr>
                <th>LATITUDE</th>
                <td><?= !empty($detail['latitude']) ? $detail['latitude'] : '<i>empty</i>'; ?></td>
            </tr>
            <tr>
                <th>LONGITUDE</th>
                <td><?= !empty($detail['longitude']) ? $detail['longitude'] : '<i>empty</i>'; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php if (!empty($detail['latitude']) && !empty($detail['longitude'])) : ?>

<div class="mt-3">

    <a href="https://www.google.com/maps?q=<?= $detail['latitude'] ?>,<?= $detail['longitude'] ?>"
        target="_blank"
        class="btn btn-radius btn-info-light">

        <i class="fa fa-map-marker mr-1"></i>
        Open Google Maps

    </a>

</div>

<?php endif; ?>