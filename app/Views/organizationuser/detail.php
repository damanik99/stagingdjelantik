<?php

/** @var array<string, mixed> $views */ ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Organization Name</th>
                <td><?= $views['organization_name']; ?></td>
            </tr>

            <tr>
                <th>Username</th>
                <td><?= $views['username']; ?></td>
            </tr>

            <tr>
                <th>fullname</th>
                <td><?= $views['fullname']; ?></td>
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
                <th>Address</th>
                <td><?= $views['address']; ?></td>
            </tr>

            <tr>
                <th>picture</th>
                <td><?php if (!empty($views['picture'])) : ?>

                        <div class="mb-3">
                            <img src="<?= base_url($views['picture']) ?>"
                                alt="User Picture" class="img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                    <?php else : ?>

                        <div class="mb-3">
                            <span class="text-muted">
                                No picture uploaded
                            </span>
                        </div>

                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th>Created Date</th>
                <td><?= $views['created_date']; ?></td>
            </tr>

        </tbody>
    </table>
</div>