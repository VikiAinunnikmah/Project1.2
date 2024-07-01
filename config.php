<?php
try {
    $db = new PDO('sqlite:C:/xampp/htdocs/resepmakan/database/resep_makanan.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
