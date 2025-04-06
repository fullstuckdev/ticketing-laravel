<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// Ambil parameter sorting dan search dari URL
$sort = isset($_GET['sort']) ? strtolower($_GET['sort']) : 'asc';
$sort = ($sort === 'desc') ? 'DESC' : 'ASC';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query dengan filter pencarian jika ada
if (!empty($search)) {
    $sql = "SELECT idUsers, username, email, level 
            FROM users 
            WHERE username LIKE '%$search%' OR email LIKE '%$search%' 
            ORDER BY username $sort";
} else {
    $sql = "SELECT idUsers, username, email, level 
            FROM users 
            ORDER BY username $sort";
}


// // Query berdasarkan sorting
// if ($sort === 'desc') {
//     $sql = "SELECT idUsers, username, email, level FROM users ORDER BY username DESC";
// } else {
//     $sql = "SELECT idUsers, username, email, level FROM users ORDER BY username ASC";
// }

$result = mysqli_query($conn, $sql);
?>

<h2 class="text-xl font-bold mb-4">HALAMAN DAFTAR MEMBER</h2>
<!-- Form Search -->
<form method="GET" action="index.php" class="mb-4 flex items-center justify-end gap-2">
  <input type="hidden" name="page" value="get_users">
  <input type="text" name="search" placeholder="Cari username/email..." 
    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
    class="border border-gray-300 px-3 py-2 rounded w-64">
  <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
    Cari
  </button>
</form>




<!-- Tombol Tambah -->
<button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
  class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mb-4">
  + Tambah Member
</button>



<!-- Tabel Member tanpa kolom ID -->
<table class="min-w-full bg-white border border-gray-300 text-center">
  <thead>
    <tr>
      <th class="py-2 px-4 border-b">
        Username
        <a href="index.php?page=get_users&sort=asc" class="text-sm text-blue-500 hover:underline ml-1">A-Z</a> |
<a href="index.php?page=get_users&sort=desc" class="text-sm text-blue-500 hover:underline">Z-A</a>
      </th>
      <th class="py-2 px-4 border-b">Email</th>
      <th class="py-2 px-4 border-b">Level</th>
      <th class="py-2 px-4 border-b">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['username']) ?></td>
          <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['email']) ?></td>
          <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['level']) ?></td>
          <td class="py-2 px-4 border-b">
          <a href="edit_member.php?idUsers=<?= $row['idUsers'] ?>" class="text-blue-500 hover:underline">Edit</a> |
            <a href="hapus_member.php?idUsers=<?= $row['idUsers'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="4" class="py-2 px-4 border-b text-gray-500">Tidak ada data member.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
