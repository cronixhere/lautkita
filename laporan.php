<?php
// Include file config.php untuk koneksi ke database
include 'config.php';

// Fetch data untuk laporan
$stmt = $pdo->query("
    SELECT ht.id, ht.jenis_ikan, ht.berat_kg, n.nama AS nama
    FROM hasil_tangkapan ht
    JOIN nelayan n ON ht.id_nelayan = n.id
");
$hasil_tangkapan = $stmt->fetchAll();


$stmt = $pdo->query("
    SELECT p.id, p.jenis_ikan, p.jumlah_kg, p.harga_per_kg, p.total_harga, p.tanggal_penjualan, ht.jenis_ikan AS jenis_ikan
    FROM penjualan p
    JOIN hasil_tangkapan ht ON p.id_tangkapan = ht.id
");
$penjualan = $stmt->fetchAll();


// Total tangkapan dan pendapatan
$stmt = $pdo->query("SELECT SUM(berat_kg) AS total_berat FROM hasil_tangkapan");
$tangkapan = $stmt->fetch();

$stmt = $pdo->query("SELECT SUM(total_harga) AS total_pendapatan FROM penjualan");
$pendapatan = $stmt->fetch();

// Fungsi untuk membuat HTML laporan (digunakan di web dan PDF)
function generateLaporanHTML($hasil_tangkapan, $penjualan, $tangkapan, $pendapatan)
{
    ob_start(); // Buffer output untuk menghasilkan HTML
    ?>
    <div class="container">
        <section>
            <h1>Laporan Koperasi</h1>
            <p>Total Tangkapan: <?= $tangkapan['total_berat'] ?> kg</p>
            <p>Total Pendapatan: Rp <?= number_format($pendapatan['total_pendapatan'], 2) ?></p>

            <h2>Data Hasil Tangkapan</h2>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Ikan</th>
                        <th>Berat (kg)</th>
                        <th>Nama Nelayan</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($hasil_tangkapan as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['jenis_ikan'] ?></td>
                        <td><?= $row['berat_kg'] ?></td>
                        <td><?= $row['nama'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </section>

        <section>
            <h2>Data Penjualan</h2>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Ikan</th>
                        <th>Jumlah (kg)</th>
                        <th>Harga per kg (Rp)</th>
                        <th>Total Harga (Rp)</th>
                        <th>Tanggal Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($penjualan as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['jenis_ikan'] ?></td>
                        <td><?= $row['jumlah_kg'] ?></td>
                        <td><?= number_format($row['harga_per_kg'], 2) ?></td>
                        <td><?= number_format($row['total_harga'], 2) ?></td>
                        <td><?= $row['tanggal_penjualan'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </section>
        <div class="text-center my-4">
    <a href="?action=cetak_pdf" class="btn btn-primary">Cetak PDF</a>
</div>
    </div>
    <?php
    return ob_get_clean(); // Kembalikan hasil HTML
}

// Cek jika tombol cetak PDF diklik
if (isset($_GET['action']) && $_GET['action'] === 'cetak_pdf') {
    require 'vendor/autoload.php'; // Pastikan dompdf terpasang via composer

    // Generate HTML untuk laporan
    $html = generateLaporanHTML($hasil_tangkapan, $penjualan, $tangkapan, $pendapatan);

    // Buat PDF dengan Dompdf
    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("laporan_koperasi.pdf", ["Attachment" => false]);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

<!-- Konten utama laporan -->
<?= generateLaporanHTML($hasil_tangkapan, $penjualan, $tangkapan, $pendapatan) ?>

<!-- Tombol cetak PDF -->


<?php include 'footer.php'; ?>
</body>
</html>
