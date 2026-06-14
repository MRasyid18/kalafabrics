# Panduan Perbaikan Registrasi - Fix untuk Error Role Enum

## Masalah yang Diperbaiki
Error: `SQLSTATE[01000]: Warning: 1265 Data truncated for column 'role' at row 1`

**Penyebab**: Role yang dikirim tidak sesuai dengan enum database (hanya boleh: `b2c`, `b2b`, `ranger`, `admin`)

## Perubahan yang Dilakukan

### 1. **AuthController.php** - Enhanced Validation
```php
'role' => ['required', 'string', 'in:b2c,b2b,ranger'],
```
- Validasi role dengan array syntax (lebih ketat)
- Custom error messages dalam Bahasa Indonesia
- Email validation dengan unique table reference

### 2. **User Model** - Model-Level Validation
- Tambahan boot() method dengan InvalidRoleException
- Validasi otomatis sebelum create/update
- Melindungi dari bypass pada level database

### 3. **InvalidRoleException** - Custom Exception
- Exception class baru untuk role validation errors
- Ditangani oleh exception handler global

### 4. **bootstrap/app.php** - Global Exception Handler
- Handler untuk InvalidRoleException
- Return JSON response dengan pesan detail

### 5. **API Endpoint Baru** - `GET /api/v1/auth/roles`
- Menampilkan semua role yang valid dengan deskripsi
- Membantu user memilih role saat registrasi
- Response JSON dengan label dan penjelasan

### 6. **Login Method** - Improved Error Message
- Pesan error dalam Bahasa Indonesia
- Lebih user-friendly

## Cara Menguji

### 1. **Lihat Role yang Valid**
```bash
curl -X GET http://localhost:8000/api/v1/auth/roles
```

**Response:**
```json
{
  "valid_roles": [
    {
      "value": "b2c",
      "label": "Member (Pembeli)",
      "description": "Belanja produk ramah lingkungan dan ikuti workshop"
    },
    {
      "value": "b2b",
      "label": "Partner Bisnis",
      "description": "Donasi limbah tekstil dan beli dalam jumlah besar"
    },
    {
      "value": "ranger",
      "label": "Relawan",
      "description": "Bantu operasional dan kampanye lingkungan"
    }
  ]
}
```

### 2. **Test Registrasi Dengan Role Valid**
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "b2c"
  }'
```

**Expected Response (201):**
```json
{
  "message": "Pendaftaran berhasil",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "b2c"
  },
  "token": "1|abcdefgh..."
}
```

### 3. **Test Registrasi Dengan Role Invalid** (AKAN DITOLAK)
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "pengguna"
  }'
```

**Expected Response (422):**
```json
{
  "message": "Unprocessable Content",
  "errors": {
    "role": [
      "Role harus salah satu dari: b2c (Member), b2b (Partner), atau ranger (Relawan)"
    ]
  }
}
```

### 4. **Test Duplicate Email**
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Another User",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "b2c"
  }'
```

**Expected Response (422):**
```json
{
  "message": "Unprocessable Content",
  "errors": {
    "email": [
      "Email sudah terdaftar"
    ]
  }
}
```

### 5. **Test Login**
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Expected Response (200):**
```json
{
  "message": "Login berhasil",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "b2c"
  },
  "token": "1|abcdefgh..."
}
```

## Demo Accounts untuk Testing
| Email | Password | Role |
|-------|----------|------|
| admin@kalafabrics.id | admin123 | admin |
| member@kalafabrics.id | password | b2c |
| partner@kalafabrics.id | password | b2b |
| ranger@kalafabrics.id | password | ranger |

## Layers of Validation

✅ **Controller Level**: Request validation dengan custom error messages  
✅ **Model Level**: Boot method validation sebelum insert/update  
✅ **Exception Level**: Custom exception handler dengan JSON response  
✅ **Database Level**: Enum constraint sebagai last resort  

## Troubleshooting

### Error: "Role tidak dikenali"
- Pastikan menggunakan salah satu dari: `b2c`, `b2b`, `ranger`
- Cek endpoint `GET /api/v1/auth/roles` untuk list role yang valid

### Error: "Email sudah terdaftar"
- Email harus unik di database
- Cek apakah email sudah pernah registrasi sebelumnya

### Error: "Konfirmasi password tidak sesuai"
- Pastikan field `password` dan `password_confirmation` sama persis

## File yang Dimodifikasi
1. ✅ `app/Http/Controllers/Api/AuthController.php` - Enhanced validation & getValidRoles()
2. ✅ `app/Models/User.php` - Model-level validation with InvalidRoleException
3. ✅ `app/Exceptions/InvalidRoleException.php` - Custom exception (new)
4. ✅ `bootstrap/app.php` - Global exception handler for InvalidRoleException
5. ✅ `routes/api.php` - New endpoint GET /api/v1/auth/roles

## Next Steps
1. Run migration: `php artisan migrate:fresh --seed`
2. Test semua endpoint sesuai panduan di atas
3. Jika berhasil, lanjutkan dengan implementasi controllers lain
