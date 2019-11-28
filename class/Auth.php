<?php
class Auth extends Database
{
    public function login($identifier, $password)
    {
        $this->bukaKoneksi();
        $identifier = mysqli_real_escape_string($this->mysqli, $identifier);
        $result = $this->mysqli->query("SELECT * FROM `user` WHERE `identifier` = '$identifier'") or die($this->cekError());
        $user = $result->fetch_object();
        if ($result->num_rows > 0 && $user->password == $password) {
            $_SESSION['identifier_user'] = $user->identifier;
            $_SESSION['role_user'] = $user->role;
            header('Location:home.php');
        } else {
            $_SESSION['pesan'] = 'Data tidak terdaftar';
            $_SESSION['pesan_mode'] = 'danger';
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location:index.php');
    }

    public function loginStatus()
    {
        if (
            !empty($_SESSION['identifier_user']) &&
            !empty($_SESSION['role_user'])
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    public function tambahUser($identifier, $role, $password = null)
    {
        $this->bukaKoneksi();

        $identifier = mysqli_real_escape_string($this->mysqli, $identifier);
        $password = mysqli_real_escape_string($this->mysqli, $password);

        // 3. Menjalankan query insert
        $this->mysqli->query("INSERT INTO `user` (`identifier`,`password`,`role`) VALUES('$identifier','$password','$role')");

        // 3. Tutup koneksi
        $this->tutupKoneksi();
    }

    public function hapusUser($identifier)
    {
        $this->bukaKoneksi();

        $identifier = mysqli_real_escape_string($this->mysqli, $identifier);

        // 3. Menjalankan query insert
        $this->mysqli->query("DELETE FROM `user` WHERE `identifier` = '$identifier'") or die($this->cekError());

        // 3. Tutup koneksi
        $this->tutupKoneksi();
    }
}
