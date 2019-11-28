<?php
session_start();

include('class/Database.php');
include('class/Auth.php');
include('class/Siswa.php');

$auth = new Auth;
$class_siswa = new Siswa;

if ($auth->loginStatus() == 0) {
    $auth->logout();
}

if (isset($_GET['do'])) {
    if ($_GET['do'] == 'logout') {
        $auth->logout();
    }
}

if (isset($_GET['file']))
    $halaman = $_GET['file'];
else
    $halaman = '';
strtolower($halaman);

$identifier_user = $_SESSION['identifier_user'];
$role_user = $_SESSION['role_user'];
if ($role_user == 'siswa') {
    $user = $class_siswa->detail($identifier_user);
    $_SESSION['tingkat'] = $user->tingkat;
    $_SESSION['rumpun'] = $user->rumpun;
    $_SESSION['kelas'] = $user->kelas;
} elseif ($role_user == 'guru') {
    # code...
} elseif ($role_user == 'admin') {
    # code...
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplikasi Kesiswaan</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Aplikasi Data Siswa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($halaman == '') ? 'active' : '' ?>" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($halaman == 'siswa') ? 'active' : '' ?>" href="home.php?file=siswa&aksi=tampil">Data Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?do=logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid mt-2">
        <?php if (isset($_GET['file'])) : ?>
            <?php
                // Only allow include.php or file{1..3}.php
                if (
                    $_GET['file'] != "siswa"
                ) {
                    // This isn't the page we want!
                    echo "ERROR: File not found!";
                    exit;
                } else {
                    include($_GET['file'] . '.php');
                } ?>
        <?php else : ?>
            <h1 class="text-center">Selamat datang</h1>
        <?php endif ?>
    </div>
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        const url = "http://localhost/apl_kesiswaan/home.php"
        $('.ubahidentitas').click(function() {
            const nis = $(this).data('nis');

            if ($(this).data('status') == '1')
                edit = '0';
            else
                edit = '1';

            $.ajax({
                url: url + "?file=siswa&aksi=update",
                type: 'post',
                data: {
                    ubahidentitas: true,
                    txtNis: nis,
                    edit: edit
                }
            });
        });

        $('.buatakun').click(function() {
            const nis = $(this).data('nis');

            if ($(this).data('status') == '1')
                buat_akun = "0";
            else
                buat_akun = "1";

            $.ajax({
                url: url + "?file=siswa&aksi=update",
                type: 'post',
                data: {
                    buatakun: true,
                    txtNis: nis,
                    buat_akun: buat_akun
                }
            });

        });
    </script>
</body>

</html>