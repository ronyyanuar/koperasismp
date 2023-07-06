<?php
session_start();

require_once 'config.php';
require_once 'functions.php';

if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 2) {
    header("Location: index.php");
    exit();
} else if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 1) {
    header("Location: admin/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $kelas = $_POST['kelas'];

    if (registerUser($username, $password, $nama, $alamat, $no_hp, $email, $kelas)) {
        echo '<div class="alert alert-success">Pendaftaran berhasil, kamu akan dialihkan ke halaman login dalam <span id="countdown">10</span> detik.</div>';
        echo '<script>
                var countdownElement = document.getElementById("countdown");
                var countdown = 10;

                function updateCountdown() {
                    countdown--;
                    countdownElement.textContent = countdown;

                    if (countdown === 0) {
                        window.location.href = "login.php";
                    } else {
                        setTimeout(updateCountdown, 1000);
                    }
                }

                setTimeout(updateCountdown, 700);
              </script>';
        exit();
    } else {
        $error_message = "Registrasi gagal. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Siswa</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 10px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #fff;
            border-bottom: none;
            text-align: center;
            padding: 10px;
        }
        .card-body {
            padding: 30px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Pendaftaran Siswa</h2>
                <p>Mohon lengkapi semua isian di bawah ini</p>
            </div>
            <div class="card-body">
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form method="post" action="register.php" id="registerForm">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No. HP:</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        <span id="no_hpError" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas:</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <span id="usernameError" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <span id="passwordError" class="error-message"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-paper-plane"></i> DAFTAR SEKARANG</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var no_hp = document.getElementById("no_hp").value;
            var usernameError = document.getElementById("usernameError");
            var passwordError = document.getElementById("passwordError");
            var no_hpError = document.getElementById("no_hpError");
            var isValid = true;

            usernameError.textContent = "";
            passwordError.textContent = "";
            no_hpError.textContent = "";

            if (username.length < 6) {
                usernameError.textContent = "Username minimum harus 6 karakter.";
                isValid = false;
            }

            if (password.length < 6) {
                passwordError.textContent = "Password minimum harus 6 karakter.";
                isValid = false;
            }

            if (!/^\d+$/.test(no_hp)) {
                no_hpError.textContent = "Masukkan hanya angka.";
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); 
            }
        });
    </script>
</body>
</html>
