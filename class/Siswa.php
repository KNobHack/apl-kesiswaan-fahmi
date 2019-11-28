<?php

class Siswa extends Database
{
    public function tampil($tingkat, $rumpun, $kelas)
    {
        $this->bukaKoneksi();

        // 1. mysqli_query
        $sql = $this->mysqli->query("SELECT * FROM `siswa` WHERE `tingkat` = '$tingkat' AND `rumpun` = '$rumpun' AND `kelas` = '$kelas' ORDER BY `nis`");
        while ($data = $sql->fetch_object()) {
            $dataAnggota[] = $data;
        }

        // 2. Jika datanya ada
        if (isset($dataAnggota)) {
            // Memberikan nilai balik atas data yang diambil dari db
            return $dataAnggota;
        }

        // 3. Tutup koneksi
        $this->tutupKoneksi();
    }

    public function detail($nis)
    {
        $this->bukaKoneksi();
        // Menghindari SQL Injection
        $nis = mysqli_real_escape_string($this->mysqli, $nis);

        // 1. mysqli_query
        $sql = $this->mysqli->query("SELECT * FROM `siswa` WHERE `nis` = '$nis'");
        $dataAnggota = $sql->fetch_object();

        // 2. Jika datanta ada
        if (isset($dataAnggota)) {
            // 3. Memberikan nilai balik atas data yang diambil dari db
            return $dataAnggota;
        }

        // 4. menutup koneksi db, procedural == mysqli_close()
        $this->tutupKoneksi();
    }

    public function update($nis, $data)
    {
        $this->bukaKoneksi();
        // Menghindari Second Order SQL Injection
        $nis = mysqli_real_escape_string($this->mysqli, $nis);

        // 1. Memecah array menjadi string
        $script_update_temp  = null;
        foreach ($data as $field => $value) {
            $value = htmlspecialchars($value);
            $script_update_temp .= "$field='$value',";
        }

        // 2. Menghilangkan tanda koma pada akhir string
        $script_update = rtrim($script_update_temp, ',');

        // 3. Menjalankan query update
        $this->mysqli->query("UPDATE `siswa` SET $script_update WHERE `nis`='$nis'");

        // 4. Tutup koneksi
        $this->tutupKoneksi();
    }

    public function hapus($nis)
    {
        // Menghindari SQL Injection
        $this->bukaKoneksi();
        $nis = mysqli_real_escape_string($this->mysqli, $nis);

        // 1. Jalankan perintah query delete
        $this->mysqli->query("DELETE FROM `siswa` WHERE `nis`='$nis'") or die($this->cekError());

        // 2. Tutup koneksi
        $this->tutupKoneksi();
    }

    public function simpan($data)
    {
        $this->bukaKoneksi();

        // 1. Membuat 2 kolom bantu
        $kolom_nya = null;
        $nilai_nya = null;

        // 2. Memecah antara kolom dan nilai
        foreach ($data as $kolom => $nilai) {
            $kolom_nya .= $kolom . ',';
            // Menghindari XSS
            $nilai = htmlspecialchars($nilai);
            $nilai_nya .= "'$nilai',";
        }

        // 3. Menghilangkan tanda koma pada masing masing variabel, untuk menghindari error mysql
        $kolom_nya_baru = rtrim($kolom_nya, ',');
        $nilai_nya_baru = rtrim($nilai_nya, ',');

        // 4. Membuat syntax sql untuk simpan
        $sql_simpan = "INSERT INTO siswa ($kolom_nya_baru) VALUES ($nilai_nya_baru)";

        // 5. Menjalankan perintah sql simpan
        $this->mysqli->query($sql_simpan);

        // 6. Close koneksi
        $this->tutupKoneksi();
    }
}
