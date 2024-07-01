<?php
session_start();
include 'config.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit();
}

// Inisialisasi variabel pesan error
$pesan_error = '';

// Proses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $gambar = $_POST['gambar'];
    $waktu_memasak = $_POST['waktu_memasak'];
    $kategori = $_POST['kategori'];

    // Validasi data
    if (empty($judul) || empty($bahan) || empty($langkah)) {
        $pesan_error = "Semua field harus diisi.";
    } else {
        // Query untuk menambahkan resep ke database
        $sql = "INSERT INTO resep_makanan (judul, bahan, langkah, gambar, waktu_memasak, kategori) 
                VALUES (:judul, :bahan, :langkah, :gambar, :waktu_memasak, :kategori)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':judul', $judul, PDO::PARAM_STR);
        $stmt->bindParam(':bahan', $bahan, PDO::PARAM_STR);
        $stmt->bindParam(':langkah', $langkah, PDO::PARAM_STR);
        $stmt->bindParam(':gambar', $gambar, PDO::PARAM_STR);
        $stmt->bindParam(':waktu_memasak', $waktu_memasak, PDO::PARAM_STR);
        $stmt->bindParam(':kategori', $kategori, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Redirect ke halaman admin setelah berhasil tambah resep
            header("Location: admin.php");
            exit();
        } else {
            $pesan_error = "Gagal menambahkan resep: " . $stmt->errorInfo()[2];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Resep</title>
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
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            padding: 5px 10px;
            text-decoration: none;
            color: #333;
            border-radius: 10px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            border: 1px solid transparent;
        }

        .btn.btn-primary {
            background-color: white;
        }

        .btn:hover {
            background-color: #165adf;
        }

        .btn.btn-primary:hover {
            border-color: #1877f2;
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

        .form-tambah-resep {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-tambah-resep h2 {
            color: #1877f2;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button[type="submit"] {
            background: #1877f2;
            color: #fff;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background: #165adf;
        }

        .error {
            color: red;
            margin-top: 10px;
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
        <h1>Tambah Resep</h1>
        <nav>
            <ul>
                <li><a href="admin.php" class="btn btn-primary">Kembali ke Admin Panel</a></li>
                <li><a href="logout.php" class="btn btn-primary">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="form-tambah-resep">
            <h2>Form Tambah Resep Baru</h2>
            <?php if (!empty($pesan_error)) : ?>
                <p class="error"><?php echo htmlspecialchars($pesan_error); ?></p>
            <?php endif; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="judul">Judul Resep:</label>
                <input type="text" id="judul" name="judul" required>
                <label for="bahan">Bahan-bahan:</label>
                <textarea id="bahan" name="bahan" rows="5" required></textarea>
                <label for="langkah">Langkah-langkah:</label>
                <textarea id="langkah" name="langkah" rows="10" required></textarea>
                <label for="gambar">URL Gambar (Opsional):</label>
                <input type="text" id="gambar" name="gambar">
                <label for="waktu_memasak">Waktu Memasak (Opsional):</label>
                <input type="text" id="waktu_memasak" name="waktu_memasak">
                <button type="submit">Tambah Resep</button>
            </form>
        </section>
    </main>
    <footer>
        &copy; 2024 Resep Makanan
    </footer>
</body>
</html>
