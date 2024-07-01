<?php
include 'config.php';

// Data admin baru
$username = 'eka';
$password = 'eka123';

// Hashing password (opsional, tapi disarankan)
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Query untuk memasukkan data admin
$sql = "INSERT INTO admin (username, password) VALUES (:username, :password)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);

if ($stmt->execute()) {
    echo "Admin berhasil ditambahkan.";
} else {
    echo "Gagal menambahkan admin: " . $stmt->errorInfo()[2];
}
?>
