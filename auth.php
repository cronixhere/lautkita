<?php
require 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['nama_user'];
        $password = $_POST['password']; // Jangan enkripsi dengan md5

        // Ambil data pengguna dari database
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi password
        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['user'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $result['role']; // Tambahkan role ke session
            header('Location: index.php');
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    }
    }


    if (isset($_POST['register'])) {
        $new_username = $_POST['new_username'];
        $new_password = $_POST['new_password'];
        $role = $_POST['role'];
    
        // Validasi apakah role admin hanya bisa dibuat oleh admin
        if ($role === 'admin' && (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin')) {
            $error = "Hanya Admin yang dapat membuat akun Admin.";
        } else {
            // Cek apakah username sudah digunakan
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$new_username]);
            $user = $stmt->fetch();
    
            if ($user) {
                $error = "Nama pengguna sudah terdaftar.";
            } else {
                // Hash password dan simpan ke database
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO admin (username, password, role) VALUES (?, ?, ?)");
                $stmt->execute([$new_username, $hashed_password, $role]);
    
                // Login otomatis setelah registrasi berhasil
                $_SESSION['user'] = true;
                $_SESSION['username'] = $new_username;
                $_SESSION['role'] = $role;
    
                // Redirect ke index.php
                header('Location: index.php');
                exit;
            }
        }
    }
    

    

?>
