<?php
session_start();
include 'config.php'; // Pastikan koneksi ke database sudah ada
include 'middleware.php';
checkAccess('admin');

// Ambil ID nelayan dari URL
$id = $_GET['id'];

// Query untuk mendapatkan data nelayan berdasarkan ID
$query = "SELECT * FROM nelayan WHERE id_nelayan = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Data tidak ditemukan!'); window.location='nelayan.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $updateQuery = "UPDATE nelayan SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id_nelayan='$id'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='nelayan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }
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
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $data['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" class="form-control" value="<?php echo $data['alamat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="no_hp">No. HP:</label>
                <input type="text" id="no_hp" name="no_hp" class="form-control" value="<?php echo $data['no_hp']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
            <a href="nelayan.php" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
