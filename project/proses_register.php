<?php
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
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
$role = $_POST['role'];

// Insert data ke tabel users
$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    if ($role == 'user') {
        // Buat saldo awal untuk user
        $user_id = $conn->insert_id;
        $sql_saldo = "INSERT INTO user_saldo (user_id, total_berat, total_saldo) VALUES ('$user_id', 0, 0)";
        $conn->query($sql_saldo);
    }
    echo "Registrasi berhasil. <a href='login.php'>Login</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
