<?php
require 'koneksi.php'; // Pastikan file koneksi ke DB ada

// Fungsi ambil data tiket + relasi kategori dan user
function getTickets($conn, $where = '') {
    $query = "SELECT t.idTickets, u.username, c.name AS kategori, t.subject, t.status, t.created_at 
              FROM tickets t
              JOIN users u ON t.user_id = u.idUsers
              JOIN categories c ON t.category_id = c.idCategories";
    if ($where) $query .= " WHERE $where";
    return mysqli_query($conn, $query);
}

// Export Excel
if (isset($_POST['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_tiket.xls");
    echo "<table border='1'>
        <tr>
            <th>ID</th><th>Username</th><th>Kategori</th><th>Subjek</th><th>Status</th><th>Dibuat Pada</th>
        </tr>";

    $where = $_POST['filter'] ?? '';
    $data = getTickets($conn, $where);
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr>
            <td>{$row['idTickets']}</td>
            <td>{$row['username']}</td>
            <td>{$row['kategori']}</td>
            <td>{$row['subject']}</td>
            <td>{$row['status']}</td>
            <td>{$row['created_at']}</td>
        </tr>";
    }
    echo "</table>";
    exit;
}
?>

<h2 class="text-xl font-bold mb-4">Laporan Transaksi Tiket</h2>

<!-- Form Export -->
<form method="post" class="mb-4" onsubmit="return setFilterValue()">
    <input type="hidden" name="export_excel" value="1">
    <input type="hidden" name="filter" id="filter-value">

    <!-- Radio Button Pilihan Export -->
    <div class="mb-4">
        <label class="flex items-center">
            <input type="radio" name="export_type" value="all" checked onclick="toggleInputs()">
            <span class="ml-2">Export Semua Data</span>
        </label>

        <label class="flex items-center mt-2">
            <input type="radio" name="export_type" value="date" onclick="toggleInputs()">
            <span class="ml-2">Export Berdasarkan Tanggal</span>
        </label>

        <div id="date-inputs" class="hidden mt-2">
            <input type="date" name="start_date" id="start_date" class="border px-2 py-1 rounded">
            <span>sampai</span>
            <input type="date" name="end_date" id="end_date" class="border px-2 py-1 rounded">
        </div>

        <label class="flex items-center mt-2">
            <input type="radio" name="export_type" value="category" onclick="toggleInputs()">
            <span class="ml-2">Export Berdasarkan Kategori</span>
        </label>

        <div id="category-input" class="hidden mt-2">
            <select name="kategori" id="kategori" class="border px-2 py-1 rounded">
                <option value="">-- Pilih Kategori --</option>
                <?php
                $kategori_q = mysqli_query($conn, "SELECT * FROM categories");
                while ($kat = mysqli_fetch_assoc($kategori_q)) {
                    echo "<option value='{$kat['name']}'>{$kat['name']}</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Tombol Submit -->
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
        Export Data
    </button>
</form>

<!-- Cetak PDF -->
<button onclick="window.print()" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded mb-4">
    Cetak ke PDF
</button>

<!-- Tampilkan Data -->
<table class="min-w-full bg-white border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Username</th>
            <th class="border px-4 py-2">Kategori</th>
            <th class="border px-4 py-2">Subjek</th>
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = getTickets($conn);
        while ($row = mysqli_fetch_assoc($data)) {
            echo "<tr>
                <td class='border px-4 py-2'>{$row['idTickets']}</td>
                <td class='border px-4 py-2'>{$row['username']}</td>
                <td class='border px-4 py-2'>{$row['kategori']}</td>
                <td class='border px-4 py-2'>{$row['subject']}</td>
                <td class='border px-4 py-2'>{$row['status']}</td>
                <td class='border px-4 py-2'>{$row['created_at']}</td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<!-- JavaScript untuk Mengatur Input -->
<script>
function toggleInputs() {
    let type = document.querySelector('input[name="export_type"]:checked').value;
    document.getElementById("date-inputs").classList.toggle("hidden", type !== "date");
    document.getElementById("category-input").classList.toggle("hidden", type !== "category");
}

function setFilterValue() {
    let type = document.querySelector('input[name="export_type"]:checked').value;
    let filter = "";

    if (type === "date") {
        let start = document.getElementById("start_date").value;
        let end = document.getElementById("end_date").value;
        if (!start || !end) {
            alert("Pilih tanggal terlebih dahulu!");
            return false;
        }
        filter = `t.created_at BETWEEN '${start}' AND '${end}'`;
    } else if (type === "category") {
        let category = document.getElementById("kategori").value;
        if (!category) {
            alert("Pilih kategori terlebih dahulu!");
            return false;
        }
        filter = `c.name = '${category}'`;
    }

    document.getElementById("filter-value").value = filter;
    return true;
}
</script>

<style>
.hidden {
    display: none;
}
</style>
