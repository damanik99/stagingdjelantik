<?php

/** @var array<string, mixed> $views */ ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Code</th>
                <td><?= $views['organization_code']; ?></td>
            </tr>

            <tr>
                <th>Name</th>
                <td><?= $views['organization_name']; ?></td>
            </tr>

            <tr>
                <th>Pic Name</th>
                <td><?= $views['pic_name']; ?></td>
            </tr>

            <tr>
                <th>Phone</th>
                <td><?= $views['phone']; ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= $views['email']; ?></td>
            </tr>

            <tr>
                <th>Type Organization</th>
                <td><?= $views['type_name']; ?></td>
            </tr>

            <tr>
                <th>Address</th>
                <td><?= $views['address']; ?></td>
            </tr>

            <tr>
                <th>Created Date</th>
                <td><?= $views['created_date']; ?></td>
            </tr>

        </tbody>
    </table>
</div>