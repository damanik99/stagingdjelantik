## 1. TABLE: collector

Tabel ini menyimpan data akun collector yang bertugas melakukan kunjungan dan pengambilan minyak dari resident.

Fields:
## 2. TABLE: resident

Tabel ini menyimpan data warga atau resident yang menjadi sumber collection minyak.

Fields:

```text
resident
├── resident_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── resident_code VARCHAR(30) NOT NULL
├── resident_name VARCHAR(150) NOT NULL
├── phone VARCHAR(30) NULL
├── province
├── city
├── district
├── village
├── address
├── latitude
├── longitude
├── active
├── created_date
├── modified_date
├── created_by
└── modified_by
```

Business meaning:

* `resident_id` adalah primary key.
* `resident_code` adalah kode unik resident.
* Resident memiliki informasi wilayah:

  * province
  * city
  * district
  * village
* Resident dapat memiliki alamat dan koordinat GPS.
* `active` menentukan apakah resident masih aktif dalam program collection.
* Resident dapat dikunjungi berkali-kali oleh collector.

---

## 3. TABLE: collection_visit

Tabel ini adalah tabel transaksi utama untuk mencatat aktivitas kunjungan collector ke resident.

Fields:

```text
collection_visit
├── collection_visit_id
├── visit_number
├── collector_id
├── resident_id
├── visit_date
├── visit_time
├── qty
├── unit
├── status_id
├── note
├── created_date
├── modified_date
├── created_by
└── modified_by
```

Business meaning:

* Satu record merepresentasikan satu aktivitas kunjungan collector kepada satu resident.
* `visit_number` adalah nomor transaksi/kunjungan yang unik.
* `collector_id` menentukan siapa collector yang melakukan kunjungan.
* `resident_id` menentukan resident yang dikunjungi.
* `visit_date` dan `visit_time` mencatat waktu kunjungan.
* `qty` adalah jumlah minyak yang berhasil dikumpulkan.
* `unit` adalah satuan quantity, misalnya KG atau Liter.
* `status_id` menentukan status transaksi collection.
* `note` digunakan untuk catatan tambahan.
* Satu collector dapat memiliki banyak collection visit.
* Satu resident dapat memiliki banyak collection visit.

Relationship:

```text
collector
    │
    │ 1
    │
    └──────────< collection_visit >──────────┐
                                              │
                                              │ many
                                              ▼
                                           resident
```

---

## 4. TABLE: collection_visit_attachment

Tabel ini menyimpan file atau foto yang terkait dengan collection visit.

Fields:

```text
collection_visit_attachment
├── collection_visit_attachment_id
├── collection_visit_id
├── file_path
├── file_name
├── file_type
├── file_size
├── created_date
└── created_by
```

Business meaning:

* Satu collection visit dapat memiliki satu atau lebih attachment.
* Attachment dapat berupa foto bukti collection.
* `collection_visit_id` menghubungkan attachment dengan transaksi collection visit.
* File sebenarnya disimpan pada storage/server/object storage.
* Database hanya menyimpan metadata file.

Relationship:

```text
collection_visit
      │
      │ 1
      │
      └──────────< collection_visit_attachment
                        many
```

---

## 5. TABLE: collector_balance

Tabel ini digunakan sebagai tabel summary/cache untuk menyimpan ringkasan performa collector.

Fields:

```text
collector_balance
├── collector_id
├── total_qty
├── total_visit
├── last_visit_date
├── last_visit_time
└── modified_date
```

Business meaning:

* Tabel ini bukan sumber transaksi utama.
* Source of truth tetap berada pada tabel `collection_visit`.
* `collector_balance` digunakan untuk mempercepat pembacaan dashboard atau informasi saldo/performa collector.
* `total_qty` adalah total quantity collection yang telah dihitung.
* `total_visit` adalah total jumlah visit.
* `last_visit_date` dan `last_visit_time` menyimpan aktivitas collection terakhir.
* Data pada tabel ini perlu di-update ketika collection visit yang valid dibuat, diubah, dibatalkan, atau statusnya berubah.

Relationship:

```text
collector
    │
    │ 1
    │
    └────────── 1 collector_balance
```

---

# OVERALL DATABASE RELATIONSHIP

```text
users
  │
  │
  ▼
collector
  │
  ├──────────────► organization_program
  │
  │
  │ 1
  │
  ├──────────────< collection_visit >──────────── resident
  │                     │
  │                     │ 1
  │                     │
  │                     └──────────< collection_visit_attachment
  │
  │
  └──────────────► collector_balance
```