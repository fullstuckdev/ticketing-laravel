<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// Query gabungan untuk ambil data tiket
$sql = "SELECT 
            t.idTickets,
            u_report.username AS report_by,
            u_assign.username AS assigned_to,
            t.subject,
            t.status,
            t.opened_at,
            t.closed_at
        FROM tickets t
        JOIN users u_report ON t.user_id = u_report.idUsers
        LEFT JOIN users u_assign ON t.assigned_to = u_assign.idUsers
        ORDER BY t.idTickets DESC";

$result = mysqli_query($conn, $sql);
?>

<h2 class="text-xl font-bold mb-4">HALAMAN DAFTAR TICKET</h2>

<!-- Tombol Tambah Ticket -->
<a href="form_ticket.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
  + Tambah Ticket
</a>

<!-- Tabel -->
<table class="min-w-full bg-white border border-gray-300 text-center">
  <thead>
    <tr>
      <th class="py-2 px-4 border-b">Ticket No</th>
      <th class="py-2 px-4 border-b">Report By</th>
      <th class="py-2 px-4 border-b">Category</th>
      <th class="py-2 px-4 border-b">Subject</th>
      <th class="py-2 px-4 border-b">Status</th>
      <th class="py-2 px-4 border-b">Durasi</th>
      <th class="py-2 px-4 border-b">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
  <td class="py-2 px-4 border-b">#<?= $row['idTickets'] ?></td>
  <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['report_by']) ?></td>
  <td class="py-2 px-4 border-b"><?= $row['assigned_to'] ? htmlspecialchars($row['assigned_to']) : '<i class="text-gray-400">Unassigned</i>' ?></td>
  <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['subject']) ?></td>
  <td class="py-2 px-4 border-b">
    <span class="px-2 py-1 rounded text-white
      <?= $row['status'] === 'open' ? 'bg-yellow-500' : ($row['status'] === 'in_progress' ? 'bg-blue-500' : 'bg-green-600') ?>">
      <?= ucfirst($row['status']) ?>
    </span>
  </td>
  <td class="py-2 px-4 border-b">
    <?php
    if ($row['status'] == 'closed' && $row['closed_at']) {
        $opened = new DateTime($row['opened_at']);
        $closed = new DateTime($row['closed_at']);
        $interval = $opened->diff($closed);
        echo $interval->format('%a hari %h jam %i menit');
    } else {
        echo '-';
    }
    ?>
  </td>
  <td class="py-2 px-4 border-b">
    <a href="detail_ticket.php?id=<?= $row['idTickets'] ?>" class="text-blue-500 hover:underline">Detail</a> |
    <a href="hapus_ticket.php?id=<?= $row['idTickets'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin hapus ticket ini?')">Delete</a>
    <?php if ($row['status'] !== 'closed'): ?>
      | <a href="update_status.php?id=<?= $row['idTickets'] ?>&status=closed" class="text-green-600 hover:underline" onclick="return confirm('Tutup tiket ini?')">Close Ticket</a>
    <?php endif; ?>
  </td>
</tr>
      <?php endwhile; ?>
      <?php else: ?>
  <tr>
    <td colspan="7" class="py-2 px-4 border-b text-gray-500">Tidak ada tiket.</td>
  </tr>
<?php endif; ?>
  </tbody>
</table>
