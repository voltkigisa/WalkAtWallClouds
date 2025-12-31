# Filter Dashboard - Dokumentasi

## Fitur yang Sudah Dibuat

### 1. Filter Dashboard Admin (`/admin/dashboard`)

**Lokasi File:**

-   Controller: `app/Http/Controllers/AdminController.php`
-   View: `resources/views/admin.blade.php`

**Filter yang Tersedia untuk Events:**

-   **Filter Status**: Published / Cancelled / Draft
-   **Filter Tanggal Event**:
    -   Hari Ini
    -   Minggu Ini
    -   Bulan Ini
    -   Event Mendatang (upcoming)
    -   Event Lewat (past)
-   **Range Tanggal Custom**: Tanggal Dari - Tanggal Sampai

**Cara Kerja:**

1. Admin membuka dashboard `/admin/dashboard`
2. Pada section "Manage Events" ada form filter
3. Pilih filter yang diinginkan
4. Klik "Terapkan Filter"
5. Tabel events akan otomatis terfilter
6. Klik "Reset Filter" untuk menghapus semua filter

### 2. Filter Event List untuk User (`/events`)

**Lokasi File:**

-   Controller: `app/Http/Controllers/EventListController.php`
-   View: `resources/views/events-list.blade.php`
-   Route: `routes/web.php` (route name: `events.list`)

**Filter yang Tersedia:**

-   **Lokasi**: Dropdown berisi semua lokasi event yang tersedia
-   **Filter Tanggal**:
    -   Hari Ini
    -   Minggu Ini
    -   Bulan Ini
    -   Event Mendatang (upcoming)
    -   Event Lewat (past)
-   **Range Tanggal Custom**: Tanggal Dari - Tanggal Sampai
-   **Range Harga Tiket**: Harga Minimum - Harga Maximum
-   **Sorting**:
    -   Berdasarkan: Tanggal Event / Nama Event / Lokasi
    -   Urutan: A-Z (ascending) / Z-A (descending)

**Cara Kerja:**

1. User mengakses `/events`
2. Hanya event dengan status "published" yang ditampilkan
3. User dapat memilih berbagai filter
4. Klik "Terapkan Filter" untuk menerapkan filter
5. Klik "Reset Filter" untuk menghapus semua filter
6. Hasil ditampilkan dalam bentuk tabel dengan pagination
7. User bisa klik "Detail" untuk melihat detail event
8. User bisa klik "Beli Tiket" jika event memiliki tiket

## Kenapa Filter Ini Berguna untuk User?

1. **Filter Lokasi**: User bisa mencari event di kota tertentu
2. **Filter Tanggal**: User bisa mencari event yang sesuai dengan jadwal mereka
3. **Filter Harga**: User bisa mencari event sesuai budget mereka
4. **Sorting**: User bisa mengurutkan event berdasarkan preferensi mereka
5. **Pagination**: Memudahkan navigasi jika event banyak

## Implementasi Teknis

### Backend (Controller)

-   Menggunakan Query Builder Laravel
-   Filter diterapkan dengan conditional query berdasarkan request parameter
-   Menggunakan Carbon untuk manipulasi tanggal
-   Pagination untuk hasil yang banyak

### Frontend (View)

-   Form HTML sederhana tanpa CSS/styling custom
-   Menggunakan table HTML untuk layout
-   Parameter filter dipertahankan di URL untuk bookmarking
-   Menampilkan jumlah hasil yang ditemukan

## Testing

Untuk test fitur ini:

1. **Test Filter Admin:**

    ```
    Login sebagai admin -> /admin/dashboard
    Coba filter event berdasarkan status dan tanggal
    ```

2. **Test Filter User:**
    ```
    Akses /events
    Coba berbagai kombinasi filter
    Test pagination
    ```

## Notes

-   Semua filter adalah opsional (bisa dikombinasikan)
-   Filter menggunakan metode GET, jadi bisa di-bookmark
-   Tidak ada styling/CSS custom sesuai permintaan
-   Pure HTML form dengan PHP/Blade syntax
