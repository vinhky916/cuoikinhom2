<?php
session_start();
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tieu_de = $conn->real_escape_string($_POST['tieu_de']);
    $mo_ta = $conn->real_escape_string($_POST['mo_ta']);
    $noi_dung = $conn->real_escape_string($_POST['noi_dung']);

    $stmt = $conn->prepare("INSERT INTO bai_hoc (tieu_de, mo_ta, noi_dung) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tieu_de, $mo_ta, $noi_dung);

    if ($stmt->execute()) {
        header("Location: manage_baihoc.php");
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
    <title>Thêm Bài Học</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <!-- Header -->
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
    <h2>Thêm Bài Học Mới</h2>
    <form action="" method="POST">
        <label>Tiêu Đề:</label><br>
        <input type="text" name="tieu_de" required><br><br>

        <label>Mô Tả:</label><br>
        <textarea name="mo_ta" required></textarea><br><br>

        <label>Nội Dung:</label><br>
        <textarea name="noi_dung" required></textarea><br><br>

        <input type="submit" value="Thêm Bài Học">
    </form>
</main>

</body>
</html>