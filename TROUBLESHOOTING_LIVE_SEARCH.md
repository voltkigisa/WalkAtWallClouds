# Troubleshooting Live Search di Hosting

## Masalah Umum & Solusi

### 1. JavaScript Tidak Ter-compile
**Gejala:** Live search tidak muncul sama sekali

**Solusi:**
```bash
# Di local, jalankan:
npm run build

# Pastikan folder public/build ter-upload ke hosting
# Upload manual jika perlu
```

### 2. Session/Authentication Issues
**Gejala:** Return error 401 atau 403 di console browser

**Cek di `.env` hosting:**
```env
SESSION_DRIVER=database  # Lebih reliable untuk hosting shared
SESSION_SECURE_COOKIE=true  # Jika menggunakan HTTPS
SESSION_DOMAIN=.yourdomain.com  # Set domain yang benar
```

**Solusi tambahan:**
```bash
php artisan session:table
php artisan migrate
php artisan config:cache
php artisan route:cache
```

### 3. CORS/Mixed Content Error
**Gejala:** Error di console: "Mixed Content" atau "CORS policy"

**Tambahkan di `.env` hosting:**
```env
APP_URL=https://yourdomain.com  # URL lengkap dengan HTTPS
ASSET_URL=https://yourdomain.com
```

**Update di `app/Http/Kernel.php`:**
```php
protected $middleware = [
    // ...
    \App\Http\Middleware\TrustProxies::class,
];

**Update di `bootstrap/app.php` (Laravel 11+):**
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*');
})
```

**Atau tambahkan di `config/trustedproxy.php`:**
```php
return [
    'proxies' => '*',
    'headers' => [
        Request::HEADER_X_FORWARDED_FOR,
        Request::HEADER_X_FORWARDED_HOST,
        Request::HEADER_X_FORWARDED_PORT,
        Request::HEADER_X_FORWARDED_PROTO,
    ],
];
```

```

### 4. Database Query Timeout
**Gejala:** Loading lama lalu error 500

**Optimasi di `SearchDashboardController.php`:**
```php
// Tambahkan index di migration untuk mempercepat LIKE query
// Atau ubah query menjadi lebih spesifik

// Contoh optimasi:
$users = User::where('name', 'like', "{$query}%")  // % di awal lebih lambat
    ->limit(3)  // Kurangi limit jika perlu
    ->get();
```

### 5. Memory Limit Issues
**Gejala:** Error 500 atau "Allowed memory size exhausted"

**Solusi di `.htaccess` atau `php.ini`:**
```
php_value memory_limit 256M
php_value max_execution_time 60
```

### 6. Mod_Security Blocking AJAX
**Gejala:** Error 403 atau 406 di browser console

**Hubungi hosting provider untuk:**
- Whitelist URL `/admin/search`
- Disable mod_security untuk aplikasi Anda
- Atau tambahkan di `.htaccess`:

```apache
<IfModule mod_security.c>
    SecFilterEngine Off
    SecFilterScanPOST Off
</IfModule>
```

## Cara Debug di Hosting

### Step 1: Cek Browser Console
1. Buka website di browser
2. Tekan F12 atau klik kanan > Inspect
3. Buka tab "Console"
4. Coba ketik di search box
5. Lihat error apa yang muncul

### Step 2: Cek Network Tab
1. Di Developer Tools, buka tab "Network"
2. Filter "XHR" atau "Fetch"
3. Ketik di search box
4. Lihat request ke `/admin/search`:
   - Status code (harus 200)
   - Response (data JSON atau error message)
   - Headers (cek cookie, CSRF token)

### Step 3: Cek Laravel Log
```bash
# Download file dari hosting:
storage/logs/laravel.log

# Atau via SSH:
tail -f storage/logs/laravel.log
```

### Step 4: Test Route Manual
Akses langsung di browser:
```
https://yourdomain.com/admin/search?q=test
```

Harus return JSON, bukan error 404 atau redirect

## Checklist Sebelum Deploy

- [ ] `npm run build` sudah dijalankan
- [ ] Folder `public/build` ter-upload
- [ ] File `.env` sudah dikonfigurasi dengan benar
- [ ] `APP_URL` di `.env` sesuai dengan domain hosting
- [ ] Database sudah di-migrate
- [ ] `php artisan config:cache` sudah dijalankan di hosting
- [ ] `php artisan route:cache` sudah dijalankan di hosting
- [ ] Session driver sudah di-set (database recommended)
- [ ] File permissions benar (storage dan bootstrap/cache writable)

## Quick Fix - Alternatif Sederhana

Jika masih tidak berfungsi, gunakan solusi fallback tanpa live search:

**Ubah ke form submit biasa:**
```html
<form method="GET" action="{{ route('admin.search') }}">
    <input type="text" name="q" placeholder="Search...">
    <button type="submit">Search</button>
</form>
```

**Update controller untuk return view:**
```php
public function index(Request $request)
{
    $query = $request->query('q');
    // ... existing search logic
    
    // Return view instead of JSON
    return view('admin.search-results', compact('results'));
}
```

## Kontak Support

Jika semua cara di atas tidak berhasil:
1. Kirim screenshot error console
2. Share error dari `storage/logs/laravel.log`
3. Konfirmasi hosting provider dan PHP version
4. Cek apakah fitur AJAX/fetch diblok oleh hosting
