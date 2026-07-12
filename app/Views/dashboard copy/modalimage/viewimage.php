<?php /** @var array<string, mixed> $photo */ ?>

<div id="shipmentGallery">
<?php foreach ($photo as $row): ?>
    
<?php
$imagePath = FCPATH . 'upload/' . $row['photo'];

list($width, $height) = getimagesize($imagePath);

$imageUrl = base_url('upload/'.$row['photo']);
?>
    <div class="gallery-item">
        <a href="<?= base_url('upload'.$row['photo']) ?>"
            data-pswp-width="<?= $width ?>"
            data-pswp-height="<?= $height ?>">

            <img src="<?= $imageUrl ?>">
        </a>
    </div>
<?php endforeach; ?>
</div>
