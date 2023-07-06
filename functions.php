<?php
function addToCart($produk_id, $quantity) {
    if ($quantity < 1) {
        return;
    }

    global $conn;
    $query = "SELECT * FROM produk WHERE id = '$produk_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        $_SESSION['cart'][$produk_id] = array(
            'id' => $product['id'],
            'nama' => $product['nama'],
            'harga' => $product['harga'],
            'quantity' => $quantity,
            'total' => $product['harga'] * $quantity
        );
        $message = "Barang berhasil ditambahkan ke keranjang.";
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check"></i> ' . $message . '
            </div>';

        echo '<script>
                setTimeout(function() {
                    var successAlert = document.getElementById("successAlert");
                    if (successAlert) {
                        successAlert.remove();
                    }
                }, 2000);
            </script>';
    }
}

function removeFromCart($produk_id) {
    unset($_SESSION['cart'][$produk_id]);
}

function clearCart() {
    unset($_SESSION['cart']);
}

function getproduk() {
    global $conn;
    $query = "SELECT * FROM produk";
    $result = $conn->query($query);

    $produk = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }
    }

    return $produk;
}

function getCartItems() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
}

function calculateTotal() {
    $total = 0;
    $cart_items = getCartItems();
    foreach ($cart_items as $item) {
        $total += $item['total'];
    }
    return $total;
}

// Function to save order details to the database
function saveOrder($nama_siswa, $email, $total) {
    global $conn;
    
    $query = "INSERT INTO orders (nama_siswa, email, total) VALUES ('$nama_siswa', '$email', $total)";
    $result = $conn->query($query);

    if ($result) {
        $order_id = $conn->insert_id;
        
        $cart_items = getCartItems();
        foreach ($cart_items as $item) {
            $produk_id = $item['id'];
            $quantity = $item['quantity'];
            $harga = $item['harga'];

            $query = "INSERT INTO order_items (order_id, produk_id, quantity, harga) VALUES ($order_id, $produk_id, $quantity, $harga)";
            $conn->query($query);
        }

        return $order_id;
    } else {
        return false;
    }
}

function getOrderDetails($order_id) {
    global $conn;

    $query = "SELECT * FROM orders WHERE order_id = $order_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        $query = "SELECT oi.*, p.name FROM order_items oi INNER JOIN produk p ON oi.produk_id = p.id WHERE oi.order_id = $order_id";
        $result = $conn->query($query);

        $items = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = array(
                    'nama' => $row['nama'],
                    'harga' => $row['harga'],
                    'quantity' => $row['quantity'],
                    'total' => $row['quantity'] * $row['harga']
                );
            }
        }

        $order['items'] = $items;
        return $order;
    } else {
        return false;
    }
}

function saveOrderToDatabase($order)
{
    global $conn;
    $no_invoice = mysqli_real_escape_string($conn, $order['no_invoice']);
    $nama_siswa = mysqli_real_escape_string($conn, $order['nama']);
    $email = mysqli_real_escape_string($conn, $order['email']);
    $no_hp = mysqli_real_escape_string($conn, $order['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $order['alamat']);
    $payment_method = mysqli_real_escape_string($conn, $order['payment_method']);
    $total = mysqli_real_escape_string($conn, $order['total']);
    $status = 'BELUM BAYAR';

    $query = "INSERT INTO `orders` (no_invoice,nama_siswa, email, no_hp, alamat, payment_method, total, status) VALUES ('$no_invoice','$nama_siswa', '$email', '$no_hp', '$alamat', '$payment_method', '$total', '$status')";
    if (mysqli_query($conn, $query)) {
        $order_id = mysqli_insert_id($conn);
    } else {
        die("Error: " . $query . "<br>" . mysqli_error($conn));
    }

    return $order_id;
}

function saveItemsToDatabase($items, $order_id)
{
    global $conn;

    foreach ($items as $item) {
        $produk_id = $item['id'];
        $quantity = $item['quantity'];
        $harga = $item['harga'];

        $sql = "INSERT INTO order_items (order_id, produk_id, quantity, harga) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $order_id, $produk_id, $quantity, $harga);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
}

function generateInvoiceNumber() {
    $date = date("Ymd"); 
    $uniqueId = rand(1000, 9999); 
    $invoiceNumber = "INV-{$date}-{$uniqueId}";
    return $invoiceNumber;
}



function loginUser($username, $password)
{
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT id, password, role_id, username, email, nama, alamat, no_hp, kelas FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $hashed_password, $role_id, $username, $email, $nama, $alamat, $no_hp, $kelas);
        mysqli_stmt_fetch($stmt);

        if (md5($password) === $hashed_password) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            $_SESSION['user_id'] = $user_id;
            $_SESSION['role_id'] = $role_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['nama'] = $nama;
            $_SESSION['alamat'] = $alamat;
            $_SESSION['no_hp'] = $no_hp;
            $_SESSION['kelas'] = $kelas;

            return true;
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return false;
}

function registerUser($username, $password, $nama, $alamat, $no_hp, $email, $kelas)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return "Username already exists.";
    } else {
        $role_id = 2;
        $hashed_password = md5($password); 
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, nama, alamat, no_hp, email, kelas, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssssi", $username, $hashed_password, $nama, $alamat, $no_hp, $email, $kelas, $role_id);
        mysqli_stmt_execute($stmt);
        $user_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $user_id;
    }
}

