# Liebart Art-Showcase-System

------------------------------------------------------------------------

## Layout



###  Halaman Utama & Galeri
Galeri karya seni digital yang dapat diakses publik dengan filter
kategori dan pencarian.


###  Profil Kreator (Member)

Portofolio member menampilkan karya, bio, dan tautan sosial media.



###  Detail Challenge

Halaman kompetisi lengkap dengan aturan, hadiah, dan galeri submission.

### Dashboard Admin

Pusat kontrol untuk moderasi konten, statistik, dan manajemen pengguna.

------------------------------------------------------------------------

## Daftar Isi

-   🎯 Tentang Proyek
-   👥 Peran Pengguna
-   ✨ Fitur Utama
-   🛠 Teknologi
-   🚀 Instalasi
-   📂 Struktur Proyek

------------------------------------------------------------------------

# 🎯 Tentang Proyek

**LiebArt** adalah platform showcase karya seni digital yang dirancang
untuk menjadi wadah bagi kreator (Member) untuk memamerkan portofolio
mereka dan bagi pengguna lain untuk menemukan inspirasi.

Sistem ini menghubungkan kreator dengan audiens melalui fitur interaktif
seperti **Likes, Komentar, dan Favorites**. Keamanan komunitas dijaga
ketat melalui **sistem moderasi konten (Report System)** dan **validasi
akun kurator**.

### Nilai Utama

✅ **Multi-Role System**\
✅ **Community Engagement**\
✅ **Creative Challenges**\
✅ **Content Safety**

------------------------------------------------------------------------

##  Peran Pengguna

### 1.  Admin

-   Moderasi laporan konten\
-   Menghapus konten melanggar\
-   Manajemen Member & Curator\
-   CRUD kategori seni\
-   Dashboard statistik

### 2.  Member (Creator)

-   Upload/Edit/Hapus artwork\
-   Kelola profil\
-   Interaksi sosial\
-   Submit challenge

### 3.  Curator

-   Pendaftaran khusus & approval Admin\
-   Manajemen challenge\
-   Penjurian pemenang\
-   Dashboard

### 4.  Guest

-   Melihat galeri & challenge publik

------------------------------------------------------------------------

##  Fitur Utama

###  Manajemen Karya

-   Gambar & teks\
-   Smart display\
-   Kategori/tag

###  Interaksi & Sosial

-   Like & favorite (real-time)\
-   Komentar\
-   Sistem report polymorphic

###  Sistem Challenge

-   Event & banner\
-   Submission dari portofolio\
-   Validasi anti submit ganda\
-   Hall of Fame

------------------------------------------------------------------------

##  Teknologi

### Backend

-   Laravel 11\
-   PHP 8+\
-   MySQL

### Frontend

-   Blade\
-   Tailwind CSS\
-   Alpine.js

------------------------------------------------------------------------

##  Instalasi

#### 1️⃣ Clone Repo

    git clone https://github.com/username/liebart-platform.git
    cd liebart-platform

#### 2️⃣ Install Dependencies

    composer install
    npm install

#### 3️⃣ Setup ENV

    cp .env.example .env
    php artisan key:generate

#### 4️⃣ Migrasi & Seeder

    php artisan migrate:fresh --seed

#### 5️⃣ Storage

    php artisan storage:link

#### 6️⃣ Jalankan

Backend:

    php artisan serve

Frontend:

    npm run dev

------------------------------------------------------------------------

## 📂 Struktur Proyek

    liebart/
    ├── app/
    │   ├── Http/Controllers/
    │   ├── Models/
    │   └── Policies/
    ├── database/
    │   ├── migrations/
    │   └── seeders/
    ├── resources/
    │   ├── views/
    │   └── css/
    └── routes/
        ├── web.php
        └── auth.php

------------------------------------------------------------------------
