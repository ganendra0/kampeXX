<?php
ini_set('display_errors', 1);//Atauerror_reporting(E_ALL && ~E_NOTICE);

session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kampeling";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data sampah untuk dropdown
$sql_sampah = "SELECT id, nama_barang, harga_nasabah FROM sampah";
$result_sampah = $conn->query($sql_sampah);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Sampah User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Input Sampah User</h1>
        <form action="proses_input_sampah.php" method="post">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="number" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="form-group">
                <label for="sampah_id">Jenis Sampah:</label>
                <select class="form-control" id="sampah_id" name="sampah_id" required>
                    <option value="">Pilih jenis sampah</option>
                    <?php
                    if ($result_sampah->num_rows > 0) {
                        while($row_sampah = $result_sampah->fetch_assoc()) {
                            echo "<option value='" . $row_sampah['id'] . "' data-harga='" . $row_sampah['harga_nasabah'] . "'>" . $row_sampah['nama_barang'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="berat_kg">Berat (Kg):</label>
                <input type="number" class="form-control" id="berat_kg" name="berat_kg" step="0.01" required>
            </div>
            <input type="hidden" id="harga_nasabah" name="harga_nasabah">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        document.getElementById('sampah_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var hargaNasabah = selectedOption.getAttribute('data-harga');
            document.getElementById('harga_nasabah').value = hargaNasabah;
        });
    </script>
</body>
</html>
