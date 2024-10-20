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

// Ambil email dari parameter URL
$email = $_GET['email'];

// Query untuk mengambil data berdasarkan email
$sql = "SELECT * FROM registrasi WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Proses pembaruan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $institution = $_POST['institution'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Query untuk memperbarui data berdasarkan email
    $update_sql = "UPDATE registrasi SET name = ?, institution = ?, country = ?, address = ? WHERE email = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssss", $name, $institution, $country, $address, $email);
    $stmt->execute();
    $stmt->close();

    // Redirect ke halaman utama
    header("Location: data-admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Data Registrasi</title>
    <style>
        form {
            width: 50%;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Update Data Registrasi</h2>

<form method="POST" action="">
    <label for="name">Nama:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">

    <label for="institution">Institusi:</label>
    <input type="text" id="institution" name="institution" value="<?php echo htmlspecialchars($row['institution']); ?>">

    <label for="country">Negara:</label>
    <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($row['country']); ?>">

    <label for="address">Alamat:</label>
    <textarea id="address" name="address"><?php echo htmlspecialchars($row['address']); ?></textarea>

    <input type="submit" value="Update">
</form>

<p><a href="data-admin.php">Kembali ke halaman utama</a></p>

</body>
</html>