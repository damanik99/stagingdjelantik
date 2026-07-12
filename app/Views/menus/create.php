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

<!--app-content open-->
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <?//=$title?>
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/member">Index</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Menu</li>
                </ol>
            </div>

            <div class="ml-auto pageheader-btn">
                <div class="mt-4">
                    <button type="submit" id="viewPage" class="btn btn-primary">
                        <i class="fe fe-plus"></i> View Create Page
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row" id="createPageRow">
            <div class="col-md-12">
                <div class="card card-collapsed">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="mb-0 card-title">CREATE NEW PAGE</h3>
                        <div class="card-options ">
                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                                    class="fe fe-chevron-up text-white"></i></a>
                        </div>
                    </div>
                    <!-- Alert akan muncul di sini -->
                    <div id="alert-container"></div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text"id="newPage" class="form-control" placeholder="CREATE NEW PAGE">
                            </div>

                            <div class="col-md-2">
                                <button id="createPageBtn" class="btn btn-success">
                                Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary br-tr-3 br-tl-3">
                        <h3 class="mb-0 card-title">CREATE MENU</h3>
                    </div>
                    <!-- Alert akan muncul di sini -->
                    <div id="alert-container"></div>
                    <form id="menuPost" action='<?=base_url();?>/menus/create' method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Menu Name</label>
                                    <input type="text" name="menu" id="menu" class="form-control"
                                        placeholder="MENU NAME" required>

                                    <small class="text-muted">
                                    menu otomatis menjadi huruf kapital
                                    </small>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Parent Menu</label>
                                    <select name="parent" id="parent" class="form-control select2-show-search">
                                        <option value="">-- Select Parent --</option>
                                        <?php foreach($parents as $p){ ?>
                                        <option value="<?= $p['name'] ?>"><?= $p['name'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Page</label>
                                    <select name="page" id="page" class="form-control select2-show-search">
                                        <option value="">-- Select Page --</option>
                                        <?php foreach($pages as $p){ ?>
                                        <option value="<?= $p['page_id'] ?>"><?= $p['name'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label>Action</label>
                                    <select name="action" id="action" class="form-control select2">
                                        <option value="">-- Select Action --</option>
                                        <?php foreach($actions as $a){ ?>
                                        <option value="<?= $a['action_id'] ?>"><?= $a['name'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label>Sequence</label>
                                    <input type="number" name="sequence" id="sequence" class="form-control" required>
                                    <small id="sequence-info" class="text-info"></small>
                                </div>

                                <div class="col-md-5 mt-3">
                                    <label>Image URL</label>
                                    <input type="text" name="image_url" class="form-control" placeholder="fa fa-university">
                                    <small class="text-muted">
                                    contoh: &lt;i class="fa fa-university"&gt;&lt;/i&gt;
                                    </small>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" id="submitBtn" class="btn btn-success">
                                <i class="fa fa-save"></i> Save Menu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- COL END -->
        </div>
        <!-- ROW-1 CLOSED -->
    </div>
</div>
<!-- CONTAINER END -->
</div>


<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!--INTERNAL  FORMELEMENTS JS -->
<script src="<?= base_url() ?>/teamplate/assets/js/select2.js"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="<?= base_url() ?>/teamplate/assets/plugins/select2/select2.full.min.js"></script>

<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/spectrum.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/date-picker/jquery-ui.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/input-mask/jquery.maskedinput.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$('#menu').on('input', function () {
    this.value = this.value.toUpperCase();
});

$('.select2').select2({
    tags: true,
    width: '100%',
    placeholder: "Search or type new",
    allowClear: true
});

$('#newPage').on('input', function () {

    let value = this.value;

    // kapital setiap kata
    value = value.replace(/\b\w/g, function(char){
        return char.toUpperCase();
    });

    // hapus semua spasi
    value = value.replace(/\s+/g, '');

    this.value = value;

});

$('#createPageBtn').click(function(){

    let page = $('#newPage').val();

    if(page == ''){
        alert('Page name tidak boleh kosong');
        return;
    }

    $.ajax({

        url:"<?=base_url()?>/menus/createPage",
        type:"POST",
        data:{page:page},
        dataType:"json",

        success:function(res){

            if(res.status == 'exist'){

                Swal.fire({
                    icon:'warning',
                    text:'Page sudah ada'
                });

                return;
            }

            if(res.status == 'success'){

                let option = new Option(res.name, res.page_id, true, true);

                $('#page').append(option).trigger('change');

                $('#newPage').val('');

                Swal.fire({
                    icon:'success',
                    text:'Page berhasil dibuat'
                });

            }

        }

    });

});

// Vlidasi Sequence
let availableSequence = [];

$('#sequence').on('keyup change', function(){

    let parent = $('#parent').val();

    if(parent == '') return;

    $.ajax({
        url: "<?= base_url()?>/menus/checkSequence",
        type: "POST",
        data:{
            parent: parent
        },
        dataType:"json",
        success:function(res){

            availableSequence = res.available;

            $('#sequence-info').html(
                'Sequence yang tersedia: ' + res.available.join(', ')
            );

        }
    })

});

$('#sequence').on('blur', function(){

    let seq = parseInt($(this).val());

    if(seq && !availableSequence.includes(seq)){

        Swal.fire({
            icon:'warning',
            text:'Sequence sudah tersedia'
        });

        $(this).val('');

    }

});
// finish validasi sequence

$(document).ready(function() {

    // Insert database
    $('#menuPost').on('submit', function(e) {
        e.preventDefault(); 

        let form = $(this);
        let submitBtn = $('#submitBtn');

        // Validasi saat submit form
        let seq = parseInt($('#sequence').val());

        if(seq && !availableSequence.includes(seq)){

            Swal.fire({
                icon:'error',
                text:'Sequence sudah tersedia'
            });

            e.preventDefault();
            return false;
        }
        // finish

        submitBtn.prop('disabled', true); 

        $('#alert-container').html('');

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {

                    if (response.message === 'Program Not selected yet') {
                        $('#alert-container').html(`
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Warning!</strong> ${response.message}
                            </div>
                        `);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3500
                    });
                    console.log(window.location.href);
                }
                submitBtn.prop('disabled', false);
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    text: 'Terjadi Kesalahan, Coba ulangi lagi.',
                    showConfirmButton: false,
                    timer: 3500
                });
                submitBtn.prop('disabled', false);
            }
        });
    });
});


</script>