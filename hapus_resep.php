<?php
session_start();
include 'config.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit();
}

// Pastikan ID resep telah diterima dari form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query untuk menghapus resep dari database
    $sql = "DELETE FROM resep_makanan WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman admin setelah berhasil menghapus resep
        header("Location: admin.php");
        exit();
    } else {
        echo "Gagal menghapus resep: " . $stmt->errorInfo()[2];
    }
} else {
    header("Location: admin.php");
    exit();
}
?>
