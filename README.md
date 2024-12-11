# Aplikasi Pemilihan Ketua Senat Mahasiswa

Aplikasi Pemilihan Ketua Senat Mahasiswa adalah sebuah aplikasi berbasis web yang memungkinkan mahasiswa untuk memilih ketua senat mahasiswa melalui platform online. Aplikasi ini dibuat menggunakan PHP untuk backend dan AdminLTE3 untuk tampilan dashboard admin.

## Fitur Utama

- **Halaman Pemilihan**: Mahasiswa dapat memilih calon ketua senat.
- **Dashboard Admin**: Admin dapat melihat hasil pemilihan, mengelola calon ketua senat, dan memantau status pemilihan.
   - **Data Mahasiswa**: Menampilkan informasi mahasiswa yang dapat memilih.
   - **Data Kandidat**: Menampilkan daftar kandidat yang tersedia untuk dipilih.
   - **Monitoring Hasil Suara**: Memantau jumlah suara yang diterima oleh setiap kandidat secara real-time.
   - **Status Pemilih**: Memantau status pemilih, apakah sudah atau belum memberikan suara.
- **Keamanan**: Pengguna dapat melakukan autentikasi untuk melakukan pemilihan dengan menggunakan sistem login yang aman.

## Teknologi yang Digunakan

- **Frontend**: HTML, CSS, JavaScript, [AdminLTE3](https://adminlte.io/)(untuk tampilan admin dashboard)
- **Backend**: PHP (versi 8.0.30)
- **Database**: MySQL (XAMPP digunakan untuk pengembangan lokal)
- **Web Server**: Apache (XAMPP digunakan untuk pengembangan lokal)

## Instalasi

### Prasyarat
1. Install [XAMPP](https://www.apachefriends.org/download.html) untuk sistem Windows 
2. Pastikan PHP versi 8.0.30 atau yang lebih baru terpasang.
3. Database MySQL yang sudah diatur dengan aplikasi XAMPP.

### Langkah-langkah Instalasi

1. **Clone atau Unduh Repository ini**
   
   ```bash
   git clone https://github.com/Hasanmudzakir4/pilpresma.git

2. Buat Database di MySQL
   - Buka phpMyAdmin melalui XAMPP (akses melalui browser di http://localhost/phpmyadmin).
   - Buat database baru dengan nama db_pilpresma.
   - Impor file database yang telah disediakan dalam folder sql/ (db/db_pilpresma.sql) ke dalam database db_pilpresma yang baru dibuat.

3. Konfigurasi Koneksi Database
   - Edit file config.php dan sesuaikan dengan kredensial MySQL Anda jika diperlukan.
   - Pastikan pengaturan database pada file config.php sesuai dengan nama database yang telah Anda buat (db_pilpresma), username, dan password.
Jalankan Aplikasi

4.  Jalankan Aplikasi
- Pindahkan folder aplikasi ke dalam folder htdocs di direktori instalasi XAMPP.
- Akses aplikasi melalui browser di http://localhost/pilpresma.
