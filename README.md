<div align="center">
  <h1>🌾 Portal Informasi & Pelayanan Desa Cigagade</h1>
  <p>
    Website resmi Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut, Jawa Barat 44186.
    Platform digital terpadu sebagai pusat pelayanan administrasi warga, publikasi kabar desa, potensi pertanian & UMKM, transparansi kelembagaan, serta dokumentasi kegiatan masyarakat.
  </p>
</div>

---

## 📌 Tentang Desa Cigagade

Desa Cigagade adalah salah satu desa di Kecamatan Balubur Limbangan, Kabupaten Garut, Jawa Barat. Desa ini dipimpin oleh Kepala Desa **Devi Fahruroji** dan didukung oleh jajaran perangkat desa, BPD, LPMD, Karang Taruna Karya Muda, TP-PKK, Gapoktan, dan BUMDes Gagade Mandiri. Desa Cigagade terkenal dengan potensi pertanian padi, jagung, tembakau, perikanan air tawar (Sungai Cipancar), serta situs budaya bersejarah Kiai Gede / Sunan Cibalampu.

---

## 🚀 Fitur Unggulan

### 🌐 Portal Publik (Front-End)
- **Bilingual Interface**: Dukungan dwi-bahasa (Bahasa Indonesia & English) dengan sistem *cookie & Alpine.js dynamic translation*.
- **Layanan Surat Mandiri Warga**: Fitur interaktif pengajuan administrasi online (SKU, SKCK, SKTM, Domisili, Belum Menikah, Kematian) dengan penerusan instan ke WhatsApp Resmi Pelayanan Kantor Desa.
- **Pusat Kabar Desa**:
  - **Kabar Terkini**: Berita pembangunan desa, penyaluran bantuan, dan musyawarah warga.
  - **Pengumuman Resmi**: Surat edaran, jadwal posyandu, dan informasi layanan publik.
  - **Prestasi Desa**: Arsip keberhasilan dan apresiasi lomba tingkat kecamatan maupun kabupaten.
- **Potensi Desa & UMKM**: Informasi potensi komoditas pertanian, perikanan, ekonomi kreatif warga, wisata alam, serta tradisi lokal.
- **Cigagade TV & Galeri Multimedia**: Dokumentasi visual kegiatan, liputan desa, video YouTube, dan integrasi media sosial.
- **Aparatur & Kelembagaan Desa**: Profil Perangkat Desa, Badan Permusyawaratan Desa (BPD), LPMD, Karang Taruna, dan TP-PKK.
- **Fitur Aksesibilitas**: Widget ramah disabilitas (Text-to-Speech pembaca artikel, font disleksia, mode kontras tinggi, pembesar teks).

### 🔐 Dashboard Manajemen (Back-End CMS)
- **Role-Based Access Control (RBAC)**: Pengelolaan peran `superadmin` dan `admin`.
- **Editor Konten Interaktif**: Quill & TinyMCE Rich Text Editor untuk kemudahan penulisan artikel dan pengumuman.
- **Manajemen Perangkat Desa**: Pengaturan struktur aparatur desa, jabatan, dan foto.
- **Manajemen Mitra & Lembaga**: Pengelolaan hubungan instansi dan BUMDes.
- **Media & Hero Slider**: Kontrol visual banner halaman utama secara dinamis.
- **Pengaturan Profil Situs**: Kelola visi misi, sambutan Kepala Desa, kontak layanan, serta media sosial.

---

## 🛠 Teknologi yang Digunakan

- **Core Framework**: [Laravel 12.x](https://laravel.com)
- **Programming Language**: PHP 8.2+
- **Database**: MySQL (`db_desa_cigagade`)
- **Front-End Styling**: Tailwind CSS & Vanilla CSS Design System
- **Reactivity & Interactivity**: Alpine.js & FontAwesome 6
- **Asset Bundler**: Vite
- **Authentication**: Laravel Breeze
- **Text Editor**: Quill.js

---

## ⚙️ Panduan Menjalankan Sistem

### 1. Kebutuhan Sistem
- PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`)
- MySQL / MariaDB Server
- Composer
- Node.js & NPM

### 2. Konfigurasi Database (.env)
Pastikan file `.env` mengarah ke database desa:
```env
APP_NAME="Desa Cigagade"
APP_LOCALE=id
APP_FALLBACK_LOCALE=id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_desa_cigagade
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Seeder Data Desa Cigagade
Jalankan migrasi dan seeder lengkap:
```bash
php artisan migrate:fresh --seed
```

### 4. Akun Admin Default
- **Email**: `admin@desacigagade.id`
- **Password**: `adminCigagade2026!#$`
- **Role**: `superadmin`

Akun sekunder:
- **Email**: `paskalluffy@gmail.com`
- **Password**: `password`

### 5. Menjalankan Server Lokal
```bash
npm run dev
php artisan serve
```
Akses portal melalui peramban web: `http://localhost:8000`

---

## 🏛️ Pemerintah Desa Cigagade
- **Alamat Kantor**: Jl. Raya Cigagade, Kec. Balubur Limbangan, Kab. Garut, Jawa Barat 44186
- **Email**: desa.cigagade@garutkab.go.id
- **WhatsApp Layanan**: +62 812-3456-7890
