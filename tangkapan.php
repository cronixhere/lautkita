<?php
include 'config.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nelayan = $_POST['id_nelayan'];
    $jenis_ikan = $_POST['jenis_ikan'];
    $berat_kg = $_POST['berat_kg'];
    $tanggal = $_POST['tanggal'];

    $stmt = $pdo->prepare("INSERT INTO hasil_tangkapan (id_nelayan, jenis_ikan, berat_kg, tanggal) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_nelayan, $jenis_ikan, $berat_kg, $tanggal]);

    header('Location: tangkapan.php');
}

$stmt = $pdo->query("SELECT * FROM nelayan");
$nelayanList = $stmt->fetchAll();

$stmt = $pdo->query("SELECT hasil_tangkapan.*, nelayan.nama AS nama_nelayan FROM hasil_tangkapan JOIN nelayan ON hasil_tangkapan.id_nelayan = nelayan.id");
$tangkapanList = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Hasil Tangkapan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">KOPERASI NELAYAN BATAM</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="nelayan.php">Data Nelayan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tangkapan.php">Hasil Tangkapan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="penjualan.php">Penjualan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="laporan.php">Laporan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="statistic.php">statistic</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Log-out</a>
              </li>

            </ul>
          </div>
        </div>
      </nav>


    <div class="container mt-4">
        <section>
        <h2>Tambah Data Hasil Tangkapan</h2>
                <form action="tangkapan.php" method="post">
                    <label for="id_nelayan">Nelayan:</label><br>
                    <select name="id_nelayan" id="id_nelayan" required>
                        <?php foreach ($nelayanList as $nelayan): ?>
                          <option value="<?= $nelayan['id'] ?>"><?= $nelayan['nama'] ?></option>

                        <?php endforeach; ?>
                    </select><br>

                    <label for="jenis_ikan">Jenis Ikan:</label><br>
                    <input type="text" name="jenis_ikan" id="jenis_ikan" required><br>

                    <label for="berat_kg">Berat (kg):</label><br>
                    <input type="number" step="0.01" name="berat_kg" id="berat_kg" required><br>

                    <label for="tanggal">Tanggal:</label><br>
                    <input type="date" name="tanggal" id="tanggal" required><br><br>

                    <button type="submit">Tambah</button>
                </form>
        </section>


            <section>
            <h2>Daftar Hasil Tangkapan</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Nelayan</th>
                        <th>Jenis Ikan</th>
                        <th>Berat (kg)</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
foreach ($tangkapanList as $tangkapan): ?>
    <tr>
        <td><?= $tangkapan['id'] ?></td>
        <td><?= $tangkapan['nama_nelayan'] ?></td>
        <td><?= $tangkapan['jenis_ikan'] ?></td>
        <td><?= $tangkapan['berat_kg'] ?></td>
        <td><?= $tangkapan['tanggal'] ?></td>
        <td>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="edit_tangkapan.php?id=<?= $tangkapan['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_tangkapan.php?id=<?= $tangkapan['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>

            </table>
        </section>
    </div>






    <?php include 'footer.php'; ?>
</body>
</html>
