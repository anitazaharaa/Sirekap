<?= $this->extend('templates/navbar_template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-4">
                <h5 class="card-header">Tambah Pengguna</h5>
                <div class="card-body">
                    <?php if ($validation = session()->getFlashdata('validation')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($validation as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('/users/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                        <input type="hidden" name="nik_lama" value="<?= $user['NIP'] ?>">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Nama Pengguna"
                                aria-describedby="floatingInputHelp" name="nama_karyawan"
                                value="<?= $user['nama_karyawan'] ?>" required />
                            <label for="floatingInput">Nama</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="number" class="form-control" id="floatingInput" placeholder="NIP"
                                aria-describedby="floatingInputHelp" name="NIP" value="<?= $user['NIP'] ?>" required />
                            <label for="floatingInput">NIP</label>
                        </div>
                        <div class="form-floating my-3">
                            <textarea name="alamat" id="alamat" class="form-control" id="floatingInput"
                                placeholder="Jl. Contoh No. 1" aria-describedby="floatingInputHelp" name="alamat"
                                required><?= $user['alamat'] ?></textarea>
                            <label for="floatingInput">Alamat</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Username"
                                aria-describedby="floatingInputHelp" name="username" value="<?= $user['username'] ?>"
                                required />
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="password" class="form-control" id="floatingInput" placeholder="*****"
                                aria-describedby="floatingInputHelp" name="password" />
                            <label for="floatingInput">Password</label>
                            <small>Biarkan kosong jika tidak ingin mengubah password</small>
                        </div>
                        <div class="my-3">
                            <select class="form-select" id="exampleFormControlSelect1"
                                aria-label="Default select example" style="height: 55px" name="role">
                                <option value="" <?= $user['role'] == '' ? 'selected' : '' ?>>--Pilih Role--</option>
                                <option value="Administrator" <?= $user['role'] == 'Administrator' ? 'selected' : '' ?>>
                                    Administrator</option>
                                <option value="Kepala Puskesmas" <?= $user['role'] == 'Kepala Puskesmas' ? 'selected' : '' ?>>Kepala Puskesmas</option>
                                <option value="Kepala Unit" <?= $user['role'] == 'Kepala Unit' ? 'selected' : '' ?>>Kepala
                                    Unit</option>
                                <option value="Staf Unit" <?= $user['role'] == 'Staf Unit' ? 'selected' : '' ?>>Staf Unit
                                </option>
                            </select>
                        </div>
                        <div class="my-3">
                            <select class="form-select" id="exampleFormControlSelect1"
                                aria-label="Default select example" style="height: 55px" name="unit_kerja">
                                <option value="" <?= $user['unit_kerja'] == '' ? 'selected' : '' ?>>--Pilih Unit Kerja--
                                </option>
                                <option value="Esensial dan Keperawatan Kesehatan Masyarakat"
                                    <?= $user['unit_kerja'] == 'Esensial dan Keperawatan Kesehatan Masyarakat' ? 'selected' : '' ?>>Esensial dan Keperawatan Kesehatan Masyarakat</option>
                                <option value="Pengembangan" <?= $user['unit_kerja'] == 'Pengembangan' ? 'selected' : '' ?>>Pengembangan</option>
                                <option value="Kefarmasian & Laboratorium" <?= $user['unit_kerja'] == 'Kefarmasian & Laboratorium' ? 'selected' : '' ?>>Kefarmasian & Laboratorium</option>
                                
                            </select>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Jabatan"
                                aria-describedby="floatingInputHelp" name="jabatan" value="<?= $user['jabatan'] ?>"
                                required />
                            <label for="floatingInput">Jabatan</label>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>