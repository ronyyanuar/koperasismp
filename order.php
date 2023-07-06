<?php
session_start();

require_once 'config.php';
require_once 'functions.php';

$order = $_SESSION['order'] ?? null;

if (!$order) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['select_payment'])) {
    $payment_method = $_POST['payment_method'];
    $_SESSION['order'] = $order;

    $ordered['payment_method'] = $payment_method;
    $ordered['nama'] = $_SESSION['nama'];
    $ordered['email'] = $_SESSION['email'];
    $ordered['no_hp'] = $_SESSION['no_hp'];
    $ordered['alamat'] = $_SESSION['alamat'];
    $ordered['no_invoice'] = $order['no_invoice'];
    $ordered['total'] = $order['total'];

    $order_id = saveOrderToDatabase($ordered);

    saveItemsToDatabase($order['items'], $order_id);
    $dec_order_id = urldecode($order_id);
    $dec_no_invoice = urldecode($ordered['no_invoice']);
    $dec_total = urldecode($order['total']);
    
    if ($payment_method === 'transfer_bank' || $payment_method === 'bayar_ditempat') {
        header("Location: payment.php?order_id=$order_id&no_invoice=$dec_no_invoice&total=$dec_total");
        unset($_SESSION['order']);
        exit();
    } else {
        // Handle other payment methods
        // ...
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Order</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <!-- Your HTML code here -->
    <div class="container mt-4">
        <h2>Konfirmasi Order</h2>
        <div>
            <h4>No Invoice: <?php echo $order['no_invoice']; ?></h4>
            <?php
            if (isset($order['items']) && !empty($order['items'])) {
                $items = $order['items'];
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo $item['nama']; ?></td>
                                <td>Rp<?php echo $item['harga']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>Rp<?php echo $item['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <td colspan="3" style="text-align: right;">Total</td>
                                <td><?php echo 'Rp '. $order['total']; ?></td>
                            </tr>
                    </tbody>
                </table>
                <?php
            } else {
                echo '<p>Tidak ada produk yang diorder.</p>';
            }
            ?>

            <h4>Detail Pengiriman</h4>
            <p>Nama : <?php echo $_SESSION['nama']; ?></p>
            <p>No. HP : <?php echo $_SESSION['no_hp']; ?></p>
            <p>Alamat :<?php echo $_SESSION['alamat']; ?></p>

            <h4 class="mt-5">Metode Pembayaran</h4>
            <form method="post" action="order.php">
                <div class="form-group">
                    <select class="form-control" id="paymentMethod" name="payment_method" require>
                        <option value="transfer_bank">Transfer Bank</option>
                        <option value="bayar_ditempat">Bayar ditempat</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-lg btn-success" name="select_payment"><i class="fas fa-money-check-alt"></i> BAYAR SEKARANG</button>
            </form>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
