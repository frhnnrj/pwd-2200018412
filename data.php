<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pwd";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil semua data registrasi
$sql = "SELECT * FROM registrasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .notification {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Data Registrasi Seminar</h2>

<?php
// Menampilkan pesan notifikasi jika ada
if (isset($_GET['message'])) {
    echo "<p class='notification'>" . htmlspecialchars($_GET['message']) . "</p>";
}
?>

<table>
    <tr>
        <th>Email</th>
        <th>Nama</th>
        <th>Institusi</th>
        <th>Negara</th>
        <th>Alamat</th>
    </tr>

    <?php
    // Cek apakah ada data
    if ($result->num_rows > 0) {
        // Output data dari setiap baris
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['institution']) . "</td>
                    <td>" . htmlspecialchars($row['country']) . "</td>
                    <td>" . htmlspecialchars($row['address']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Tidak ada data registrasi</td></tr>";
    }
    ?>
</table>

<p><a href="registrasi.php" class="button">Kembali ke halaman registrasi</a></p>
<p><a href="login.php" class="button">Ke Halaman Admin untuk mengakses database</a></p>

</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>