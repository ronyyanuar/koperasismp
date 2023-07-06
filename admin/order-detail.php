<?php

?>


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

// Check if the order ID is provided in the URL
if (isset($_GET['id'])) {
  $orderID = $_GET['id'];
  $order = getOrderDetail($orderID);
} else {
  // Redirect to the main page if the order ID is not provided
  header("Location: order.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin | Detail Order</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="../assets/img/svg/logo.svg" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.min.css">
</head>

<body>
  <div class="layer"></div>
  
  <!-- Body -->
  <div class="page-flex">
    <!-- Sidebar -->
    <?php require_once "menu-main.php"; ?>
    <div class="main-wrapper">
      <!-- Main nav -->
      <?php require_once "menu-navbar.php"; ?>
      <!-- Main -->
      <main class="main users chart-page" id="skip-target">
        <div class="container">
          <h2 class="main-title">
            Detail Order
          </h2>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Informasi Order</h4>
                    <div class="d-flex">
                        <span class="label mb-0  mr-3 <?php echo getOrderStatusLabelClass($order['status']); ?>"><b><?php echo $order['status']; ?></b></span>
                      <button class="btn btn-primary" onclick="window.print()">Print</button><br>
                    </div>
                  </div>
                  <div class="card-text">
                    <?php 
                    if ($order) {
                      // Display order details
                      echo "<table class=\"table table-borderless\">";
                      echo "<tr><th style=\"padding: 5px;\">Order ID:</th><td style=\"padding: 5px;\">" . $order['order_id'] . "</td></tr>";
                      echo "<tr><th style=\"padding: 5px;\">Name:</th><td style=\"padding: 5px;\">" . $order['nama_siswa'] . "</td></tr>";
                      echo "<tr><th style=\"padding: 5px;\">Email:</th><td style=\"padding: 5px;\">" . $order['email'] . "</td></tr>";
                      echo "<tr><th style=\"padding: 5px;\">Phone Number:</th><td style=\"padding: 5px;\">" . $order['no_hp'] . "</td></tr>";
                      echo "<tr><th style=\"padding: 5px;\">Total:</th><td style=\"padding: 5px;\">" . $order['total'] . "</td></tr>";
                      echo "<tr><th style=\"padding: 5px;\">Address:</th><td style=\"padding: 5px;\">" . $order['alamat'] . "</td></tr>";
                      echo "</table><br>";
                    
                      // Display order items
                      echo "<h4 class=\"card-title\">Daftar Produk</h4>";
                      echo "<table class=\"table\">";
                      echo "<thead>";
                      echo "<tr><th>Nama</th><th>Quantity</th><th>Harga</th></tr>";
                      echo "</thead>";
                      echo "<tbody>";
                      foreach ($order['items'] as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['nama'] . "</td>";
                        echo "<td>" . $item['quantity'] . "</td>";
                        echo "<td>" . $item['harga'] . "</td>";
                        echo "</tr>";
                      }
                      echo "</tbody>";
                      echo "</table>";
                    } else {
                      echo "<p>Order not found.</p>";
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- Footer -->
      <footer class="footer">
        <div class="container">
          <div class="footer-start">
            <p>2023 © Koperasi Sekolah</p>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../assets/plugins/feather.min.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>
