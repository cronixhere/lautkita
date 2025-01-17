<?php
require 'config.php';

$username = 'admin'; // Contoh username
$password = 'password123'; // Contoh password

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Masukkan ke database
$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();

echo "Admin berhasil ditambahkan.";
$stmt->close();
?>
