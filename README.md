## Sistem Peminjaman Buku

Sistem peminjaman buku dengan 2 tipe pengguna, admin dan user(anggota). Fiturnya meliputi:

#### Admin:

1. Admin CRUD master buku,
2. Admin CRUD anggota,
3. Admin approve/reject pengajuan,
4. Admin lihat peminjaman buku dan mengembalikan buku

#### User:

1. Anggota mengajukan peminjaman buku,
2. Anggota lihat peminjaman bukunya

#### API buku:

1. GET /api/books
   Mengambil data semua buku
2. GET /api/books/{code}
   Mengambil data buku sesuai dengan kode
3. POST /api/books
   Membuat buku baru
4. PUT /api/books/{code}
   Mengubah data buku sesuai dengan kode
5. DELETE /api/books/{code}
   Menghapus data buku sesuai dengan kode

## ERD (Entity Relationship Diagram)

![ERD](/ERD.png)

## Cara menjalankan project

1. `composer install`
2. `npm install`
3. `npm run dev`
4. ubah .env.example menjadi .env
5. `php artisan migrate --seed`
6. `php artisan serve`

Akun admin
`email: admin@admin.com`
`password: password`
