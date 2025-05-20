# Sirekap – Sistem Informasi Manajemen Puskesmas

Selamat datang di **Sirekap**, teman baru Puskesmas untuk merencanakan, menjalankan, dan melaporkan program kerja tanpa pusing excel ke mana‑mana.

---

## Kenapa Sirekap?

* **Satu pintu**: Semua data kegiatan, anggaran, dan laporan terkumpul rapi di satu dashboard.
* **Transparan**: Sisa anggaran langsung terlihat begitu LPJ dikirim.
* **Cepat**: Proses persetujuan KAK & LPJ tinggal klik, tak perlu tukar‑tukar berkas.

---

## Fitur Inti

| Fitur               | Apa yang bisa dilakukan?                                                                                                                                               |
| ------------------- | ---------------------------------------------------------------------------                                                                                            |
| **Akun & Karyawan** | Buat akun staf, admin, hingga Kepala Puskesmas. Kelola profil karyawan.                                                                                                |
| **Pagu Anggaran**   | Masukkan anggaran setahun, sistem otomatis memotong saat kegiatan berjalan.                                                                                            |
| **KAK**             | Ajukan proposal kegiatan lengkap dengan estimasi biaya dan lampiran.                                                                                                   |
| **LPJ**             | Catat realisasi biaya, unggah bukti, sisa dana terhitung otomatis.                                                                                                     |
| **Kunjungan**       | Catat setiap kali tim Puskesmas turun ke desa—jumlah lokasi, tujuan, dan hasil kunjungan. Setelah LPJ disetujui, data kunjungan otomatis masuk laporan.                |
| **Riwayat**         | Arsip kegiatan selesai beserta penggunaan dananya.                                                                                                                     |
| **Dashboard**       | Grafik tren anggaran & kunjungan—mudah dibaca, mudah dipahami.                                                                                                         |

---

## Teknologi di Balik Layar

* **Frontend** : React + Vite + Tailwind CSS
* **Backend**  : Node.js + Express + JWT
* **Database** : MySQL (pakai Sequelize ORM)
* **DevOps**   : Docker Compose, GitHub Actions untuk CI/CD

---

## Cara Pasang di Laptop Kamu

```bash
# 1. Clone repo
$ git clone https://github.com/<username>/sirekap-puskesmas.git
$ cd sirekap-puskesmas

# 2. Salin env contoh
$ cp .env.example .env

# 3. Jalankan
$ docker compose up -d --build

# 4. Buka di browser
Frontend : http://localhost:5173
Backend  : http://localhost:3000/api
Login    : admin@example.com / password
```

---

## Alur Singkat Penggunaan

1. Admin mengelola manajemen user.
2. Staf ajukan KAK & LPJ untuk kegiatan tertentu.
3. Kepala Puskesmas meninjau dan menyetujui KAK & LPJ, serta menetapkan pagu anggaran per tahun.
4. Kepala Unit meninjau dan menyetujui KAK dan LPJ
5. Setelah kegiatan, **Staf** mengisi LPJ & unggah bukti.
6. Sistem memotong anggaran dan menyimpan riwayat otomatis.

---

| Dashboard                       | Form KAK                      | LPJ & Sisa Anggaran      |
| ------------------------------- | ----------------------------- | ------------------------ |
| ![image](https://github.com/user-attachments/assets/94d13198-4615-4904-ad46-718d619e47c6)| ![image](https://github.com/user-attachments/assets/b96e8fce-d492-41cb-8fd1-fce2924dec81) | ![image](https://github.com/user-attachments/assets/b29d576c-c840-4fb5-8007-88f1b0c4052b) ![image](https://github.com/user-attachments/assets/cb17df3b-bb0c-407c-8c7a-c0f0ccbea85d)
|


---

## Mau Ikut Kontribusi?

1. Fork repo → `git checkout -b fitur/namafitur`
2. Commit rapih & deskriptif
3. Buka Pull Request ☕️

---

## Lisensi

MIT License – bebas dipakai, dimodifikasi, dan dibagikan.

---

Dibuat dengan ❤ oleh **Anita Zahara**. Kalau ada ide atau kritik, silakan hubungi lewat [LinkedIn](https://www.linkedin.com/in/anitazaharaa/).
