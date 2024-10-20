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

$error_message = ""; // Untuk menyimpan pesan kesalahan

// Proses formulir saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $email = $_POST["email"];
    $name = $_POST["name"];
    $institution = $_POST["institution"];
    $country = $_POST["country"];
    $address = $_POST["address"];

    // Cek apakah email sudah ada
    $check_email_sql = "SELECT * FROM registrasi WHERE email = ?";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika email sudah terdaftar
        $error_message = "Email ini sudah terdaftar.";
    } else {
        // Query untuk memasukkan data ke database
        $sql = "INSERT INTO registrasi (email, name, institution, country, address)
                VALUES (?, ?, ?, ?, ?)";
        
        // Eksekusi query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $email, $name, $institution, $country, $address);
        
        if ($stmt->execute()) {
            // Tampilkan notifikasi registrasi berhasil
            echo "<script>alert('Registrasi berhasil!'); window.location.href='data.php';</script>";
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Seminar</title>
</head>
<body>

<h2>Formulir Registrasi Seminar</h2>

<?php
// Tampilkan pesan kesalahan jika ada
if (!empty($error_message)) {
    echo "<p style='color:red;'>$error_message</p>";
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="name">Nama:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="institution">Institusi:</label><br>
    <input type="text" id="institution" name="institution" required><br><br>

    <label for="country">Negara:</label><br>
    <input type="text" id="country" name="country" required><br><br>

    <label for="address">Alamat:</label><br>
    <textarea id="address" name="address" required></textarea><br><br>

    <input type="submit" value="Submit">

    <p><a href="data.php" class="button">Lihat data registrasi</a></p>
</form>

</body>
</html>