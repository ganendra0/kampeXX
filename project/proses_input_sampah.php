<?php
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

// Ambil data dari form
$user_id = $_POST['user_id'];
$sampah_id = $_POST['sampah_id'];
$berat_kg = $_POST['berat_kg'];
$harga_nasabah = $_POST['harga_nasabah'];
$total = $berat_kg * $harga_nasabah;
$tanggal_setor = date('Y-m-d');

// Ambil nama barang berdasarkan sampah_id
$sql_sampah = "SELECT nama_barang FROM sampah WHERE id = $sampah_id";
$result_sampah = $conn->query($sql_sampah);
$row_sampah = $result_sampah->fetch_assoc();
$nama_barang = $row_sampah['nama_barang'];

// Insert data ke tabel user_sampah
$sql = "INSERT INTO user_sampah (user_id, nama_barang, harga_nasabah, berat_kg, total, tanggal_setor) VALUES ('$user_id', '$nama_barang', '$harga_nasabah', '$berat_kg', '$total', '$tanggal_setor')";

if ($conn->query($sql) === TRUE) {
    // Update saldo user
    $update_saldo = "UPDATE user_saldo SET total_berat = total_berat + $berat_kg, total_saldo = total_saldo + $total WHERE user_id = $user_id";
    $conn->query($update_saldo);

    echo "Data berhasil disimpan. <a href='dashboard_admin.php'>Kembali ke Dashboard</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
