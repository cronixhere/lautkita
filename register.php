<?php
session_start();
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $new_username = $_POST['new_username'] ?? null;
    $new_password = $_POST['new_password'] ?? null;
    $role = $_POST['role'] ?? 'user'; // Default role adalah 'user'

    if ($new_username && $new_password) {
        // Cek apakah username sudah digunakan
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$new_username]);
        $user = $stmt->fetch();

        if ($user) {
            $error = "Nama pengguna sudah terdaftar.";
        } else {
            // Cek apakah yang membuat akun admin adalah seorang admin
            if ($role === 'admin' && (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin')) {
                $error = "Hanya Admin yang dapat membuat akun Admin.";
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
    } else {
        $error = "Nama pengguna dan kata sandi wajib diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrasi Akun</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="new_username">Nama Pengguna:</label>
            <input type="text" name="new_username" id="new_username" required>

            <label for="new_password">Kata Sandi:</label>
            <input type="password" name="new_password" id="new_password" required>

            <!-- Dropdown untuk memilih role -->
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="register">Register</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
    </div>
</body>
</html>
