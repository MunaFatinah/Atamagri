# 🌾 Atamagri — Platform Pertanian Cerdas 5.0

Platform pertanian berbasis Laravel yang terintegrasi dengan **OpenWeatherMap API** dan **Google Gemini AI** untuk monitoring cuaca real-time dan rekomendasi tanam cerdas.

---

## 🚀 Cara Instalasi

### 1. Persyaratan
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js (opsional, untuk asset)

### 2. Clone & Install

```bash
# Extract folder ini, lalu masuk ke direktori
cd atamagri

# Install dependencies
composer install

# Salin file .env
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 3. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=atamagri        # buat database ini dulu di MySQL
DB_USERNAME=root
DB_PASSWORD=password_anda
```

### 4. ⚠️ Konfigurasi API Keys (WAJIB untuk fitur lengkap)

Edit file `.env` dan isi API key:

```env
# OpenWeatherMap - daftar GRATIS di https://openweathermap.org/api
OWM_API_KEY=masukkan_api_key_owm_anda

# Google Gemini AI - daftar GRATIS di https://aistudio.google.com/
GEMINI_API_KEY=masukkan_api_key_gemini_anda
```

> **Tanpa API key:** Aplikasi tetap berjalan dengan data demo (cuaca simulasi & rekomendasi rule-based).

### 5. Migrasi & Seeding Database

```bash
php artisan migrate
php artisan db:seed
```

### 6. Jalankan Server

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 🔑 Akun Login Demo

| Role   | Email                  | Password    |
|--------|------------------------|-------------|
| Admin  | admin@atamagri.id      | admin123    |
| Petani | budi@email.com         | petani123   |

---

## 📂 Struktur Fitur

| Halaman             | URL                    | Keterangan                          |
|---------------------|------------------------|-------------------------------------|
| Landing Page        | `/`                    | Beranda dengan 2 feature card       |
| Monitoring Cuaca    | `/cuaca`               | Cek cuaca via OWM API               |
| Rekomendasi Tanam   | `/rekomendasi`         | AI rekomendasi via Gemini           |
| Testimoni           | `/testimoni`           | Form & daftar testimoni             |
| Login               | `/login`               | Autentikasi                         |
| Register            | `/register`            | Pendaftaran petani                  |
| Dashboard Petani    | `/dashboard`           | Cuaca + Rekomendasi (authenticated) |
| Admin Dashboard     | `/admin`               | Kelola user & statistik             |

---

## 🌐 API yang Digunakan

### OpenWeatherMap (OWM)
- Endpoint: `https://api.openweathermap.org/data/2.5/weather`
- Daftar gratis: https://openweathermap.org/api
- Free tier: 1000 call/hari

### Google Gemini AI
- Endpoint: `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent`
- Daftar gratis: https://aistudio.google.com/
- Free tier: tersedia

---

## 📞 Kontak

- 📍 Merten, Tohudan, Kec. Colomadu, Karanganyar, Jawa Tengah
- 📞 082114728871
- ✉️ atamagri@gmail.com
