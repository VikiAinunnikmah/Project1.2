<?php
include 'config.php';
session_start(); // Tambahkan session_start() jika Anda menggunakan session

// Pastikan ada parameter ID yang diterima dari URL
if (!isset($_GET['id'])) {
    die("ID resep tidak ditemukan.");
}

$id = $_GET['id'];

// Query untuk mengambil detail resep berdasarkan ID
$sql = "SELECT * FROM resep_makanan WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$resep = $stmt->fetch(PDO::FETCH_ASSOC);

// Pastikan resep dengan ID yang diberikan ada dalam database
if (!$resep) {
    die("Resep tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Resep: <?php echo htmlspecialchars($resep['judul']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://i.ibb.co.com/XWh3LGh/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background: #1877f2;
            color: #fff;
            padding: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        main {
            max-width: 800px;
            width: 100%;
            background: #fff;
            margin: 20px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .resep-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .resep-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .resep-detail h2 {
            color: #1877f2;
            text-align: center;
        }

        .resep-detail p {
            background: #f9f9f9;
            padding: 10px;
            border-left: 5px solid #1877f2;
            margin-bottom: 20px;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        footer {
            background: #1877f2;
            color: #fff;
            padding: 10px;
            width: 100%;
            text-align: center;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Detail Resep</h1>
        <nav>
            <ul>
                <li><a href="<?php echo isset($_SESSION['admin']) && $_SESSION['admin'] ? 'admin.php' : 'index.php'; ?>">Kembali ke Beranda</a></li>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin']) : ?>
                    <li><a href="admin.php">Admin Panel</a></li>
                    <!-- Tambahkan menu admin lainnya sesuai kebutuhan -->
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <article class="resep-detail">
            <?php if (!empty($resep['gambar'])) : ?>
                <div class="img-container">
                    <img src="<?php echo htmlspecialchars($resep['gambar']); ?>" alt="<?php echo htmlspecialchars($resep['judul']); ?>">
                </div>
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($resep['judul']); ?></h2>

            <h2>Bahan-bahan:</h2>
            <p><?php echo nl2br(htmlspecialchars($resep['bahan'])); ?></p>
            
            <h2>Langkah-langkah:</h2>
            <p><?php echo nl2br(htmlspecialchars($resep['langkah'])); ?></p>
            
            <?php if (!empty($resep['waktu_memasak'])) : ?>
                <h2>Waktu Memasak:</h2>
                <p><?php echo htmlspecialchars($resep['waktu_memasak']); ?></p>
            <?php endif; ?>
        </article>
    </main>
    <footer>
        &copy; 2024 Resep Makanan
    </footer>
</body>
</html>
