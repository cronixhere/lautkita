<?php
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];

    $stmt = $pdo->prepare("INSERT INTO nelayan (nama, alamat, kontak) VALUES (?, ?, ?)");
    $stmt->execute([$nama, $alamat, $kontak]);

    header('Location: nelayan.php');
}
?>
