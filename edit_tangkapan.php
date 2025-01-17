<?php
include 'config.php';
session_start();

// Periksa apakah ID sudah diberikan
if (!isset($_GET['id'])) {
    header('Location: tangkapan.php');
    exit;
}

$id = $_GET['id'];

// Proses form jika ada permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nelayan = $_POST['id_nelayan'];
    $jenis_ikan = $_POST['jenis_ikan'];
    $berat_kg = $_POST['berat_kg'];
    $tanggal = $_POST['tanggal'];

    $stmt = $pdo->prepare("UPDATE hasil_tangkapan SET id_nelayan = ?, jenis_ikan = ?, berat_kg = ?, tanggal = ? WHERE id = ?");
    $stmt->execute([$id_nelayan, $jenis_ikan, $berat_kg, $tanggal, $id]);

    header('Location: tangkapan.php');
    exit;
}

// Ambil data hasil tangkapan berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM hasil_tangkapan WHERE id = ?");
$stmt->execute([$id]);
$tangkapan = $stmt->fetch();

if (!$tangkapan) {
    echo "Data tidak ditemukan.";
    exit;
}

// Ambil daftar nelayan untuk dropdown
$stmt = $pdo->query("SELECT * FROM nelayan");
$nelayanList = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hasil Tangkapan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Gunakan styles.css untuk seluruh halaman -->
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Hasil Tangkapan</h2>
        <form action="edit_tangkapan.php?id=<?= $id ?>" method="post">
            <label for="id_nelayan">Nelayan:</label><br>
            <select name="id_nelayan" id="id_nelayan" required>
                <?php foreach ($nelayanList as $nelayan): ?>
                    <option value="<?= $nelayan['id'] ?>" <?= $nelayan['id'] == $tangkapan['id_nelayan'] ? 'selected' : '' ?>>
                        <?= $nelayan['nama'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="jenis_ikan">Jenis Ikan:</label><br>
            <input type="text" name="jenis_ikan" id="jenis_ikan" value="<?= $tangkapan['jenis_ikan'] ?>" required><br>

            <label for="berat_kg">Berat (kg):</label><br>
            <input type="number" step="0.01" name="berat_kg" id="berat_kg" value="<?= $tangkapan['berat_kg'] ?>" required><br>

            <label for="tanggal">Tanggal:</label><br>
            <input type="date" name="tanggal" id="tanggal" value="<?= $tangkapan['tanggal'] ?>" required><br><br>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="tangkapan.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
