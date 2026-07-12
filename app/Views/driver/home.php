<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />
<!-- CUSTOM SCROLL BAR CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
<!--PERFECT SCROLL CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet" />

<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <?php 
        $programId = session()->get('program');
        // var_dump($programId);exit;
        if(!$programId) 
        {?>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div><br></div>
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <strong>PROGRAM BELUM DI PILIH!!</strong>
                        <hr class="message-inner-separator">
                        <p>Klik tanda <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21 11.01L3 11v2h18zM3 16h12v2H3zM21 6H3v2.01L21 8z"></path></svg>
                        untuk memilih program
                        </p>
                    </div>
                
                </div>
            </div>
        </div>
        <?php }?>
        <div class="row">
            <?php if (!empty($shipment)) : ?>

            <?php foreach ($shipment as $row) : ?>
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <div><br></div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 col-md-12">
                            <h2 class="mb-1  number-font"><?= $row['shipment_number'] ?></h2>
                        </div>
                        <div class="mt-5">
                            <p class="mb-1 d-flex">
                                <span class="col-4 col-md-3 fs-15 font-weight-bold mr-2">Supplier </span> 
                                <span class="col-md-4 fs-15"><?= $row['supplier'] ?></span>
                            </p>
                            <p></p>
                            <p class="mb-1 d-flex">
                                <span class="col-4 fs-15 font-weight-bold mr-2">Buyer </span> 
                                <span class="col-md-4 fs-15"><?= $row['buyer'] ?></span>
                            </p>
                            <p></p>
                            <p class="d-flex">
                                <span class="col-4 fs-15 font-weight-bold mr-2">Status</span> 
                                <span class="col-md-4 fs-15"><?= $row['status'] ?></span>
                            </p>
                            <br>
                        </div>
                        <?php
                            $programId = session()->get('program');

                            if (empty($programId)) : ?>

                                <a href="javascript:void(0);" class="btn btn-default btn-block disabled" tabindex="-1" aria-disabled="true">
                                    CHECK-IN
                                </a>

                            <?php else : ?>

                                <?php if ($row['status_code'] == 'SDLPN') : ?>

                                    <a href="<?= base_url('ShipmentTracking/arrived/'.$row['shipment_id']); ?>"
                                    class="btn btn-success btn-block">
                                        LIHAT DETAIL
                                    </a>

                                <?php elseif ($row['status_code'] == 'DLVD') : ?>

                                    <a href="<?= base_url('ShipmentTracking/chek-out/'.$row['shipment_id']); ?>"
                                    class="btn btn-secondary btn-block">
                                        CHECKOUT
                                    </a>

                                <?php elseif ($row['status_code'] == 'SCMPL') : ?>

                                    <a href="javascript:void(0);"
                                    class="btn btn-default btn-block" disabled>
                                        Berhasil
                                    </a>

                                <?php else : ?>

                                    <a href="<?= base_url('ShipmentTracking/create/'.$row['shipment_id']); ?>"
                                    class="btn btn-primary btn-block">
                                        CHECK-IN
                                    </a>

                                <?php endif; ?>

                            <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php else : ?>

                <div class="col-md-12">
                    <div class="alert alert-info">
                        Tidak ada shipment aktif.
                    </div>
                </div>

            <?php endif; ?>
        </div>
        
    </div>
</div>
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->


<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
