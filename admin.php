<?php
session_start();
include 'config.php';

// Pastikan admin telah login
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit();
}

// Ambil nama pengguna dari sesi jika tersedia
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';

// Query untuk mengambil data resep
$sql = "SELECT id, judul, bahan, langkah, gambar, waktu_memasak, kategori FROM resep_makanan";
$result = $db->query($sql);

if ($result === false) {
    die("Query failed: " . $db->errorInfo()[2]);
}

$num = 1; // Inisialisasi nomor urut
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Tambah Resep</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const recipes = document.querySelectorAll(".resep");
        recipes.forEach((recipe, index) => {
            setTimeout(() => {
                recipe.classList.add("show");
            }, index * 100); // Delay each item to create a staggered effect
        });
    });
    </script>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: url('https://i.ibb.co.com/XWh3LGh/bg.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    header {
        background: #1877f2;
        color: #fff;
        padding: 10px 0;
        text-align: left;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    header h1 {
        margin: 0;
        font-size: 2.5rem;
        padding-left: 20px;
    }

    header .user-info {
        font-size: 1rem;
        padding-right: 20px;
    }

    nav {
        padding-right: 20px;
    }

    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    nav ul li {
        margin-left: 10px;
    }

    nav ul li a {
        color: #fff;
        text-decoration: none;
    }

    main {
        padding: 20px;
    }

    .daftar-resep {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 10px;
    }

    .resep {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
        width: 250px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease; /* Efek animasi saat hover */  
    }

    .resep h2 {
        font-size: 1.5rem;
        margin: 0 0 10px;
    }

    .img-wrapper {
        width: 100%;
        height: 150px;
        overflow: hidden;
        border-radius: 10px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-wrapper img {
        width: 70%;
        height: auto;
        object-fit: cover;
        object-position: center;
    }

    .resep:hover {
        transform: translateY(-5px); /* Efek naik saat hover */
    }

    .resep p {
        margin: 10px 0;
    }

    .resep button {
        background: #333;
        border: none;
        padding: 10px 20px;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
    }

    .resep button:hover {
        background: #555;
    }

    .btn {
        display: inline-block;
        padding: 5px 10px;
        text-decoration: none;
        color: #333;
        border-radius: 10px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
        border: 1px solid transparent; /* Border awal */
    }

    .btn.btn-primary {
        background-color: white; /* Warna biru untuk tombol tambah resep */
    }

    .btn:hover {
        background-color: #165adf; /* Efek hover untuk semua tombol */
    }

    .btn.btn-primary:hover {
        border-color: #1877f2; /* Efek border saat hover */
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
        <h1>Admin Panel</h1>
        <div class="user-info">
            <p>Welcome, <?php echo htmlspecialchars($username); ?></p>
        </div>
        <nav>
            <ul>
                <li><a href="proses_tambah_resep.php" class="btn btn-primary">Tambah Resep</a></li>
                <li><a href="logout.php" class="btn btn-primary">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="daftar-resep">
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                <article class="resep">
                    <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
                    <div class="img-wrapper">
                        <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                    </div>
                    <p><a href="resep.php?id=<?php echo $row['id']; ?>"><button type="submit">Lihat Resep</button></a></p>
                    <form method="post" action="hapus_resep.php" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Hapus Resep</button>
                    </form>
                </article>
            <?php endwhile; ?>
        </section>
    </main>
    <footer>
        &copy; 2024 Resep Makanan
    </footer>
</body>
</html>
