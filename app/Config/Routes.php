<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute ke halaman utama
$routes->get('/', 'Home::index');
// Autentikasi
$routes->post('/login', 'Home::login'); // Proses login
$routes->get('/logout', 'Home::logout'); // Proses logout

// Profil pengguna
$routes->get('/profile', 'Home::profile'); // Tampilkan profil
$routes->post('/profile/update', 'Home::profileUpdate'); // Update profil

// Dashboard
$routes->get('/dashboard', 'Home::dashboard'); // Halaman dashboard utama
$routes->get('/dashboard/getKakDataJson/(:any)', 'Home::getKakDataJson/$1'); // Data grafik KAK (JSON)
$routes->get('/dashboard/getLpjDataJson/(:any)', 'Home::getLpjDataJson/$1'); // Data grafik LPJ (JSON)
$routes->get('/dashboard/getKakSelesaiDataJson/(:any)', 'Home::getKakSelesaiDataJson/$1'); // Data KAK selesai per bulan
$routes->get('/dashboard/getPieUnit', 'Home::getPieUnit'); // Data Pie Chart berdasarkan unit
$routes->get('/dashboard/kinerjaUnit', 'Home::kinerjaUnit'); // Grafik kinerja unit

// Manajemen Users
$routes->get('/users', 'Users::index'); // Daftar user
$routes->get('/users/tambah', 'Users::tambah'); // Form tambah user
$routes->post('/users/tambah', 'Users::simpan'); // Simpan user baru
$routes->get('/users/edit/(:num)', 'Users::edit/$1'); // Edit user berdasarkan ID
$routes->post('/users/update', 'Users::update'); // Update data user
$routes->get('/users/hapus/(:num)', 'Users::hapus/$1'); // Hapus user

// Manajemen Pagu Anggaran
$routes->get('/pagu-anggaran', 'PaguAnggaran::index'); // Daftar pagu anggaran
$routes->get('/pagu-anggaran/tambah', 'PaguAnggaran::tambah'); // Form tambah pagu
$routes->post('/pagu-anggaran/simpan', 'PaguAnggaran::simpan'); // Simpan pagu baru
$routes->get('/pagu-anggaran/edit/(:num)', 'PaguAnggaran::edit/$1'); // Edit pagu berdasarkan ID
$routes->post('/pagu-anggaran/update', 'PaguAnggaran::update'); // Update pagu
$routes->get('/pagu-anggaran/hapus/(:num)', 'PaguAnggaran::hapus/$1'); // Hapus pagu

// Manajemen Data Karyawan
$routes->get('/karyawan', 'Karyawan::index'); // Daftar karyawan

// Manajemen Kerangka Acuan Kerja (KAK)
$routes->get('/kak', 'KerangkaKerja::index'); // Daftar KAK
$routes->post('/kak/filter', 'KerangkaKerja::filter'); // Filter KAK berdasarkan unit
$routes->get('/kak/tambah', 'KerangkaKerja::tambah'); // Form tambah KAK
$routes->post('/kak/tambah', 'KerangkaKerja::simpan'); // Simpan KAK baru
$routes->get('/kak/detail/(:num)', 'KerangkaKerja::detail/$1'); // Detail KAK
$routes->get('/kak/edit/(:num)', 'KerangkaKerja::edit/$1'); // Edit KAK
$routes->post('/kak/update', 'KerangkaKerja::update'); // Update KAK
$routes->get('/kak/hapus/(:num)', 'KerangkaKerja::hapus/$1'); // Hapus KAK
$routes->post('/kak/validasi', 'KerangkaKerja::validasi'); // Validasi KAK oleh admin

// Manajemen LPJ
$routes->get('/lpj', 'Lpj::index'); // Daftar LPJ
$routes->get('/lpj/batal/(:num)', 'Lpj::batal/$1'); // Batalkan pengisian LPJ
$routes->post('/lpj/filter', 'Lpj::filter'); // Filter LPJ berdasarkan unit
$routes->get('/lpj/tambah/(:num)', 'Lpj::tambah/$1'); // Form tambah LPJ berdasarkan ID KAK
$routes->post('/lpj/simpan', 'Lpj::simpan'); // Simpan LPJ
$routes->get('/lpj/detail/(:num)', 'Lpj::detail/$1'); // Detail LPJ
$routes->get('/lpj/edit/(:num)', 'Lpj::edit/$1'); // Edit LPJ
$routes->post('/lpj/update/', 'Lpj::update'); // Update LPJ
$routes->get('/lpj/hapus/(:num)', 'Lpj::hapus/$1'); // Hapus LPJ
$routes->post('/lpj/validasi', 'Lpj::validasi'); // Validasi LPJ oleh admin
$routes->get('/lpj/riwayat', 'Lpj::riwayatLpj'); // Riwayat LPJ selesai
$routes->post('/lpj/riwayat/filter', 'Lpj::riwayatLpjFilter'); // Filter riwayat LPJ

// Laporan Realisasi
$routes->get('/laporan/realisasi-kegiatan', 'Laporan::realisasiKegiatan'); // Laporan realisasi kegiatan
$routes->get('/laporan/detail-realisasi-kegiatan', 'Laporan::kegiatan'); // Detail realisasi kegiatan
$routes->get('/laporan/realisasi-anggaran', 'Laporan::anggaran'); // Laporan realisasi anggaran

// Override halaman 404 (tidak ditemukan)
$routes->set404Override('App\Controllers\Home::show404');
