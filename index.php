<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} else if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 1) {
    header("Location: admin/index.php");
    exit();
}


require_once 'config.php';
require_once 'functions.php';

if (isset($_POST['add_to_cart'])) {
    $produk_id = $_POST['produk_id'];
    $quantity = $_POST['quantity'];

    addToCart($produk_id, $quantity);
}

if (isset($_GET['remove'])) {
    $produk_id = $_GET['remove'];
    removeFromCart($produk_id);
}

if (isset($_GET['clear'])) {
    clearCart();
}

if (isset($_POST['process_payment'])) {
    $total = calculateTotal();

    $no_invoice = generateInvoiceNumber();

    $_SESSION['order'] = [
        'total' => $total,
        'items' => getCartItems(), 
        'no_invoice' => $no_invoice
    ];
    clearCart();
    header("Location: order.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$totalItems = 0;
$cartItems = getCartItems();
if (!empty($cartItems)) {
    foreach ($cartItems as $item) {
        $totalItems += $item['quantity'];
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Koperasi Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/home.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Koperasi Sekolah</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" id="cartIcon">
                        <i class="fas fa-shopping-cart"></i>
                        Keranjang
                        <?php if ($totalItems > 0): ?>
                            <span class="badge badge-danger"><?php echo $totalItems; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> <?php echo $_SESSION['nama']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <!-- <a class="dropdown-item" href="#">Profil Saya</a> -->
                        <a class="dropdown-item" href="#">Pesanan Saya</a>
                        <a class="dropdown-item" href="index.php?logout=true">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <!-- Display produk -->
        <div id="alertContainer"></div>
        <h2>Produk</h2>
        <div class="row">
            <?php
            $produk = getproduk();
            if (!empty($produk)) {
                foreach ($produk as $product) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $product['nama']; ?></h4>
                                <p class="card-text">Harga: <strong class="text-primary">Rp<?php echo $product['harga']; ?></strong></p>
                                <form method="post" action="index.php">
                                    <label for="quantity">Jumlah</label>
                                    <input type="hidden" name="produk_id" value="<?php echo $product['id']; ?>">
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" style="max-width: 70px;" value="1" min="1">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary" name="add_to_cart">
                                                <i class="fas fa-cart-plus"></i> Tambahkan Ke Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>Produk tidak ditemukan</p>';
            }
            ?>
        </div>

        <!-- Cart Popup -->
        <div class="cart-popup" id="cartPopup">
         <button id="cartCloseBtn" class="close-btn">Tutup</button>
            <h2>Keranjang</h2>
            <div class="cart-items">
                <?php
                $cart_items = getCartItems();
                if (!empty($cart_items)) {
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td><?php echo $item['nama']; ?></td>
                                    <td>Rp<?php echo $item['harga']; ?></td>
                                    <td>
                                        <input type="number" class="form-control" name="cart_items[<?php echo $item['id']; ?>][quantity]" value="<?php echo $item['quantity']; ?>" min="1">
                                    </td>
                                    <td>Rp<?php echo $item['total']; ?></td>
                                    <td>
                                        <a href="index.php?remove=<?php echo $item['id']; ?>" class="btn"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-right">
                    <form method="post" action="index.php">
                        <div class="text-right">
                            <p class="mb-2">Total: Rp<?php echo calculateTotal(); ?></p>
                            <a href="index.php?clear=1" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                            <button type="submit" class="btn btn-success" name="process_payment"><i class="far fa-credit-card"></i> Pembayaran</button>
                        </div>
                    </form>
                    </div>
                    <?php
                } else {
                    echo '<div class="cart-items">
                            <p>Keranjangmu masih kosong.</p>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showCartPopup() {
            document.getElementById('cartPopup').style.display = 'block';
            document.getElementById('mainContent').classList.add('blur');
        }

        function closeCartPopup() {
            document.getElementById('cartPopup').style.display = 'none';
            document.getElementById('mainContent').classList.remove('blur');
        }

        document.getElementById('cartIcon').addEventListener('click', function(e) {
            e.preventDefault();
            showCartPopup();
        });

        document.getElementById('cartCloseBtn').addEventListener('click', function(e) {
            e.preventDefault();
            closeCartPopup();
        });

        document.addEventListener('click', function(e) {
            if (!document.getElementById('cartPopup').contains(e.target) && !document.getElementById('cartIcon').contains(e.target)) {
                closeCartPopup();
            }
        });
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
        });
    </script>
</body>
</html>
