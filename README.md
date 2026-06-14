# KalaFabrics — Circular Textile Ecosystem

Website untuk ekosistem tekstil sirkular KalaFabrics. Dibangun dengan **Laravel 11** dan **PHP 8.2**.

---

## Halaman yang Tersedia

| Route | Halaman |
|---|---|
| `/` | Beranda Interaktif |
| `/catalog` | Katalog Produk |
| `/impact` | Dashboard Dampak |
| `/education` | Edukasi Limbah Tekstil |
| `/ranger` | Program Ranger |
| `/contact` | Hubungi Kami |
| `/cart` | Keranjang Belanja |
| `/checkout` | Pembayaran |
| `/login` | Sign In |
| `/register` | Daftar Akun |

---

## Cara Instalasi

### 1. Persyaratan
- PHP **8.2.x**
- Composer 2.x
- MySQL 8.0+ / MariaDB 10.6+
- Node.js (opsional, untuk build asset)

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_DATABASE=kalafabrics
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Jalankan Migrasi
```bash
php artisan migrate
php artisan db:seed
```

### 6. Jalankan Server Development
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## Struktur Folder Utama

```
kalafabrics/
├── app/
│   ├── Http/Controllers/     ← Controllers (siap diisi logic backend)
│   └── Models/               ← Eloquent Models
├── public/
│   ├── css/app.css           ← Stylesheet utama
│   └── js/app.js             ← JavaScript utama
├── resources/views/
│   ├── layouts/app.blade.php ← Layout utama (navbar + footer)
│   └── pages/                ← Semua halaman blade
│       ├── home.blade.php
│       ├── catalog.blade.php
│       ├── cart.blade.php
│       ├── checkout.blade.php
│       ├── login.blade.php
│       ├── register.blade.php
│       ├── impact.blade.php
│       ├── education.blade.php
│       ├── ranger.blade.php
│       └── contact.blade.php
└── routes/web.php            ← Definisi semua route
```

---

## Teknologi

- **Backend**: Laravel 11 (PHP 8.2)
- **Frontend**: Blade Template + Vanilla CSS + Vanilla JS
- **Font**: Cormorant Garamond (display) + DM Sans (body)
- **Charts**: HTML5 Canvas (tanpa library eksternal)
- **Database**: MySQL

---

## Catatan Pengembangan

- Seluruh tampilan sudah selesai (frontend only)
- Backend (auth, CRUD produk, cart session, checkout) belum diimplementasikan — siap untuk dikembangkan
- File CSS dan JS ada di `public/css/app.css` dan `public/js/app.js`
- Tidak menggunakan Tailwind / Bootstrap — murni custom CSS

---

*© 2024 KalaFabrics. Crafted with Quiet Sustainability.*
