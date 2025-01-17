<?php
session_start();
include 'config.php'; // Include the database configuration file
include 'middleware.php';
checkAccess('admin');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing data for the nelayan
    $stmt = $pdo->prepare("SELECT * FROM nelayan WHERE id = ?");
    $stmt->execute([$id]);
    $nelayan = $stmt->fetch();

    if (!$nelayan) {
        echo "Data nelayan tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];

    // Update the nelayan data
    $stmt = $pdo->prepare("UPDATE nelayan SET nama = ?, alamat = ?, kontak = ? WHERE id = ?");
    $stmt->execute([$nama, $alamat, $kontak, $id]);

    // Redirect back to nelayan.php
    header('Location: nelayan.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Nelayan</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <h2>Edit Data Nelayan</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nama">Nama Nelayan:</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nelayan['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" class="form-control" value="<?php echo $nelayan['alamat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="no_hp">No. HP:</label>
                <input type="text" id="kontak" name="kontak" class="form-control" value="<?php echo $nelayan['kontak']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
            <a href="nelayan.php" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
