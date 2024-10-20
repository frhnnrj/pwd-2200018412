<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Proses formulir saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari formulir
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Validasi data 
  if (empty($username) || empty($password)) {
    $error = "Username dan password harus diisi!";
  } else {
    // Query untuk memeriksa data di database
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    // Cek jika data ditemukan
    if ($result->num_rows > 0) {
      // Ambil data dari database
      $row = $result->fetch_assoc();

      // Verifikasi password (tanpa hashing)
      if ($password === $row["password"]) {
        // Jika password benar, arahkan ke halaman data-admin.php
        header("Location: data-admin.php");
        exit;
      } else {
        $error = "Password salah!";
      }
    } else {
      $error = "Username tidak ditemukan!";
    }
  }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Admin</title>
</head>
<body>
<h2>Login Admin</h2>
<?php 
// Tampilkan pesan error jika ada
if (isset($error)) {
  echo "<p style='color: red;'>$error</p>";
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>
<p>Belum punya akun? <a href="signup.php">Daftar di sini</a></p>
<p><a href="registrasi.php" class="button">Ke halaman registrasi</a></p>
</body>
</html>