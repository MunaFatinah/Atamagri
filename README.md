# 🌾 Atamagri — Platform Pertanian Cerdas 5.0

Platform pertanian berbasis Laravel yang terintegrasi dengan **OpenWeatherMap API** dan **Google Gemini AI** untuk monitoring cuaca real-time dan rekomendasi tanam cerdas.

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


### Google Gemini AI
- Endpoint: `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent`


---


