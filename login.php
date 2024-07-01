<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password
    $sql = "SELECT id, password FROM admin WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = true;
            header("Location: admin.php");
            exit();
        } else {
            $error_message = "Login gagal. Password salah.";
        }
    } else {
        $error_message = "Login gagal. Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://i.ibb.co.com/XWh3LGh/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            background: #fff;
            max-width: 1200px;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .left {
            flex: 1;
            background: url('https://i.ibb.co.com/StTLp3s/resepmasakan.png') no-repeat center center;
            background-size: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }

        .login-container {
            width: 100%;
            text-align: center;
        }

        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            font-size: 14px;
            margin-bottom: 5px;
            text-align: left;
        }

        .login-container input {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-container button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #1877f2;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #165adf;
        }

        .login-container .error-message {
            color: red;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left, .right {
                flex: none;
                width: 100%;
            }

            .login-container {
                width: 90%;
                margin: auto;
            }
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
    <div class="container">
        <div class="left"></div>
        <div class="right">
            <div class="login-container">
                <h1>Login Admin</h1>
                <?php if (isset($error_message)) : ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form method="post" action="">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2024 Resep Makanan
    </footer>
</body>
</html>
