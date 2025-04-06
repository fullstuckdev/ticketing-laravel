<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['idUsers']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $level = $_POST['level'];

    $update_sql = "UPDATE users SET username='$username', email='$email', level='$level' WHERE idUsers='$id'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: index.php?section=daftar-member");
        exit();
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
        exit();
    }
}

// Ambil data untuk form jika ada idUsers dari GET
$data = [
    'idUsers' => '',
    'username' => '',
    'email' => '',
    'level' => ''
];

if (isset($_GET['idUsers'])) {
    $id = intval($_GET['idUsers']);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE idUsers = '$id'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
    } else {
        echo "<p class='text-red-500'>Data tidak ditemukan.</p>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Member</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="max-w-xl w-full mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-4 text-gray-700">Edit Member</h2>
    <form method="POST">
      <input type="hidden" name="idUsers" value="<?= $data['idUsers']; ?>">
      
      <div class="mb-4">
        <label class="block mb-1 font-medium text-gray-600">Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($data['username']); ?>" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
      </div>
      
      <div class="mb-4">
        <label class="block mb-1 font-medium text-gray-600">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
      </div>
      
      <div class="mb-4">
        <label class="block mb-1 font-medium text-gray-600">Level</label>
        <select name="level" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
          <option value="admin" <?= ($data['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
          <option value="user" <?= ($data['level'] == 'user') ? 'selected' : ''; ?>>User</option>
          <option value="noc_engineer" <?= ($data['level'] == 'noc_engineer') ? 'selected' : ''; ?>>NOC Engineer</option>
        </select>
      </div>
      
      <div class="flex justify-between">
        <a href="index.php?menu=daftar_member" class="text-gray-500 hover:text-gray-700">← Kembali</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
      </div>
    </form>
  </div>

</body>
</html>
