<?php
session_start();
include 'middleware.php';
checkAccess('admin');
include 'config.php'; // Include the database configuration file

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Delete query menggunakan prepared statement untuk keamanan
        $stmt = $pdo->prepare("DELETE FROM nelayan WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            // Berhasil dihapus, redirect kembali
            header('Location: nelayan.php?status=success');
        } else {
            // Jika tidak ada data yang dihapus (ID tidak ditemukan)
            header('Location: nelayan.php?status=not_found');
        }
    } catch (PDOException $e) {
        // Tampilkan pesan error jika ada kesalahan
        die("Terjadi kesalahan: " . $e->getMessage());
    }
} else {
    // Jika ID tidak ditemukan di URL
    header('Location: nelayan.php?status=invalid_id');
}
?>
