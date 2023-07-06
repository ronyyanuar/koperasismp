<?php
session_start();

require_once 'config.php';
require_once 'functions.php';

$encoded_order_id = $_GET['order_id'] ?? null;
$encoded_no_invoice = $_GET['no_invoice'] ?? null;
$encoded_total = $_GET['total'] ?? null;

$order_id = urldecode($encoded_order_id);
$no_invoice = urldecode($encoded_no_invoice);
$total = urldecode($encoded_total);

if (!$order_id) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selesaikan Pembayaran</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .container {
            max-width: 500px;
        }
        
        .mt-4 {
            margin-top: 2rem !important;
        }
        
        .text-center {
            text-align: center !important;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-5">Segera Selesaikan Pembayaran Anda!</h2>
        <div>
            <h4 class="mb-3">No. Invoice: <?php echo $_GET['no_invoice']; ?></h4>
            <h4>Detail Rekening Bank</h4>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Nama Bank</th>
                        <td>Bank XXX</td>
                    </tr>
                    <tr>
                        <th>Nama Rekening</th>
                        <td>KOPERASI SMPN XXXX</td>
                    </tr>
                    <tr>
                        <th>Nomor Rekening</th>
                        <td>121495035355</td>
                    </tr>
                    <tr>
                        <th>Total Pembayaran</th>
                        <td>Rp<?php echo $_GET['total'] ?></td>
                    </tr>
                </tbody>
            </table>
            
            <p>Setelah melakukan pembayaran, silakan lanjutkan dengan langkah-langkah yang diperlukan untuk menyelesaikan pesanan.</p>
            <div class="text-center">
                 <a href="index.php" class="btn btn-warning"><i class="fas fa-home"></i> Belanja Lagi</a>
                 <a href="" class="btn btn-success"><i class="fas fa-check-circle"></i> Saya Sudah Bayar</a>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>