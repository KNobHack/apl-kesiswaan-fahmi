<?php

$tingkat = [
    '1' => 'Satu',
    '2' => 'Dua',
    '3' => 'Tiga'
];

$rumpun = [
    'RPL' => 'Rekayasa Perangkat Lunak',
    'TKJ' => 'Teknik Komputer Jaringan',
    'AKL' => 'Akuntansi dan Keuangan Lembaga',
    'OTKP' => 'Otomatisasi dan Tata Kelola Perkantoran',
    'BDP' => 'Bisnis Daring dan Pemasaran',
    'UPW' => 'Usaha Perjalanan Wisata'
];

$kelas = [
    '1' => 'Satu',
    '2' => 'Dua',
    '3' => 'Tiga',
    '4' => 'Empat'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // array_key_exist untuk melindungi dari input yang tidak di inginkan
    if (isset($_POST['tingkat']))
        if (array_key_exists($_POST['tingkat'], $tingkat))
            $_SESSION['tingkat'] = $_POST['tingkat'];

    if (isset($_POST['rumpun']))
        if (array_key_exists($_POST['rumpun'], $rumpun))
            $_SESSION['rumpun'] = $_POST['rumpun'];

    if (isset($_POST['kelas']))
        if (array_key_exists($_POST['kelas'], $kelas))
            $_SESSION['kelas'] = $_POST['kelas'];
}
// Aksi tampil data
if ($_GET['aksi'] == 'tampil') : ?>
    <h3>Daftar Siswa</h3>
    <!-- Form Kelas -->
    <form method="POST">
        <div class="form-row align-items-center">
            <div class="form-group col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <select name="tingkat" class="form-control">
                    <option disabled selected>Tingkat</option>
                    <?php foreach ($tingkat as $key => $value) : ?>
                        <option value="<?= $key ?>" <?= (isset($_SESSION['tingkat'])) ? (($key == $_SESSION['tingkat']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <select name="rumpun" class="form-control">
                    <option disabled selected>Rumpun</option>
                    <?php foreach ($rumpun as $key => $value) : ?>
                        <option value="<?= $key ?>" <?= (isset($_SESSION['rumpun'])) ? (($key == $_SESSION['rumpun']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <select name="kelas" class="form-control">
                    <option disabled selected>Kelas</option>
                    <?php foreach ($kelas as $key => $value) : ?>
                        <option value="<?= $key ?>" <?= (isset($_SESSION['kelas'])) ? (($key == $_SESSION['kelas']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <button type="submit" class="btn btn-success btn-block">Submit</button>
            </div>
        </div>
    </form>
    <!-- Form Kelas(akhir) -->
    <!-- Pesan -->
    <?php if (isset($_SESSION['pesan'], $_SESSION['pesan_mode'])) : ?>
        <div class="alert alert-<?= $_SESSION['pesan_mode'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['pesan'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['pesan']) ?> <?php unset($_SESSION['pesan_mode']) ?>
    <?php endif ?>
    <!-- Pesan(akhir) -->
    <!-- Tombol Tambah -->
    <?php
        if ($_SESSION['role_user'] == 'siswa') {
            $hak_tambah_data = $user->ketua;
        } else if ($_SESSION['role_user'] == 'guru') {
            $hak_tambah_data = false;
        } elseif ($_SESSION['role_user'] == 'admin') {
            $hak_tambah_data = true;
        } else {
            $hak_tambah_data = false;
        } ?>
    <?php if ($hak_tambah_data) : ?>
        <a class="btn btn-primary mb-3 col-xl-3 col-lg-6 col-md-6 col-sm-12" href="home.php?file=siswa&aksi=tambah">Tambah Data Siswa</a>
    <?php endif ?>
    <!-- Tombol Tambah(akhir) -->
    <!-- Tabel Siswa -->
    <table width="100%" class="table table-bordered table-hover table-responsive-lg">
        <thead class="thead-dark text-center">
            <th scope="col" class="d-table-cell align-middle">No.</th>
            <th scope="col" class="d-table-cell align-middle">NIS</th>
            <th scope="col" class="d-table-cell align-middle">Nama</th>
            <th scope="col" class="d-table-cell align-middle">Tempat Lahir</th>
            <th scope="col" class="d-table-cell align-middle">Tanggal Lahir</th>
            <th scope="col" class="d-table-cell align-middle">L/P</th>
            <th scope="col" class="d-table-cell align-middle">Alamat</th>
            <th scope="col" class="d-table-cell align-middle">Aksi</th>
            <?php if ($role_user == 'siswa') : ?>
                <?php if ($user->ketua) : ?>
                    <th scope="col" class="d-table-cell align-middle">Hak</th>
                <?php endif ?>
            <?php elseif ($role_user == 'admin') : ?>
                <th scope="col" class="d-table-cell align-middle">Hak</th>
            <?php endif ?>
        </thead>
        <tbody>
            <?php
                if (!empty($_SESSION['tingkat']) || !empty($_SESSION['rumpun']) || !empty($_SESSION['kelas'])) {
                    $data = $class_siswa->tampil($_SESSION['tingkat'], $_SESSION['rumpun'], $_SESSION['kelas']);
                } else {
                    $data = null;
                }
                ?>
            <?php if (isset($data)) : ?>
                <?php $no = 0; ?>
                <?php foreach ($data as $barisSiswa) : ?>
                    <?php $no++ ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $barisSiswa->nis ?></td>
                        <td><?= $barisSiswa->nama ?><?= ($barisSiswa->ketua) ? '<sup>KM</sup>' : '' ?></td>
                        <td><?= $barisSiswa->tempat_lahir ?></td>
                        <td><?= $barisSiswa->tanggal_lahir ?></td>
                        <td><?= $barisSiswa->jenis_kelamin ?></td>
                        <td><?= $barisSiswa->alamat ?></td>
                        <!-- Aksi -->
                        <td>
                            <?php if ($role_user == 'siswa') : ?>
                                <?php if ($user->ketua || ($user->nis == $barisSiswa->nis && $barisSiswa->edit)) : ?>
                                    <div class="btn-group btn-group" role="group" aria-label="Aksi">
                                        <a class="btn btn-warning" href="home.php?file=siswa&aksi=edit&nis=<?= $barisSiswa->nis ?>">Edit</a>
                                        <?php if ($user->ketua) : ?>
                                            <a class="btn btn-danger" href="home.php?file=siswa&aksi=hapus&nis=<?= $barisSiswa->nis ?>">Hapus</a>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>
                            <?php else : ?>
                                <div class="btn-group btn-group" role="group" aria-label="Aksi">
                                    <a class="btn btn-warning" href="home.php?file=siswa&aksi=edit&nis=<?= $barisSiswa->nis ?>">Edit</a>
                                    <a class="btn btn-danger" href="home.php?file=siswa&aksi=hapus&nis=<?= $barisSiswa->nis ?>">Hapus</a>
                                </div>
                            <?php endif ?>
                        </td>
                        <!-- Aksi(akhir) -->
                        <!-- Hak -->
                        <?php if ($role_user == 'siswa') : ?>
                            <?php if ($user->ketua) : ?>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input ubahidentitas" type="checkbox" value="" id="ubahidentitas<?= $barisSiswa->nis ?>" data-nis="<?= $barisSiswa->nis ?>" data-status="<?= $barisSiswa->edit ?>" <?= ($barisSiswa->edit) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ubahidentitas<?= $barisSiswa->nis ?>">
                                            Ubah Identitas
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input buatakun" type="checkbox" value="" id="buatakun<?= $barisSiswa->nis ?>" data-nis="<?= $barisSiswa->nis ?>" data-status="<?= $barisSiswa->buat_akun ?>" <?= ($barisSiswa->buat_akun) ? 'checked' : '' ?>>
                                        <label class=" form-check-label" for="buatakun<?= $barisSiswa->nis ?>">
                                            Buat Akun
                                        </label>
                                    </div>
                                </td>
                            <?php endif ?>
                        <?php elseif ($role_user == 'admin') : ?>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input ubahidentitas" type="checkbox" value="" id="ubahidentitas<?= $barisSiswa->nis ?>" data-nis="<?= $barisSiswa->nis ?>" data-status="<?= $barisSiswa->edit ?>" <?= ($barisSiswa->edit) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="ubahidentitas<?= $barisSiswa->nis ?>">
                                        Ubah Identitas
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input buatakun" type="checkbox" value="" id="buatakun<?= $barisSiswa->nis ?>" data-nis="<?= $barisSiswa->nis ?>" data-status="<?= $barisSiswa->buat_akun ?>" <?= ($barisSiswa->buat_akun) ? 'checked' : '' ?>>
                                    <label class=" form-check-label" for="buatakun<?= $barisSiswa->nis ?>">
                                        Buat Akun
                                    </label>
                                </div>
                            </td>
                        <?php endif ?>
                        <!-- Hak(akhir) -->
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td colspan=100 class="text-center">Tidak Ditemukan Data</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
    <!-- Tabel Siswa(akhir) -->
<?php elseif ($_GET['aksi'] == 'tambah') : ?>
    <h3>Tambah Data Siswa</h3>
    <div class="col-lg-6 col-xl-6">
        <form method="post" action="home.php?file=siswa&aksi=simpan">
            <div class="form-group">
                <label for="">Nomor Induk Siswa</label>
                <input type="text" class="form-control" name="txtNis" placeholder="Masukan No. Induk" autofocus reqiured />
            </div>
            <div class="form-group">
                <label for="">Nama Lengkap</label>
                <input type="text" class="form-control" name="txtNama" placeholder="Masukan Nama Lengkap" reqiured />
            </div>
            <div class="form-row <?= ($role_user == 'siswa') ? 'd-none' : '' ?>">
                <div class="form-group col-3">
                    <label for="">Tingkat</label>
                    <select name="tingkat" class="form-control">
                        <option hidden selected></option>
                        <?php foreach ($tingkat as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= (isset($_SESSION['tingkat'])) ? (($key == $_SESSION['tingkat']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="">Rumpun</label>
                    <select name="rumpun" class="form-control">
                        <option hidden selected></option>
                        <?php foreach ($rumpun as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= (isset($_SESSION['rumpun'])) ? (($key == $_SESSION['rumpun']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-3">
                    <label for="">Kelas</label>
                    <select name="kelas" class="form-control">
                        <option hidden selected></option>
                        <?php foreach ($kelas as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= (isset($_SESSION['kelas'])) ? (($key == $_SESSION['kelas']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="">Tempat Lahir</label>
                    <input type="text" class="form-control" name="txtTempatLahir" placeholder="Masukan Tempat Lahir" size="30" required />
                </div>
                <div class="form-group col-6">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="txtTanggalLahir" required />
                </div>
            </div>
            <div class="mb-2">Jenis Kelamin</div>
            <div class="form-check form-check-inline">
                <input type="radio" id="L" name="txtJenisKelamin" value="L">
                <label for="L" class="form-check-label">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="P" name="txtJenisKelamin" value="P">
                <label for="L" class="form-check-label">Perempuan</label>
            </div>
            <div class="form-group">
                <label for="">Alamat lengkap</label>
                <textarea name="txtAlamat" class="form-control" placeholder="Masukan alamat lengkap" cols="50" required></textarea>
            </div>
            <div class="form-group <?= ($role_user == 'siswa') ? 'd-none' : '' ?>">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" id="Siswa_biasa" value="0">
                    <label class="form-check-label" for="Siswa_biasa">Siswa Biasa</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" id="ketua" value="1">
                    <label class="form-check-label" for="ketua">KM</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" id="Wakil_KM" value="2">
                    <label class="form-check-label" for="Wakil_KM">Wakil KM</label>
                </div>
            </div>
            <button class="btn btn-primary" type=" submit" name="tombolSimpan" value="Simpan">Simpan</button>
        </form>
    </div>
<?php elseif ($_GET['aksi'] == 'simpan') : ?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($role_user == 'siswa')
                $ketua = 0;
            else
                $ketua = $_POST['ketua'];

            $data = array(
                'nis' => $_POST['txtNis'],
                'nama' => $_POST['txtNama'],
                'tempat_lahir' => $_POST['txtTempatLahir'],
                'tanggal_lahir' => $_POST['txtTanggalLahir'],
                'jenis_kelamin' => $_POST['txtJenisKelamin'],
                'alamat' => $_POST['txtAlamat'],
                // Menggunakan verifikasi ada di baris 25
                'tingkat' => $_SESSION['tingkat'],
                'rumpun' => $_SESSION['rumpun'],
                'kelas' => $_SESSION['kelas'],
                'ketua' => $ketua,
                'edit' => '0',
                'buat_akun' => '0'
            );

            $class_siswa->simpan($data);
        }
        ?>
    <meta http-equiv="refresh" content="0; url=home.php?file=siswa&aksi=tampil">
<?php elseif ($_GET['aksi'] == 'edit') : ?>
    <?php
        $siswa = $class_siswa->detail($_GET['nis']);

        $pilihP = null;
        $pilihL = null;

        if ($siswa->jenis_kelamin == 'L')
            $pilihL = 'checked';
        else
            $pilihP = 'checked';

        ?>
    <h3>Edit Data Siswa</h3>
    <div class="col-lg-6 col-xl-6">
        <form method="post" action="home.php?file=siswa&aksi=update">
            <div class="form-group">
                <label for="">Nomor Induk Siswa</label>
                <input type="text" class="form-control" name="txtNis" value="<?= $siswa->nis ?>" placeholder="Masukan No. Induk" autofocus />
            </div>
            <div class="form-group">
                <label for="">Nama Lengkap</label>
                <input type="text" class="form-control" name="txtNama" value="<?= $siswa->nama ?>" placeholder="Masukan Nama Lengkap" autofocus />
            </div>
            <div class="form-row <?= ($role_user == 'siswa') ? 'd-none' : '' ?>">
                <div class="form-group col-3">
                    <label for="">Tingkat</label>
                    <select name="tingkat" class="form-control">
                        <option hidden selected></option>
                        <?php foreach ($tingkat as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= (isset($_SESSION['tingkat'])) ? (($key == $_SESSION['tingkat']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="">Rumpun</label>
                    <select name="rumpun" class="form-control">
                        <option hidden selected></option>
                        <?php foreach ($rumpun as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= (isset($_SESSION['rumpun'])) ? (($key == $_SESSION['rumpun']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-3">
                    <label for="">Kelas</label>
                    <select name="kelas" class="form-control">
                        <option hidden selected></option>
                        <?php foreach ($kelas as $key => $value) : ?>
                            <option value="<?= $key ?>" <?= (isset($_SESSION['kelas'])) ? (($key == $_SESSION['kelas']) ? 'selected' : '') : '' ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="">Tempat Lahir</label>
                    <input type="text" class="form-control" name="txtTempatLahir" value="<?= $siswa->tempat_lahir ?>" placeholder="Masukan Tempat Lahir" size="30" required />
                </div>
                <div class="form-group col-6">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="txtTanggalLahir" value="<?= $siswa->tanggal_lahir ?>" required />
                </div>
            </div>
            <div class="mb-2">Jenis Kelamin</div>
            <div class="form-check form-check-inline">
                <input type="radio" name="txtJenisKelamin" value="L" <?= $pilihL ?>>
                <label for="" class="form-check-label">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="txtJenisKelamin" value="P" <?= $pilihP ?>>
                <label for="" class="form-check-label">Perempuan</label>
            </div>
            <div class="form-group">
                <label for="">Alamat lengkap</label>
                <textarea name="txtAlamat" class="form-control" placeholder="Masukan alamat lengkap" cols="50" required><?= $siswa->alamat ?></textarea>
            </div>
            <div class="form-group <?= ($role_user == 'siswa') ? 'd-none' : '' ?>">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" id="Siswa_biasa" value="0">
                    <label class="form-check-label" for="Siswa_biasa">Siswa Biasa</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" id="ketua" value="1">
                    <label class="form-check-label" for="ketua">KM</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" id="Wakil_KM" value="2">
                    <label class="form-check-label" for="Wakil_KM">Wakil KM</label>
                </div>
            </div>
    </div>
    <button class="btn btn-primary" type=" submit" name="tombolSimpan" value="Simpan">Simpan</button>
    </form>
    </div>
<?php elseif ($_GET['aksi'] == 'update') : ?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            if (isset($_POST['ubahidentitas'])) :
                $data = [
                    'edit' => $_POST['edit']
                ];

                $class_siswa->update($_POST['txtNis'], $data);
            elseif (isset($_POST['buatakun'])) :
                $data = [
                    'buat_akun' => $_POST['buat_akun']
                ];

                $class_siswa->update($_POST['txtNis'], $data);

                // jika $_POST['buat_akun'] == '1'
                if ($_POST['buat_akun'] == '1')
                    $auth->tambahUser($_POST['txtNis'], 'siswa', '123');
                else
                    $auth->hapusUser($_POST['txtNis']);

            else :
                // Mencegah bukan KM merubah atribut ketua
                if ($role_user == 'siswa')
                    $ketua = 0;
                else
                    $ketua = $_POST['jabatan'];

                $data = array(
                    'nis' => $_POST['txtNis'],
                    'nama' => $_POST['txtNama'],
                    'tempat_lahir' => $_POST['txtTempatLahir'],
                    'tanggal_lahir' => $_POST['txtTanggalLahir'],
                    'jenis_kelamin' => $_POST['txtJenisKelamin'],
                    // Menggunakan verifikasi ada di baris 25
                    'alamat' => $_POST['txtAlamat'],
                    'tingkat' => $_SESSION['tingkat'],
                    'rumpun' => $_SESSION['rumpun'],
                    'kelas' => $_SESSION['kelas'],
                    'ketua' => $ketua
                );
                $class_siswa->update($_POST['txtNis'], $data);
            endif ?>
        <meta http-equiv="refresh" content="0; url=home.php?file=siswa&aksi=tampil">
    <?php endif ?>
<?php elseif ($_GET['aksi'] == 'hapus') : ?>
    <?php $class_siswa->hapus($_GET['nis']); ?>
    <meta http-equiv="refresh" content="0; url=home.php?file=siswa&aksi=tampil">
<?php else : ?>
    <p>error 404 : Halaman tidak ditemukan !</p>
<?php endif ?>