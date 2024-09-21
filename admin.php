<?php
session_start();
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản trị viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="wrapper">

<header>
    <div class="top-bar">
        <h1>Chào Admin!</h1>
        <div class="login">
            <a href="logout.php">Đăng Xuất</a>
        </div>
    </div>
</header>

<nav class="main-nav">
    <ul>
        <li><a href="admin.php">Trang Chủ Admin</a></li>
        <li><a href="manage_baihoc.php">Quản lý Bài Học</a></li>
        <li><a href="manage_trochoi.php">Quản lý Trò Chơi</a></li>
        <li><a href="logout.php">Đăng Xuất</a></li>
    </ul>
</nav>

<main>
    <h2>Chào mừng đến với trang quản trị!</h2>
    <p>Chọn một trong các chức năng quản lý ở trên để bắt đầu.</p>
    <img src="images/admin.webp" alt="Hình ảnh trang chủ" style="width:40%; margin-top:20px;">
</main>

<footer>
    <p>Bản quyền &copy; 2024 - Trang web học tiếng Việt cho trẻ em</p>
</footer>
</body>
</html>