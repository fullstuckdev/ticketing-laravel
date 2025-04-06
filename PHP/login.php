<?php
session_start();
include 'koneksi.php'; // Hubungkan dengan database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username dan password di database
    $sql = "SELECT * FROM users WHERE username = ? AND password = SHA2(?, 256)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika ada hasil, berarti login berhasil
    if ($result->num_rows > 0) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'title.php'; ?>
    <!-- <title>Login Page</title> -->
    <link rel="stylesheet" href="login.css"> <!-- Tambahkan CSS eksternal -->
</head>
<body>
    <div class="login-container">
        <img src="images/logomtau.png" alt="Logo" class="login-logo"> <!-- Tambahkan logo -->
        <!-- <h2>Login Admin</h2> -->
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
