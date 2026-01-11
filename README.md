# SI-BIKO (Sistem Informasi Bimbingan Konseling)

SI-BIKO adalah platform **Sistem Informasi Bimbingan Konseling** berbasis **Laravel + Vue** yang dirancang untuk memfasilitasi penanganan permasalahan mahasiswa secara **berjenjang dan terstruktur**, mulai dari tingkat **Program Studi (Dosen PA/Konselor)** hingga **tingkat Fakultas (Wakil Dekan III)**.

Sistem ini mendukung mekanisme rujukan, pengelolaan ajuan mahasiswa, serta manajemen pengguna berbasis peran (*role-based access*).

---

## 🚀 Fitur Utama

- **Multi-Role Access**
  - Mahasiswa
  - Dosen PA
  - Konselor
  - Wakil Dekan III
  - Admin

- **Hierarchical Handling**
  - Ajuan yang tidak terselesaikan di tingkat Prodi dapat dirujuk ke tingkat Fakultas (WD III).

- **Automated Handler**
  - Ajuan mahasiswa otomatis diarahkan ke **Dosen PA** masing-masing berdasarkan data akademik.

- **Referral System**
  - Sistem rujukan lengkap hingga tingkat Universitas dengan pencetakan data otomatis.

- **Admin Dashboard**
  - Manajemen data Mahasiswa & Staff
  - Statistik global dan kontrol sistem terpusat.

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel (REST API)
- **Frontend**: Vue.js + Vite
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Package Manager**: Composer & NPM

---

## ⚙️ Setup & Instalasi
```bash
 1. Clone Repository & Masuk Folder
git clone <url-repo>
cd sibiko-backend

2. Instal Dependency Backend
composer install

3. Setup File Environment
cp .env.example .env
php artisan key:generate

4. Konfigurasi Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sibiko_db
DB_USERNAME=root
DB_PASSWORD=

5. Jalankan Migrasi & Seeder
php artisan migrate:fresh --seed

6. Instal Dependency Frontend
npm install

7. Konfigurasi Tailwind CSS
content: [
  "./resources/**/*.blade.php",
  "./resources/**/*.js",
  "./resources/**/*.vue",
],

8. Menjalankan Aplikasi
Terminal 1 --> php artisan serve 
Terminal 2 --> npm run dev

