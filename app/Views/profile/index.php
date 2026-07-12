<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL SELECT2 CSS -->
<link href="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.min.css" rel="stylesheet" />

<!-- CSS END -->

<!-- LAYOUT BODY -->
<?= $this->include('layout/body') ?>
<!-- LAYOUT BODY -->

<?php /** @var array $users * */ ?>

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div style="margin-bottom: 15px;margin-top: 30px;">
            <h1 class="page-title">Account</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="row">
            <div class="col-lg-5 col-xl-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-status bg-teal br-tr-7 br-tl-7"></div>
                    <div class="card-body">
                        <form id="formUpdateUser" autocomplete="off">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Username </label>
                                    <input type="text" name="username" class="form-control" value="<?= $users['username'] ?>" readonly>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">New Password </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-light border toggle-password"
                                                    data-target="password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Confirm Password </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        <div class="input-group-append">
                                            <button class="btn btn btn-light border toggle-password"
                                                    type="button" data-target="confirm_password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small id="confirm_password_error" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" id="btnSave" class="btn btn-teal">
                                    <i class="fa fa-save"></i>
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="userprofile">
                                <div class="userpic  brround"> <img src="<?= base_url() ?>/teamplate/assets/images/users/admin.png" alt="" class="userpicimg"> </div>
                                <h3 class="username text-dark mb-2"><?= $users['fullname'] ?></h3>
                                <p class="mb-1 text-dark"><?= $users['address'] ?></p>
                                <div class="text-center">
                                    <div class="User">
                                        <p class="mb-1 u-name">Email: <?= $users['email'] ?></p>
                                        <p class="mb-1 u-designation">Title: <?= $users['title'] ?></p>
                                    </div>
                                </div>
                                <div class="socials text-center mt-3">
                                   <p class="mb-1 u-name" style="margin-top: 25px;"><br><br><br></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- COL END -->
        </div>
        <!-- ROW-1 CLOSED -->

        <div class="row">
            
        </div>
    </div>

</div>
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
<?php if (session()->getFlashdata('success')) {?>
toastr.success("<?php echo session()->getFlashdata('success'); ?>");
<?php }  ?>
</script>



<script>
    
$(document).on('click', '.toggle-password', function () {

    let target = $('#' + $(this).data('target'));
    let icon = $(this).find('i');

    if (target.attr('type') === 'password') {
        target.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        target.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }

});

$('#password, #confirm_password').on('keyup', function () {

    let password = $('#password').val();
    let confirmPassword = $('#confirm_password').val();

    if (confirmPassword.length === 0) {
        $('#confirm_password_error').text('');
        return;
    }

    if (password !== confirmPassword) {

        $('#confirm_password_error').text('Confirm password tidak sama.');

        $('#confirm_password').addClass('is-invalid');

    } else {

        $('#confirm_password_error').text('');

        $('#confirm_password').removeClass('is-invalid');

    }

});

$('#formUpdateUser').on('submit', function(e) {

   e.preventDefault();

    let password = $('#password').val();
    let confirmPassword = $('#confirm_password').val();

    if(password !== confirmPassword){

        $('#confirm_password_error').text('Confirm password tidak sama.');
        $('#confirm_password').focus();

        return;
    }

    $('#confirm_password_error').text('');

    let formData = new FormData(this);

    $.ajax({
        url: "<?= base_url('/users/editprofile/'.$users['users_id']) ?>",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        beforeSend: function() {

            console.log('=== REQUEST SENT ===');

            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },

        success: function(res, textStatus, xhr) {

            Swal.close();

            console.log('=== SUCCESS ===');
            console.log('Status:', xhr.status);
            console.log('Response:', res);

            if (res.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message
                }).then(() => {

                    window.location.href =
                        "<?= base_url('/Users') ?>";

                });

            } else {

                let msg = '';

                if (typeof res.message === 'object') {

                    $.each(res.message, function(key, val) {

                        console.log('Validation Error:', key, val);

                        msg += val + '<br>';

                    });

                } else {

                    console.log('Message:', res.message);

                    msg = res.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Validation',
                    html: msg
                });
            }
        },

        error: function(xhr, status, error) {

            Swal.close();

            console.log('=== AJAX ERROR ===');
            console.log('Status:', xhr.status);
            console.log('Status Text:', xhr.statusText);
            console.log('Error:', error);
            console.log('Response Text:', xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                html:
                    '<b>Status:</b> ' + xhr.status +
                    '<br><br><b>Error:</b><br>' +
                    xhr.responseText
            });
        }
    });
});
</script>