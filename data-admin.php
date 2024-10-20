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

// Proses penghapusan data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_email'])) {
    $email_to_delete = $_POST['delete_email'];
    
    // Query untuk menghapus data berdasarkan email
    $delete_sql = "DELETE FROM registrasi WHERE email = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $email_to_delete);
    $stmt->execute();
    $stmt->close();
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
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .update-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Data Registrasi Seminar</h2>

<table>
    <tr>
        <th>Email</th>
        <th>Nama</th>
        <th>Institusi</th>
        <th>Negara</th>
        <th>Alamat</th>
        <th>Aksi</th>
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
                    <td>
                        <form method='POST' action=''>
                            <input type='hidden' name='delete_email' value='" . htmlspecialchars($row['email']) . "'>
                            <button type='submit' class='delete-button'>Hapus</button>
                        </form>
                        <a href='update.php?email=" . urlencode($row['email']) . "' class='update-button'>Update</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data registrasi</td></tr>";
    }
    ?>
</table>

<p><a href="login.php">Logout</a></p>

</body>
</html>