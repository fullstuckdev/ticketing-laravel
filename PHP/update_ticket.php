<?php
include 'koneksi.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    if ($status === 'closed') {
        $sql = "UPDATE tickets SET status = 'closed', closed_at = NOW() WHERE idTickets = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    } else {
        $sql = "UPDATE tickets SET status = ? WHERE idTickets = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);
    }

    if ($stmt->execute()) {
        header("Location: list_ticket.php");
    } else {
        echo "Gagal update status.";
    }
} else {
    echo "Parameter tidak lengkap.";
}
?>
