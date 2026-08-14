<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>LogiMove — Pickup Quantity</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>/teamplate/assets/mobile.css" rel="stylesheet" />

  <style>
    /* ── Additional quantity page specific styles ── */
    .qty-section {
      padding-top: 8px;
    }
  </style>
</head>

<body>

  <div class="phone-frame">

    <div class="screen" style="display:flex;">

      <!-- Header -->
      <div class="app-header">
        <a href="<?= base_url() ?>driver/destination" class="back-btn"><i class="bi bi-arrow-left"></i></a>
        <span class="title">Pickup Quantity</span>
      </div>

      <!-- Main Content -->
      <div class="main-content no-nav qty-section">

        <p class="text-muted text-center fw-600 mb-16" style="font-size:0.85rem;">
          Masukkan jumlah pickup
        </p>
        <div class="col-md-12">
          <div class="row">
              <div class="col-md-12">
                <label class="form-label">Company Name *</label>
                <input type="text"
                  name="company_name"
                  class="form-control"
                  required>
              </div>
          </div>
        </div>
        <!-- Quick Quantity Chips -->
        <div class="quick-qty mt-16">
          <span class="chip" data-qty="50">50</span>
          <span class="chip" data-qty="100">100</span>
          <span class="chip" data-qty="150">150</span>
          <span class="chip" data-qty="200">200</span>
        </div>

        <!-- Action Button -->
        <button class="btn-action btn-action-primary mt-16 w-100" id="btn-confirm"
          onclick="openBottomSheet()">
          KONFIRMASI PICKUP
        </button>

      </div>

    </div><!-- /screen -->

  </div><!-- /phone-frame -->

  <!-- ═════ BOTTOM SHEET ═════ -->
  <div class="bottom-sheet-overlay" id="bottom-sheet-overlay">
    <div class="bottom-sheet" onclick="event.stopPropagation()">
      <div class="sheet-handle"></div>

      <h6 class="fw-700 mb-12">Confirm Pickup</h6>

      <div class="d-flex justify-between align-center mb-8">
        <span class="text-muted" style="font-size:0.85rem;">Lokasi</span>
        <span class="fw-700" style="font-size:0.85rem;">PKK 002</span>
      </div>

      <div class="d-flex justify-between align-center mb-16">
        <span class="text-muted" style="font-size:0.85rem;">Quantity</span>
        <span class="fw-700" style="font-size:1rem;" id="sheet-qty">125 Liter</span>
      </div>

      <p class="text-muted mb-16 text-center" style="font-size:0.82rem;">
        Apakah data sudah benar?
      </p>

      <button class="btn-outline-custom mb-8" onclick="closeBottomSheet()">
        Batal
      </button>
      <a href="camera.html" class="btn-action btn-action-success d-block text-center w-100">
        Konfirmasi
      </a>
    </div>
  </div>

  <script>
    // ── Quick Quantity Chips ──
    document.querySelectorAll('.chip').forEach(chip => {
      chip.addEventListener('click', function() {
        const qty = this.getAttribute('data-qty');
        document.getElementById('qty-input').value = qty;
        document.getElementById('qty-input').focus();
      });
    });

    // ── Bottom Sheet ──
    function openBottomSheet() {
      const qtyVal = document.getElementById('qty-input').value || '0';
      document.getElementById('sheet-qty').textContent = qtyVal + ' Liter';
      document.getElementById('bottom-sheet-overlay').classList.add('show');
    }

    function closeBottomSheet() {
      document.getElementById('bottom-sheet-overlay').classList.remove('show');
    }

    document.getElementById('bottom-sheet-overlay').addEventListener('click', function(e) {
      if (e.target === this) closeBottomSheet();
    });
  </script>

</body>

</html>