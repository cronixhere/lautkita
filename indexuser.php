<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <title>Sistem Koperasi Nelayan</title>
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
                <a class="nav-link" href="logout.php">Log-out</a>
              </li>

            </ul>
          </div>
        </div>
      </nav>
      
    <main>
        <section>
            <h2>
                <?echo "Selamat datang, " . htmlspecialchars($_SESSION['username']) . " (" . $_SESSION['role'] . ")"?>
            </h2>
            <p>Sistem ini membantu pengelolaan data tangkapan nelayan, penjualan, dan laporan koperasi.</p>
        </section>
    </main>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = {
        'index.php': 'nav-home',
        'nelayan.php': 'nav-nelayan',
        'tangkapan.php': 'nav-tangkapan',
        'penjualan.php': 'nav-penjualan',
        'laporan.php': 'nav-laporan'
        
    };
    

    if (navLinks[currentPage]) {
        document.getElementById(navLinks[currentPage]).classList.add('active');
    }

    // Example of dynamic content update
    const welcomeMessage = document.querySelector('h2');
    const currentHour = new Date().getHours();
    if (currentHour < 12) {
        welcomeMessage.textContent = "Selamat Pagi di Sistem Koperasi";
    } else if (currentHour < 18) {
        welcomeMessage.textContent = "Selamat Siang di Sistem Koperasi";
    } else {
        welcomeMessage.textContent = "Selamat Malam di Sistem Koperasi";
    }
});
    </script>

<?php include 'footer.php'; ?>
</body>
</html>
