<?php
session_start();
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_tro_choi = $conn->real_escape_string($_POST['ten_tro_choi']);
    $mo_ta = $conn->real_escape_string($_POST['mo_ta']);
    $duong_dan = $conn->real_escape_string($_POST['duong_dan']);

    $stmt = $conn->prepare("INSERT INTO tro_choi (ten_tro_choi, mo_ta, duong_dan) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ten_tro_choi, $mo_ta, $duong_dan);

    if ($stmt->execute()) {
        header("Location: manage_trochoi.php");
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Trò Chơi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <!-- Header -->
    <div class="top-bar">
        <h1>Thêm Trò Chơi Mới</h1>
        <div class="login">
            <a href="logout.php">Đăng Xuất</a>
        </div>
    </div>
</header>

<nav class="main-nav">
    <!-- Menu điều hướng -->
    <ul>
        <li><a href="admin.php">Trang Chủ Admin</a></li>
        <li><a href="manage_baihoc.php">Quản lý Bài Học</a></li>
        <li><a href="manage_trochoi.php">Quản lý Trò Chơi</a></li>
        <li><a href="logout.php">Đăng Xuất</a></li>
    </ul>
</nav>

<main>
    <h2>Thêm Trò Chơi Mới</h2>
    <form action="" method="POST">
        <label>Tên Trò Chơi:</label><br>
        <input type="text" name="ten_tro_choi" required><br><br>

        <label>Mô Tả:</label><br>
        <textarea name="mo_ta" required></textarea><br><br>

        <label>Đường Dẫn:</label><br>
        <input type="text" name="duong_dan" required><br><br>

        <input type="submit" value="Thêm Trò Chơi">
    </form>
</main>

</body>
</html>