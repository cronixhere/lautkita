<?php 
session_start();
include 'config.php'; 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nelayan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Gunakan styles.css untuk seluruh halaman -->
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

<!-- Content -->
    <div class="container mt-4">
        <section>
        <div class="card p-3 mb-4">
        <h1 class="text-center">Data Nelayan</h1>
            <form action="add_nelayan.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="kontak" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
        </section>

        

        <section>
        <h2 class="text-center">Daftar Nelayan</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Kontak</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM nelayan");

            while ($row = $stmt->fetch()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['alamat']}</td>
                        <td>{$row['kontak']}</td>
                        <td>";

        // Hanya tampilkan tombol Edit dan Hapus jika role adalah admin
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            echo "
                <a href='update_nelayan.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                <a href='delete_nelayan.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a>";
        }

        echo "</td>
            </tr>";
        }
        ?>
            </tbody>
        </table>
        </section>

    </div>
<?php include 'footer.php'; ?>
</body>
</html>
