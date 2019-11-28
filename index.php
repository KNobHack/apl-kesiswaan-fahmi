<?php
session_start();

include('class/Database.php');
include('class/Auth.php');

$auth = new Auth;

if (isset($_POST['nis']) && isset($_POST['password'])) {
    $nis = $_POST['nis'];
    $password = $_POST['password'];

    if ($nis != '' && $password != '') {
        $auth->login($nis, $password);
    } else {
        $_SESSION['pesan'] = 'Masukkan data dengan benar';
        $_SESSION['pesan_mode'] = 'danger';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <title>Login Siswa</title>
</head>

<body class="bg-light">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Siswa</h1>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" value="<?php if (isset($nis)) echo $nis ?>" name="nis" class="form-control form-control-user" placeholder="Masukkan NIS..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div> -->
                                        <?php if (isset($_SESSION['pesan'])) : ?>
                                            <div class="alert alert-<?= $_SESSION['pesan_mode'] ?>" role="alert">
                                                <?= $_SESSION['pesan'] ?>
                                            </div>
                                            <?php unset($_SESSION['pesan']); ?>
                                        <?php endif ?>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="https://wa.me/623120790052?text=Saya%20adalah%20ketua%20murid%20dari%20kelas%20XII%20RPL%201%0ANIS%3A%0ANAMA%20LENGKAP%3A%0ATEMPAT%20LAHIR%3A%0ATANGGAL%20LAHIR%3A%0AJENIS%20KELAMIN%3A%0AALAMAT%3A(Desa%20Kec%20Kab)%0ATINGKAT%3A%0ARUMPUN%3A%0AKELAS%3A">Hubungi Admin</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>