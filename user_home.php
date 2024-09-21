<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'user') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ Người Dùng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="wrapper">

<header>
    <div class="top-bar">
        <h1>Chào mừng, <?php echo $_SESSION['ten_dang_nhap']; ?>!</h1>
        <div class="login">
            <a href="logout.php">Đăng Xuất</a>
        </div>
    </div>
</header>

<nav class="main-nav">
    <ul>
        <li><a href="user_home.php">Trang Chủ</a></li>
        <li><a href="baihoc_list.php">Bài Học</a></li>
        <li><a href="trochoi_list.php">Trò Chơi</a></li>
    </ul>
</nav>

<main>
    <h2>Nội Dung Dành Cho Bạn</h2>
    <p>Hãy khám phá các bài học và trò chơi thú vị để nâng cao kiến thức của bạn.</p>
    <img src="images/user.jpg" alt="Hình ảnh trang chủ" style="width:40%; margin-top:20px;">
</main>

<footer>
    <p>Bản quyền &copy; 2024 - Trang web học tiếng Việt cho trẻ em</p>
</footer>
</body>
</html>