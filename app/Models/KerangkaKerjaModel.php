<?php

namespace App\Models; // Menentukan namespace tempat model ini berada

use CodeIgniter\Model; // Mengimpor kelas Model dari CodeIgniter

class KerangkaKerjaModel extends Model
{
    // Menentukan nama tabel yang digunakan
    protected $table = 'tbl_kerangka_kerja';
    // Menentukan primary key dari tabel
    protected $primaryKey = 'id_kak';
    // Mengaktifkan timestamps (created_at dan updated_at otomatis)
    protected $useTimestamps = true;
    // Menentukan field yang boleh diisi secara massal
    protected $allowedFields = ['program_kerja', 'nama_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'anggaran_dibutuhkan', 'anggaran_disetujui', 'penanggung_jawab', 'sasaran', 'target', 'file', 'status', 'catatan_status', 'tanggal_diterima'];

    // Mengambil semua KAK dengan status tertentu dan gabung data karyawan
    public function getKerjangkaKerjaWithUsers()
    {
        return $this->select('tbl_kerangka_kerja.*, tbl_karyawan.NIP, tbl_karyawan.nama_karyawan, tbl_karyawan.unit_kerja')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('status', "Diproses")
            ->orWhere("status", "Perlu Perbaikan KAK")
            ->orWhere("status", "Ditolak")
            ->orderBy("created_at", "asc")
            ->findAll();
    }

    // Mengambil KAK berdasarkan filter unit kerja
    public function getKerjangkaKerjaByFilter($filter)
    {
        return $this->select('tbl_kerangka_kerja.*, tbl_karyawan.NIP, tbl_karyawan.nama_karyawan')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('tbl_karyawan.unit_kerja', $filter)
            ->where('status', "Diproses")
            ->orWhere("status", "Perlu Perbaikan KAK")
            ->orWhere("status", "Ditolak")
            ->orderBy("created_at", "asc")
            ->findAll();
    }

    // Mengambil data KAK berdasarkan ID
    public function getKerjangkaKerjaById($id)
    {
        return $this->select('tbl_kerangka_kerja.*, tbl_karyawan.nama_karyawan, tbl_karyawan.unit_kerja')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('id_kak', $id)
            ->first();
    }

    // Mengambil KAK yang sudah diterima untuk keperluan LPJ
    public function getKerjangkaKerjaLpj()
    {
        return $this->select('tbl_kerangka_kerja.id_kak, tbl_kerangka_kerja.nama_kegiatan, tbl_kerangka_kerja.tanggal_mulai,tbl_kerangka_kerja.tanggal_selesai, tbl_karyawan.nama_karyawan, tbl_karyawan.unit_kerja, tbl_kerangka_kerja.status')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('status', "Diterima")
            ->orWhere("status", "Menunggu Persetujuan LPJ")
            ->orWhere("status", "Perlu Perbaikan LPJ")
            ->orderBy("tbl_kerangka_kerja.created_at", "asc")
            ->findAll();
    }

    // Mengambil data LPJ berdasarkan unit kerja
    public function getKerjangkaKerjaLpjWithFilter($unit)
    {
        return $this->select('tbl_kerangka_kerja.id_kak, tbl_kerangka_kerja.nama_kegiatan, tbl_kerangka_kerja.tanggal_mulai,tbl_kerangka_kerja.tanggal_selesai, tbl_karyawan.nama_karyawan, tbl_karyawan.unit_kerja, tbl_kerangka_kerja.status')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('tbl_karyawan.unit_kerja', $unit)
            ->Where('status !=', "Diproses")
            ->Where('status !=', "Selesai")
            ->orderBy("tbl_kerangka_kerja.created_at", "asc")
            ->findAll();
    }

    // Mengambil data LPJ yang sudah selesai
    public function getRiwayatLpj()
    {
        return $this->select('tbl_kerangka_kerja.id_kak, tbl_kerangka_kerja.nama_kegiatan, tbl_kerangka_kerja.tanggal_mulai,tbl_kerangka_kerja.tanggal_selesai, tbl_karyawan.nama_karyawan, tbl_karyawan.unit_kerja, tbl_kerangka_kerja.status')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('status', "Selesai")
            ->findAll();
    }

    // Mengambil riwayat LPJ berdasarkan unit kerja
    public function getRiwayatLpjWithFilter($unit)
    {
        return $this->select('tbl_kerangka_kerja.id_kak, tbl_kerangka_kerja.nama_kegiatan, tbl_kerangka_kerja.tanggal_mulai,tbl_kerangka_kerja.tanggal_selesai, tbl_karyawan.nama_karyawan, tbl_karyawan.unit_kerja, tbl_kerangka_kerja.status')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('tbl_karyawan.unit_kerja', $unit)
            ->where('status', "Selesai")
            ->orderBy("tbl_kerangka_kerja.created_at", "asc")
            ->findAll();
    }

    // Menghitung jumlah KAK dengan status "Selesai"
    public function countKakSelesai()
    {
        return $this->where('status', "Selesai")
            ->countAllResults();
    }

    // Menghitung jumlah KAK yang sedang berjalan (belum selesai)
    public function countKakBerjalan()
    {
        return $this
            ->Where('status', "Diterima")
            ->orWhere('status', "Menunggu Persetujuan LPJ")
            ->orWhere('status', "Perlu Perbaikan LPJ")
            ->countAllResults();
    }

    // Mengambil status 5 kegiatan terbaru
    public function statusKegiatan()
    {
        return $this->select('nama_kegiatan, status, created_at')
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->findAll();
    }

    // Menghitung total anggaran yang telah disetujui
    public function jumlahAnggaranKegiatan()
    {
        return $this->selectSum('anggaran_disetujui')
            ->first();
    }

    // Mengambil jumlah kegiatan per unit kerja
    public function getKerjangkaKerjaUnit($unit): int|string
    {
        return $this->select('tbl_karyawan.unit_kerja, COUNT(tbl_kerangka_kerja.id_kak) as jumlah_kegiatan')
            ->join('tbl_karyawan', 'tbl_karyawan.NIP = tbl_kerangka_kerja.penanggung_jawab')
            ->where('tbl_karyawan.unit_kerja', $unit)
            ->countAllResults();
    }

    // Mengambil jumlah KAK masuk per bulan (status proses)
    public function getKakCountByMonth($year)
    {
        return $this->select("MONTH(created_at) AS bulan, COUNT(*) AS total_kak")
            ->where("YEAR(created_at)", $year)
            ->where("status", "Diproses")
            ->orWhere("status", "Perlu Perbaikan KAK")
            ->groupBy("MONTH(created_at)")
            ->findAll();
    }

    // Mengambil jumlah LPJ masuk per bulan
    public function getLpjCountByMonth($year)
    {
        return $this->select("MONTH(created_at) AS bulan, COUNT(*) AS total_lpj")
            ->where("YEAR(created_at)", $year)
            ->where("status", "Diterima")
            ->orWhere("status", "Menunggu Persetujuan LPJ")
            ->orWhere("status", "Perlu Perbaikan LPJ")
            ->orWhere("status", "LPJ Ditolak")
            ->groupBy("MONTH(created_at)")
            ->findAll();
    }

    // Mengambil jumlah LPJ selesai per bulan
    public function getKakSelesaiByMonth($year)
    {
        return $this->select("MONTH(tbl_lpj.lpj_selesai) AS bulan, COUNT(*) AS total_lpj_selesai")
            ->join('tbl_lpj', 'tbl_kerangka_kerja.id_kak = tbl_lpj.id_kak')
            ->where("YEAR(tbl_lpj.lpj_selesai)", $year)
            ->where("tbl_kerangka_kerja.status", "Selesai")
            ->groupBy("MONTH(tbl_lpj.lpj_selesai)")
            ->findAll();
    }

    // Mengambil realisasi kegiatan per unit dan bulan
    public function realisasiKegiatan($unit, $bulan)
    {
        return $this->select('tbl_kerangka_kerja.nama_kegiatan, tbl_kerangka_kerja.target, GROUP_CONCAT(tbl_kunjungan.jumlah_kunjungan) as jumlah_kunjungan')
            ->join('tbl_lpj', 'tbl_lpj.id_kak = tbl_kerangka_kerja.id_kak')
            ->join('tbl_kunjungan', 'tbl_kerangka_kerja.id_kak = tbl_kunjungan.id_kak')
            ->join('tbl_karyawan', 'tbl_kerangka_kerja.penanggung_jawab = tbl_karyawan.NIP')
            ->where('tbl_karyawan.unit_kerja', $unit)
            ->Where('MONTH(tbl_lpj.lpj_selesai)', $bulan)
            ->groupBy('tbl_kerangka_kerja.nama_kegiatan, tbl_kerangka_kerja.target')
            ->findAll();
    }

    // Mengambil realisasi anggaran per kegiatan dan unit dalam bulan tertentu
    public function realisasiAnggaran($bulan)
    {
        return $this->select('tbl_kerangka_kerja.nama_kegiatan, tbl_karyawan.unit_kerja, tbl_kerangka_kerja.anggaran_disetujui, SUM(tbl_lpj.anggaran_digunakan) as anggaran_digunakan, tbl_kerangka_kerja.status')
            ->join('tbl_lpj', 'tbl_lpj.id_kak = tbl_kerangka_kerja.id_kak')
            ->join('tbl_karyawan', 'tbl_kerangka_kerja.penanggung_jawab = tbl_karyawan.NIP')
            ->Where('MONTH(tbl_kerangka_kerja.tanggal_diterima)', $bulan)
            ->groupBy('tbl_kerangka_kerja.nama_kegiatan, tbl_kerangka_kerja.anggaran_disetujui, tbl_kerangka_kerja.status, tbl_karyawan.unit_kerja')
            ->findAll();
    }

    // Menghitung total anggaran yang telah disetujui (duplikat dari jumlahAnggaranKegiatan)
    public function anggaranSetuju()
    {
        return $this->selectSum('anggaran_disetujui')
            ->first();
    }
}
?>
