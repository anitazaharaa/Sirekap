<?php

namespace App\Controllers; // Menentukan namespace agar autoloading bisa berjalan

class Home extends BaseController // Kelas Home mewarisi BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session(); // Inisialisasi session service
    }

    //menampilkan halaman utama
    public function index()
    {
        // Jika user sudah login, langsung redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        // Jika belum login, tampilkan halaman login
        $data = [
            'title' => 'Login | Sirekap',
        ];

        return view('pages/login', $data); // Menampilkan view login
    }

    //menampilkan halaman login
    public function login()
    {
        // inputan dari form login
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // melakukan verifikasi database user berdasarkan username
        $user = $this->UsersModel->where('username', $username)->first();

        if ($user) {
            $pass = $user['password'];
            $authenticatePassword = password_verify($password, $pass); // Verifikasi password

            if ($authenticatePassword) {
                // Ambil detail user lengkap berdasarkan NIP
                $user_login = $this->UsersModel->getUserKaryawan($user['NIP']);

                // Buat data session
                $ses_data = [
                    'username' => $user_login['username'],
                    'id_user' => $user_login['id_user'],
                    'nama_karyawan' => $user_login['nama_karyawan'],
                    'unit_kerja' => $user_login['unit_kerja'],
                    'role' => $user_login['role'],
                    'logged_in' => true
                ];

                $this->session->set($ses_data); // Simpan session
                return redirect()->to('/dashboard'); // Redirect ke dashboard
            } else {
                // Password salah
                $this->session->setFlashdata('error', 'Password salah. Silahkan coba lagi.');
                return redirect()->to('/');
            }
        } else {
            // Username tidak ditemukan
            $this->session->setFlashdata('error', 'Username tidak ditemukan. Silahkan coba lagi.');
            return redirect()->to('/');
        }
    }

    public function dashboard()
    {
        // Ambil data untuk ditampilkan di dashboard
        $data = [
            'title' => 'Dashboard',
            'user_login' => $this->session->get(),
            'total_karyawan' => $this->KaryawanModel->countAll(),
            'total_kak' => $this->KerangkaKerjaModel->countAll(),
            'total_kak_berjalan' => $this->KerangkaKerjaModel->countKakBerjalan(),
            'total_kak_selesai' => $this->KerangkaKerjaModel->countKakSelesai(),
            'statusKegiatan' => $this->KerangkaKerjaModel->statusKegiatan(),
            'jumlahPaguAnggaran' => $this->PaguAnggaranModel->getPaguAnggaran(date('Y')) ?? 0,
            'jumlahAnggaranDigunakan' => $this->LpjModel->jumlahAnggaranDigunakan()['anggaran_digunakan'],
            'jumlahAnggaranSetuju' => $this->KerangkaKerjaModel->anggaranSetuju()['anggaran_disetujui'],
            'jumlahKegiatanUnitEKKM' => $this->KerangkaKerjaModel->getKerjangkaKerjaUnit('Esensial dan Keperawatan Kesehatan Masyarakat'),
            'jumlahKegiatanUnitPengembangan' => $this->KerangkaKerjaModel->getKerjangkaKerjaUnit('Pengembangan'),
            'jumlahKegiatanUnitKL' => $this->KerangkaKerjaModel->getKerjangkaKerjaUnit('Kefarmasian & Laboratorium'),
        ];

        return view('pages/dashboard', $data); // Tampilkan view dashboard
    }

    public function profile()
    {
        // Tampilkan profil user yang sedang login
        $data = [
            'title' => 'Dashboard',
            'user_login' => $this->session->get(),
            'user' => $this->UsersModel->getUserKaryawanById($this->session->get('id_user'))
        ];

        return view('pages/profile', $data); // View profile user
    }

    public function profileUpdate()
    {
        // Ambil data dari form update
        $id = $this->request->getVar('id_user');
        $validation = \Config\Services::validation(); // Inisialisasi validasi

        // Aturan validasi
        $validation->setRules([
            'nama_karyawan' => 'required',
            'alamat' => 'required',
            'username' => 'required|min_length[5]',
        ]);

        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        // Data untuk update users
        $data_user = [
            'username' => $this->request->getVar('username'),
        ];

        // Data untuk update karyawan
        $data_karyawan = [
            'nama_karyawan' => $this->request->getVar('nama_karyawan'),
            'alamat' => $this->request->getVar('alamat'),
        ];

        // Jika password diisi, update password juga
        if ($this->request->getVar('password')) {
            $data_user['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        $this->UsersModel->update($id, $data_user); // Update user
        $this->KaryawanModel->update($this->request->getVar('NIP'), $data_karyawan); // Update karyawan

        return redirect()->to('/profile')->with('success', 'Data profile berhasil diubah');
    }

    public function getKakDataJson($year)
    {
        // Ambil data KAK per bulan untuk tahun tertentu, output JSON
        $kakData = $this->KerangkaKerjaModel->getKakCountByMonth($year);
        return $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->setJSON($kakData);
    }

    public function getLpjDataJson($year)
    {
        // Ambil data LPJ per bulan untuk tahun tertentu, output JSON
        $lpjData = $this->KerangkaKerjaModel->getLpjCountByMonth($year);
        return $this->response->setJSON($lpjData);
    }

    public function getKakSelesaiDataJson($year)
    {
        // Ambil data KAK selesai per bulan, output JSON
        $kakSelesaiData = $this->KerangkaKerjaModel->getKakSelesaiByMonth($year);
        return $this->response->setJSON($kakSelesaiData);
    }

    public function getPieUnit()
    {
        // Ambil jumlah kegiatan per unit
        $ekm = $this->KerangkaKerjaModel->getKerjangkaKerjaUnit('Esensial dan Keperawatan Kesehatan Masyarakat');
        $pengembangan = $this->KerangkaKerjaModel->getKerjangkaKerjaUnit('Pengembangan');
        $kl = $this->KerangkaKerjaModel->getKerjangkaKerjaUnit('Kefarmasian & Laboratorium');

        $total = $ekm + $pengembangan + $kl;

        // Hitung persentase masing-masing unit
        $rekm = ($ekm / $total) * 100;
        $rpengembangan = ($pengembangan / $total) * 100;
        $rkl = ($kl / $total) * 100;

        return $this->response->setJSON([
            $rekm,
            $rpengembangan,
            $rkl
        ]);
    }

    public function kinerjaUnit()
    {
        // Hitung persentase KAK yang selesai
        $total_kak = $this->KerangkaKerjaModel->countAll();
        $total_kak_selesai = $this->KerangkaKerjaModel->countKakSelesai();

        return $this->response->setJSON(number_format($total_kak_selesai / $total_kak * 100));
    }

    public function logout()
    {
        // Logout user dengan menghancurkan session
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function show404()
    {
        // Tampilkan halaman error 404
        $data['title'] = '404 Page Not Found';
        return view('pages/error404', $data);
    }
}