function getUsers() {
    global $conn;
    $query = "SELECT * FROM users WHERE role_id='2'";
    $result = $conn->query($query);

    $users = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

function getSiswaById($user_id) {
    global $conn;
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function updateSiswa($user_id, $nama, $alamat, $no_hp, $username, $email, $kelas) {
    global $conn;
    $nama = mysqli_real_escape_string($conn, $nama);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $no_hp = mysqli_real_escape_string($conn, $no_hp);
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $kelas = mysqli_real_escape_string($conn, $kelas);

    $query = "UPDATE users SET nama = '$nama', alamat = '$alamat', no_hp = '$no_hp', username = '$username', email = '$email', kelas = '$kelas' WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result) {
        return "Data berhasil diubah.";
    } else {
        return "Data gagal diubah.";
    }
}

function insertSiswa($nama_siswa,$alamat, $no_hp, $username, $password, $email, $kelas) {
    global $conn;
    
    $nama_siswa = mysqli_real_escape_string($conn, $nama_siswa);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $no_hp = mysqli_real_escape_string($conn, $no_hp);
    $email = mysqli_real_escape_string($conn, $email);
    $kelas = mysqli_real_escape_string($conn, $kelas);
    $username = mysqli_real_escape_string($conn, $username);
    $password_hash = md5($password);
    
    $query = "INSERT INTO users (nama, alamat, no_hp, username, password, email, kelas, role_id) VALUES ('$nama_siswa', '$alamat', '$no_hp', '$username', '$password_hash', '$email', '$kelas',2)";
    $result = $conn->query($query);
    
    if ($result) {
        return "Data siswa berhasil ditambahkan.";
    } else {
        return "Gagal menambahkan data siswa.";
    }
}


function getProducts() {
    global $conn;
    $query = "SELECT * FROM produk";
    $result = $conn->query($query);

    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}

function getProductById($product_id) {
    global $conn;
    $query = "SELECT * FROM produk WHERE id = $product_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function updateProduct($product_id, $nama, $harga) {
    global $conn;
    $nama = mysqli_real_escape_string($conn, $nama);
    $harga = mysqli_real_escape_string($conn, $harga);

    $query = "UPDATE produk SET nama = '$nama', harga = '$harga' WHERE id = $product_id";
    $result = $conn->query($query);

    if ($result) {
        return "Data berhasil diubah.";
    } else {
        return "Data gagal diubah.";
    }
}

function insertProduct($nama, $harga) {
    global $conn;
    
    $nama = mysqli_real_escape_string($conn, $nama);
    $harga = mysqli_real_escape_string($conn, $harga);
    
    $query = "INSERT INTO produk (nama, harga) VALUES ('$nama', '$harga')";
    $result = $conn->query($query);
    
    if ($result) {
        return "Data berhasil ditambahkan.";
    } else {
        return "Data gagal ditambahkan.";
    }
}
  
function getOrders() {
    global $conn;
    
    $query = "SELECT * FROM orders";
    $result = $conn->query($query);
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

function getPendingOrders() {
    global $conn;
    
    $query = "SELECT * FROM orders  WHERE status='BELUM BAYAR'";
    $result = $conn->query($query);
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

function getSendOrders() {
    global $conn;
    
    $query = "SELECT * FROM orders WHERE status='PERLU DIKIRIM'";
    $result = $conn->query($query);
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

function getPenjualan() {
    global $conn;
    
    $query = "SELECT * FROM orders WHERE status='PESANAN SELESAI'";
    $result = $conn->query($query);
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

function getOrderDetail($order_id, $logout = '') {
    global $conn;

    $query = "SELECT * FROM orders WHERE order_id = $order_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        $query = "SELECT oi.*, p.nama FROM order_items oi INNER JOIN produk p ON oi.produk_id = p.id WHERE oi.order_id = $order_id";
        $result = $conn->query($query);

        $items = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = array(
                    'nama' => $row['nama'],
                    'quantity' => $row['quantity'],
                    'harga' => $row['harga']
                );
            }
        }

        $order['items'] = $items;
        return $order;
    } else {
        return false;
    }
}

function getOrderStatusLabelClass($status) {
    $class = '';

    switch ($status) {
        case 'BELUM BAYAR':
            $class = 'text-danger';
            break;
        case 'SUDAH BAYAR':
            $class = 'text-warning';
            break;
        case 'PESANAN SELESAI':
            $class = 'text-success';
            break;
        default:
            $class = '';
            break;
    }

    return $class;
}

function updateOrderStatus($orderId, $status) {
    global $conn;
  
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $status, $orderId);
  
    if ($stmt->execute()) {
      echo "Order status updated successfully.";
    } else {
      echo "Error updating order status: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
  }
  

?>
