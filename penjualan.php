<?php
include 'config.php'; // Include the database configuration file

// Handle the form submission for adding a new penjualan record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tangkapan = $_POST['id_tangkapan']; // ID of the selected tangkapan
    $jumlah_kg = $_POST['jumlah_kg']; // Weight of the sale in kilograms
    $harga_per_kg = $_POST['harga_per_kg']; // Price per kilogram
    $tanggal_penjualan = $_POST['tanggal_penjualan']; // Date of the sale

    // Calculate the total price
    $total_harga = $jumlah_kg * $harga_per_kg;

// Insert the new penjualan record into the database
$stmt = $pdo->prepare("INSERT INTO penjualan (id_tangkapan, jumlah_kg, harga_per_kg, total_harga, tanggal_penjualan) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$id_tangkapan, $jumlah_kg, $harga_per_kg, $total_harga, $tanggal_penjualan]);


    // Redirect to the same page after successful submission
    header('Location: penjualan.php');
}

// Fetch the list of tangkapan to populate the dropdown
$stmt = $pdo->query("SELECT hasil_tangkapan.id, hasil_tangkapan.jenis_ikan, hasil_tangkapan.berat_kg, nelayan.nama AS nama_nelayan FROM hasil_tangkapan JOIN nelayan ON hasil_tangkapan.id_nelayan = nelayan.id");
$tangkapanList = $stmt->fetchAll();

// Fetch the list of penjualan records for displaying in the table
$stmt = $pdo->query("SELECT 
                        penjualan.id, 
                        penjualan.jumlah_kg, 
                        penjualan.harga_per_kg, 
                        penjualan.total_harga, 
                        penjualan.tanggal_penjualan,
                        hasil_tangkapan.jenis_ikan, 
                        nelayan.nama AS nama_nelayan 
                     FROM penjualan 
                     JOIN hasil_tangkapan ON penjualan.id_tangkapan = hasil_tangkapan.id 
                     JOIN nelayan ON hasil_tangkapan.id_nelayan = nelayan.id");

$penjualanList = $stmt->fetchAll(PDO::FETCH_ASSOC); // Use PDO::FETCH_ASSOC for associative array

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Penjualan</title>
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
            <h2>Tambah Data Penjualan</h2>
            <!-- Form for adding a new penjualan record -->
            <form action="penjualan.php" method="post">
                <label for="id_tangkapan">Tangkapan:</label><br>
                <select name="id_tangkapan" id="id_tangkapan" required>
                    <!-- Populate dropdown with tangkapan records -->
                    <?php foreach ($tangkapanList as $tangkapan): ?>
                        <option value="<?= $tangkapan['id'] ?>">
                            <?= $tangkapan['nama_nelayan'] ?> - <?= $tangkapan['jenis_ikan'] ?> (<?= $tangkapan['berat_kg'] ?> kg)
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label for="jumlah_kg">Jumlah (kg):</label><br>
                <input type="number" step="0.01" name="jumlah_kg" id="jumlah_kg" required><br>

                <label for="harga_per_kg">Harga per kg (Rp):</label><br>
                <input type="number" step="0.01" name="harga_per_kg" id="harga_per_kg" required><br>

                <label for="tanggal_penjualan">Tanggal Penjualan:</label><br>
                <input type="date" name="tanggal_penjualan" id="tanggal_penjualan" required><br><br>

                <button type="submit">Tambah</button>
            </form>
        </section>

        <section>
            <h2>Daftar Penjualan</h2>
            <!-- Table for displaying penjualan records -->
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Nelayan</th>
                        <th>Jenis Ikan</th>
                        <th>Jumlah (kg)</th>
                        <th>Harga per kg (Rp)</th>
                        <th>Total Harga (Rp)</th>
                        <th>Tanggal Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populate table with penjualan records -->
                    <?php foreach ($penjualanList as $penjualan): ?>
                        <tr>
                            <td><?= $penjualan['id'] ?></td>
                            <td><?= $penjualan['nama_nelayan'] ?></td>
                            <td><?= $penjualan['jenis_ikan'] ?></td>
                            <td><?= $penjualan['jumlah_kg'] ?></td>
                            <td><?= $penjualan['harga_per_kg'] ?></td>
                            <td><?= $penjualan['total_harga'] ?></td>
                            <td><?= $penjualan['tanggal_penjualan'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>

