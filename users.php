<?php
session_start();
include 'middleware.php';

// Hanya admin yang dapat mengakses halaman ini
checkAccess('admin'); 

include 'config.php';

// Ambil semua data pengguna
$stmt = $pdo->query("SELECT id, username, role FROM admin");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">KOPERASI NELAYAN BATAM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="nelayan.php">Data Nelayan</a></li>
                    <li class="nav-item"><a class="nav-link" href="tangkapan.php">Hasil Tangkapan</a></li>
                    <li class="nav-item"><a class="nav-link" href="penjualan.php">Penjualan</a></li>
                    <li class="nav-item"><a class="nav-link" href="laporan.php">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="statistic.php">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log-out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h1 class="text-center mb-4">Manajemen Pengguna</h1>
        
        <!-- Tabel Pengguna -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Pengguna</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Koperasi Nelayan Batam. All rights reserved.</p>
    </footer>
</body>
</html>
