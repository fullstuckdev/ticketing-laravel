<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $level = $_POST['level'];
    $password = hash('sha256', $_POST['password']);

    $sql = "INSERT INTO users (username, email, level, password) VALUES ('$username', '$email', '$level', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>window.location.href='index.php';</script>"; // refresh halaman utama
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- FORM MULAI DI SINI -->
<h2 class="text-xl font-bold mb-4 text-center">Tambah Member Baru</h2>
<form method="POST" action="">
  <div class="mb-4">
    <label class="block mb-1">Username</label>
    <input type="text" name="username" required class="w-full border px-3 py-2 rounded">
  </div>
  <div class="mb-4">
    <label class="block mb-1">Email</label>
    <input type="email" name="email" required class="w-full border px-3 py-2 rounded">
  </div>
  <div class="mb-4">
    <label class="block mb-1">Level</label>
    <select name="level" required class="w-full border px-3 py-2 rounded">
      <option value="admin">Admin</option>
      <option value="user">User</option>
      <option value="noc_engineer">NOC_ENGINEER</option>
    </select>
  </div>
  <div class="mb-4">
    <label class="block mb-1">Password</label>
    <input type="password" name="password" required class="w-full border px-3 py-2 rounded">
  </div>
  <div class="text-right">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
  </div>
</form>
