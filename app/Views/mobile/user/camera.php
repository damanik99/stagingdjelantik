<?= $this->include('mobile/layout/main') ?>

<header class="app-header"><a href="<?= base_url('mobile/user/quantitymobile?resident_id=' . (int) $resident['resident_id']) ?>" class="back-btn"><i class="bi bi-arrow-left"></i></a><span class="title">Dokumentasi</span></header>
<main class="main-content has-action-bar">
    <input type="hidden" id="csrf-token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
    <div id="camera-message"></div>
    <div class="card-app mb-3">
        <div class="fw-700 fs-sm"><?= esc($resident['resident_name']) ?></div>
        <div class="fs-xs text-muted"><?= esc($resident['resident_code']) ?> · <?= esc($draft['qty']) ?> <?= esc(ucfirst(strtolower($draft['unit']))) ?></div>
    </div>
    <p class="text-muted fw-600 fs-sm mb-2">Dokumentasi collection (opsional)</p>
    <div class="text-muted fs-xs mb-3"><span id="photo-counter">0 / 4</span> foto</div>
    <input type="file" id="photo-input" accept="image/jpeg,image/png" capture="environment" class="d-none">
    <div class="camera-area" id="camera-area" role="button" tabindex="0"><i class="bi bi-camera-fill"></i><span class="fw-600 fs-sm">Ambil Foto</span></div>
    <div id="photo-previews" class="row g-2 mt-2"></div>
</main>
<div class="bottom-action-bar"><button type="button" class="btn-action btn-action-primary" id="btn-save-collection"><i class="bi bi-check-lg"></i> SIMPAN COLLECTION</button></div>

<?= $this->include('mobile/layout/footer') ?>
<script>
    $(function() {
        const maxPhotos = 4;
        let photos = [];

        function message(text) {
            $('#camera-message').html('<div class="alert alert-danger">' + $('<div>').text(text).html() + '</div>');
        }

        function render() {
            $('#photo-counter').text(photos.length + ' / ' + maxPhotos);
            $('#photo-previews').empty();
            photos.forEach(function(file, index) {
                const url = URL.createObjectURL(file);
                const $item = $('<div class="col-6"><div class="position-relative"><img class="photo-preview d-block" alt="Preview"><button type="button" class="btn btn-danger btn-sm btn-remove-photo position-absolute top-0 end-0" data-index="' + index + '"><i class="bi bi-x"></i></button></div></div>');
                $item.find('img').attr('src', url).on('load', function() {
                    URL.revokeObjectURL(url);
                });
                $('#photo-previews').append($item);
            });
            $('#camera-area').toggle(photos.length < maxPhotos);
        }
        $('#camera-area').on('click keydown', function(event) {
            if (event.type === 'click' || event.key === 'Enter') $('#photo-input').trigger('click');
        });
        $('#photo-input').on('change', function() {
            const file = this.files[0];
            this.value = '';
            if (!file) return;
            if (photos.length >= maxPhotos) {
                message('Maksimal 4 foto dokumentasi.');
                return;
            }
            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                message('Foto harus berupa JPG, JPEG, atau PNG.');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                message('Ukuran setiap foto maksimal 2 MB.');
                return;
            }
            photos.push(file);
            $('#camera-message').empty();
            render();
        });
        $(document).on('click', '.btn-remove-photo', function() {
            photos.splice(Number($(this).data('index')), 1);
            render();
        });
        $('#btn-save-collection').on('click', function() {
            const $button = $(this).prop('disabled', true);
            const formData = new FormData();
            formData.append($('#csrf-token').attr('name'), $('#csrf-token').val());
            photos.forEach(function(file) {
                formData.append('photos[]', file, file.name);
            });
            $.ajax({
                    url: '<?= base_url('mobile/user/camera/save') ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json'
                })
                .done(function(response) {
                    if (response.success) window.location.href = response.redirect;
                    else {
                        message(response.message);
                        $button.prop('disabled', false);
                    }
                })
                .fail(function(xhr) {
                    message((xhr.responseJSON || {}).message || 'Gagal menyimpan collect minyak.');
                    $button.prop('disabled', false);
                });
        });
    });
</script>