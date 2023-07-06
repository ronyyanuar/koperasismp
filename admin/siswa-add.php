<?php
session_start();
require_once './../config.php';
require_once './../functions.php';
if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  header("Location: ../login.php");
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $no_hp = $_POST['no_hp'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $kelas = $_POST['kelas'];

  $addMessage = insertSiswa($nama,$alamat, $no_hp, $username, $password, $email, $kelas);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin | Tambah Siswa</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="../assets/img/svg/logo.svg" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.min.css">
</head>

<body>
  <div class="layer"></div>
  <!-- ! Body -->
  <div class="page-flex">
    <!-- ! Sidebar -->
    <?php require_once "menu-main.php"; ?>
    <div class="main-wrapper">
      <!-- ! Main nav -->
      <?php require_once "menu-navbar.php"; ?>
      <!-- ! Main -->
      <main class="main users chart-page" id="skip-target">
        <div class="container">
        <?php if (isset($addMessage)) : ?>
            <div class="alert <?php echo ($addMessage == 'Data siswa berhasil ditambahkan.') ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
                <?php echo $addMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
          <h2 class="main-title">Tambah Siswa</h2>
          <div class="row">
            <div class="col-lg-11">
              <div class="users-table">
                <form method="POST">
                  <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-6">
                      <textarea type="text" class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-6">
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-6">
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                      <a href="siswa.php" class="btn btn-warning">Kembali</a>
                      <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- ! Footer -->
      <footer class="footer">
        <div class="container footer--flex">
          <div class="footer-start">
            <p>2023 © Koperasi Sekolah</p>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Chart library -->
  <script src="../assets/plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="../assets/plugins/feather.min.js"></script>
  <!-- Custom scripts -->
  <script src="../assets/js/script.js"></script>
</body>

</html>
