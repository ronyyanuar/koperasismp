<?php
require_once './../config.php';
require_once './../functions.php';
session_start();
if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  header("Location: ../login.php");
  exit();
}
if (!isset($_GET['id'])) {
  header("Location: produk.php"); 
  exit();
}

$id = $_GET['id'];

$product = getProductById($id);

if (!$product) {
  header("Location: index.php"); 
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];

  $updateMessage = updateProduct($id, $nama, $harga);
}
?>

<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin | Edit Produk</title>
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
        <?php if (isset($updateMessage)) : ?>
            <div class="alert <?php echo ($updateMessage == 'Data berhasil diubah.') ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
                <?php echo $updateMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
          <h2 class="main-title">Edit Produk</h2>
          <div class="row">
            <div class="col-lg-11">
              <div class="users-table">
                <form method="POST">
                  <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $product['nama']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $product['harga']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                      <a href="produk.php" class="btn btn-warning">Kembali</a>
                      <button type="submit" class="btn btn-primary">Ubah Data</button>
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
