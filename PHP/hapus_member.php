<?php
include 'koneksi.php';

if (isset($_GET['idUsers'])) {
    $id = $_GET['idUsers'];

    // Cek apakah data dengan ID tersebut ada
    $check = mysqli_query($conn, "SELECT * FROM users WHERE idUsers = '$id'");
    if (mysqli_num_rows($check) > 0) {
        // Hapus data
        $delete = mysqli_query($conn, "DELETE FROM users WHERE idUsers = '$id'");
        if ($delete) {
            header("Location: index.php?section=daftar-member"); // Redirect ke halaman index setelah hapus
            exit();
        } else {
            echo "Gagal menghapus data: " . mysqli_error($conn);
        }
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "ID tidak ditemukan di URL.";
}
?>
