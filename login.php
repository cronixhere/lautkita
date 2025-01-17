<?php
session_start();
include 'config.php';
include 'auth.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Koperasi Nelayan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Login ke Koperasi Nelayan</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Nama Pengguna:</label>
            <input type="text" name="nama_user" id="username" required>
            <label for="password">Kata Sandi:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <p>Belum punya akun? <a href="register.php">Register sekarang</a></p>
    </div>
</body>
</html>