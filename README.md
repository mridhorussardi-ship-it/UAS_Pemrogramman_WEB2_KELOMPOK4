# Sistem Aspirasi Mahasiswa

Aplikasi web untuk menyampaikan, memantau, menanggapi, dan mengelola aspirasi mahasiswa. Dibangun menggunakan CodeIgniter 4, MySQL/MariaDB, Bootstrap, session authentication, dan JWT untuk REST API.

## Anggota Kelompok

1. Muhammad Ridho Russardi (2306700061) — UI/UX Designer
2. Syahrul Almunawar (2306700059) — Database Engineer
3. Elina Angelina (2306700067) — Backend Developer
4. Dimas Widjoyo Hartanto (2306700047) — System Analyst
5. Rayhan Nadindra Dhiya Ulhaq (2306700050) — Frontend Developer
6. Mochamad Indra Riswandi (2306700036) — Quality Assurance

## Fitur Utama

- Registrasi dan login berdasarkan role.
- Dashboard Admin, Dosen, dan Mahasiswa.
- Pembuatan, pemantauan, komentar, dan tindak lanjut aspirasi.
- Pengelolaan pengguna dan laporan oleh Admin.
- REST API dengan autentikasi JWT.

## Video Presentasi

Tautan video presentasi dan demonstrasi sistem:

[YouTube — Presentasi Sistem Aspirasi Mahasiswa](https://youtu.be/gKm9atcEWNA)


## Struktur Repository

- `backend/` — aplikasi CodeIgniter 4.
- `UI/UX/` — hasil desain antarmuka tiap role.
- `database-docs/` — ERD dan tabel relasional.
- `docs/FLOWCHART/` — source Draw.io dan ekspor flowchart.
- `docs/SRS/` — SRS utama dalam DOCX.
- `docs/usecasediagram.uml` — source Use Case StarUML.
- `docs/UseCaseDiagram.jpg` — ekspor Use Case.
- `postman/` — collection dan tautan dokumentasi Postman.

### Catatan Struktur Backend

Folder `app`, `public`, dan `tests` merupakan bagian dari proyek CodeIgniter 4. Ketiganya seharusnya berada di dalam folder `backend`, bukan terpisah di root repository.

```text
backend/
├── app/
├── public/
├── tests/
├── writable/
├── composer.json
├── composer.lock
└── spark
```

## Menjalankan Aplikasi

Prasyarat: PHP 8.2+, Composer, MySQL/MariaDB.

1. Buat database `aspirasi_db`.
2. Masuk ke folder `backend`.
3. Jalankan `composer install`.
4. Salin `env` menjadi `.env`.
5. Sesuaikan username/password database pada `.env`.
6. Jalankan:

```bash
php spark migrate
php spark db:seed UserSeeder
php spark serve
```

Buka `http://localhost:8080`.

Di Windows, `jalankan.bat` dapat dipakai setelah database tersedia.

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Admin | admin@aspirasi.com | admin123 |
| Dosen | budi@dosen.ac.id | dosen123 |
| Mahasiswa | andi@student.ac.id | mahasiswa123 |

## Dokumentasi API

- Collection: `postman/Sistem Aspirasi Mahasiswa.postman_collection.json`
- Dokumentasi: https://documenter.getpostman.com/view/56884231/2sBY4QtL3E
