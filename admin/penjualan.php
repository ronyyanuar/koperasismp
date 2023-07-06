<?php
require_once './../config.php';
require_once './../functions.php';
?>

<?php
session_start();
if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  header("Location: ../login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin | Semua Order</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="../assets/img/svg/logo.svg" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
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
          <h2 class="main-title">Data Penjualan</h2>
          <div class="row">
            <div class="col-lg-12">
              <div class="users-table">
                <div class="text-right mb-3">
                  <a href="print/print-penjualan.php" class="btn btn-success"><i class="fas fa-print"></i> Cetak Laporan</a>
                </div>
                <table id="usersTable" class="table table-striped table-bordered">
                  <thead>
                    <tr class="users-table-info">
                      <th>No. Invoice</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>No HP</th>
                      <th>Total</th>
                      <th>Alamat</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $orders = getPenjualan();
                    foreach ($orders as $order) {
                      echo '<tr>';
                      echo '<td>' . $order['no_invoice'] . '</td>';
                      echo '<td>' . $order['nama_siswa'] . '</td>';
                      echo '<td>' . $order['email'] . '</td>';
                      echo '<td>' . $order['no_hp'] . '</td>';
                      echo '<td>' . $order['total'] . '</td>';
                      echo '<td>' . $order['alamat'] . '</td>';
                      echo '<td>';
                      echo '<a class="btn btn-primary" href="order-detail.php?id=' . $order['order_id'] . '"><i class="fas fa-eye"></i> Detail</a>';
                      echo '</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../assets/plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="../assets/plugins/feather.min.js"></script>
  <!-- DataTables library -->
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
  <!-- Custom scripts -->
  <script src="../assets/js/script.js"></script>
  <script>
    $(document).ready(function() {
      $('#usersTable').DataTable({
        paging: true,
        searching: true,
        lengthChange: false,
        pageLength: 10,
        language: {
          search: "Cari:",
          paginate: {
            first: "&laquo;",
            last: "&raquo;",
            next: "&rsaquo;",
            previous: "&lsaquo;"
          }
        }
      });

    });
  </script>
</body>

</html>
