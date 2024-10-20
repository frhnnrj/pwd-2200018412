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
  } else if (strlen($password) < 8) {
    $error = "Password minimal harus 8 karakter!";
  } else {
    // Simpan password tanpa hashing
    // Query untuk memasukkan data ke database 
    $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
      $success = "Registrasi berhasil! Silakan login.";
    } else {
      $error = "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Signup Admin</title>
</head>
<body>

<h2>Signup Admin</h2>

<?php 
// Tampilkan pesan error jika ada
if (isset($error)) {
  echo "<p style='color: red;'>$error</p>";
}

// Tampilkan pesan sukses jika ada
if (isset($success)) {
  echo "<p style='color: green;'>$success</p>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
  <label for="username">Username:</label><br>
  <input type="text" id="username" name="username" required><br><br>

  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" required><br><br>

  <input type="submit" value="Signup">
</form>

<p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
<p><a href="registrasi.php" class="button">Ke halaman registrasi</a></p>

</body>
</html>