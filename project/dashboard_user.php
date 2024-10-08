<?php
session_start();
if ($_SESSION['role'] != 'user') {
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

$user_id = $_SESSION['user_id'];
$sql_saldo = "SELECT total_berat, total_saldo FROM user_saldo WHERE user_id = $user_id";
$result_saldo = $conn->query($sql_saldo);
$row_saldo = $result_saldo->fetch_assoc();

$sql_detail = "SELECT nama_barang, berat_kg, total, tanggal_setor FROM user_sampah WHERE user_id = $user_id";
$result_detail = $conn->query($sql_detail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">User Dashboard</h1>
        <h2>Saldo Sampah Anda</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Total Berat (Kg)</th>
                    <th>Total Saldo (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $row_saldo['total_berat']; ?></td>
                    <td><?php echo $row_saldo['total_saldo']; ?></td>
                </tr>
            </tbody>
        </table>
        <h2 class="mt-4">Detail Setoran Sampah</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Berat (Kg)</th>
                    <th>Total (Rp)</th>
                    <th>Tanggal Setor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_detail->num_rows > 0) {
                    while($row_detail = $result_detail->fetch_assoc()) {
                        echo "<tr><td>" . $row_detail["nama_barang"]. "</td><td>" . $row_detail["berat_kg"]. "</td><td>" . $row_detail["total"]. "</td><td>" . $row_detail["tanggal_setor"]. "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
