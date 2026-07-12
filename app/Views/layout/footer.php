<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 text-center">
                Copyright © 2020 - <?= date("Y"); ?> <a href="#">SURFGOLD</a>. Designed by <a href="#"> Team IT
                    Developer SURFGOLD </a> All rights reserved.
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER CLOSED -->
<!-- JQUERY JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.slim.js"
    integrity="sha512-HNbo1d4BaJjXh+/e6q4enTyezg5wiXvY3p/9Vzb20NIvkJghZxhzaXeffbdJuuZSxFhJP87ORPadwmU9aN3wSA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
var jq = $.noConflict(true);

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