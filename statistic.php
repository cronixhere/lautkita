<?php
session_start();
include 'config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Query untuk diagram garis (total pendapatan per bulan)
$stmtLine = $pdo->query("
    SELECT 
        DATE_FORMAT(tanggal_penjualan, '%Y-%m') AS bulan, 
        SUM(total_harga) AS total_pendapatan 
    FROM penjualan 
    GROUP BY bulan
    ORDER BY bulan ASC
");
$lineData = $stmtLine->fetchAll(PDO::FETCH_ASSOC);

// Query untuk diagram lingkaran (jenis ikan dan total berat)
$stmtPie = $pdo->query("
    SELECT jenis_ikan, AVG(berat_kg) AS rata_rata_berat 
    FROM hasil_tangkapan 
    GROUP BY jenis_ikan
");
$pieData = $stmtPie->fetchAll(PDO::FETCH_ASSOC);

// Query untuk diagram batang (data penjualan per jenis ikan)
$stmtBar = $pdo->query("
    SELECT jenis_ikan, SUM(jumlah_kg) AS total_kg, SUM(total_harga) AS total_penjualan
    FROM penjualan
    GROUP BY jenis_ikan
");
$barData = $stmtBar->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

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
      
<div class="container mt-5">
        <h1 class="text-center">Statistik Koperasi Nelayan</h1>
        
        <!-- Diagram Garis: Total Pendapatan -->
        <h3>Total Pendapatan per Bulan</h3>
        <canvas id="lineChart" width="400" height="200"></canvas>
        
        <!-- Diagram Lingkaran: Rata-rata Berat Ikan -->
        <h3>Rata-rata Berat Ikan Berdasarkan Jenis</h3>
        <canvas id="pieChart" width="400" height="200"></canvas>
        
        <!-- Diagram Batang 1: Total Penjualan (Kg) -->
        <h3>Total Penjualan (Kg) per Jenis Ikan</h3>
        <canvas id="barChartKg" width="400" height="200"></canvas>

        <!-- Diagram Batang 2: Total Pendapatan (Rp) per Jenis Ikan -->
        <h3>Total Pendapatan (Rp) per Jenis Ikan</h3>
        <canvas id="barChartRevenue" width="400" height="200"></canvas>
    </div>
        
    <script>
// Diagram Garis: Total Pendapatan
const lineLabels = <?php echo json_encode(array_column($lineData, 'bulan')); ?>;
const lineData = <?php echo json_encode(array_column($lineData, 'total_pendapatan')); ?>;

const lineCtx = document.getElementById('lineChart').getContext('2d');
new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: lineLabels,
        datasets: [{
            label: 'Total Pendapatan',
            data: lineData,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});

// Diagram Lingkaran: Rata-rata Berat Ikan
const pieLabels = <?php echo json_encode(array_column($pieData, 'jenis_ikan')); ?>;
const pieData = <?php echo json_encode(array_column($pieData, 'rata_rata_berat')); ?>;

const pieCtx = document.getElementById('pieChart').getContext('2d');
new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: pieLabels,
        datasets: [{
            data: pieData,
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Diagram Batang 1: Total Penjualan (Kg)
const barLabelsKg = <?php echo json_encode(array_column($barData, 'jenis_ikan')); ?>;
const barDataKg = <?php echo json_encode(array_column($barData, 'total_kg')); ?>;

const barCtxKg = document.getElementById('barChartKg').getContext('2d');
new Chart(barCtxKg, {
    type: 'bar',
    data: {
        labels: barLabelsKg,
        datasets: [{
            label: 'Total Penjualan (Kg)',
            data: barDataKg,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Diagram Batang 2: Total Pendapatan (Rp)
const barLabelsRevenue = <?php echo json_encode(array_column($barData, 'jenis_ikan')); ?>;
const barDataRevenue = <?php echo json_encode(array_column($barData, 'total_penjualan')); ?>;

const barCtxRevenue = document.getElementById('barChartRevenue').getContext('2d');
new Chart(barCtxRevenue, {
    type: 'bar',
    data: {
        labels: barLabelsRevenue,
        datasets: [{
            label: 'Total Pendapatan (Rp)',
            data: barDataRevenue,
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php include 'footer.php'; ?>
</body>
</html>
