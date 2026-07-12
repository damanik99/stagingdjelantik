</div>
</div>
</div>
<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 text-center">
                Copyright © 2020 - <?= date("Y"); ?> <a href="#">DJELANTIK</a>. Designed by <a href="#"> Team IT
                    Developer LNSOLUSI </a> All rights reserved.
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER CLOSED -->
<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>


<!-- JQUERY JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript">
<?php if (session()->getFlashdata('success')) {?>

toastr.success("<?php echo session()->getFlashdata('success'); ?>");


<?php }  ?>

<?php if (session()->getFlashdata('error')) {?>
toastr.error("<?php echo session()->getFlashdata('error'); ?> ");
<?php } ?>
</script>

<!-- BOOTSTRAP JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/bootstrap/js/popper.min.js"></script>

<!-- SPARKLINE JS-->
<script src="<?= base_url() ?>/teamplate/assets/js/jquery.sparkline.min.js"></script>

<!-- RATING STAR JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/rating/jquery.rating-stars.js"></script>

<!-- EVA-ICONS JS -->
<script src="<?= base_url() ?>/teamplate/assets/iconfonts/eva.min.js"></script>

<!-- SIDE-MENU JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu.js"></script>

<!-- PERFECT SCROLL BAR js-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/p-scroll/perfect-scrollbar.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/sidemenu/sidemenu-scroll.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- CUSTOM SCROLLBAR JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- SIDEBAR JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/sidebar/sidebar.js"></script>

<!-- CUSTOM JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/custom.js"></script>

<script>
if (typeof jQuery === "undefined") {
    console.error("Error: jQuery tidak termuat!");
} else {
    console.log("Sukses: jQuery versi " + jQuery.fn.jquery + " telah dimuat.");
}

var $ = jQuery.noConflict();

function setValue() {

    var e = document.getElementById("programid");
    var programid = e.options[e.selectedIndex].value;
    var programname = e.options[e.selectedIndex].text;
    $.ajax({
        type: 'POST',
        async: false,
        url: "<?= base_url('/dashboard/menuprivilage');?>",
        data: {
            'programid': programid,
            'programname': programname
        },
        dataType: "json",
        beforeSend: function() {
            $("#global-loader").show();
        },
        success: function(data) {
            location.reload();
            console.log(data);
            $("#global-loader").hide();
        }
    });

}
</script>