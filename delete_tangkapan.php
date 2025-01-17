<?php
session_start();
include 'config.php';
include 'middleware.php';
checkAccess('admin');

// Periksa apakah ID diberikan dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: tangkapan.php');
    exit;
}

$id = $_GET['id'];

// Hapus data berdasarkan ID
try {
    $stmt = $pdo->prepare("DELETE FROM hasil_tangkapan WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: tangkapan.php');
    exit;
} catch (Exception $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>
