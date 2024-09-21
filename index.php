<?php
session_start();
include 'config.php';

// Kiểm tra nếu người dùng đã đăng nhập
$isLoggedIn = false;
if (isset($_SESSION['ten_dang_nhap'])) {
    $isLoggedIn = true;
    // Nếu là admin, chuyển hướng đến trang admin
    if ($_SESSION['vai_tro'] == 'admin') {
        header("Location: admin.php");
        exit();
    } else {
        // Nếu là người dùng thông thường, chuyển hướng đến trang người dùng
        header("Location: user_home.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="style.css">
    <!-- Thêm phông chữ từ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Coiny&display=swap" rel="stylesheet">
    <script>
        // Kiểm tra và áp dụng màu nền đã chọn (tính năng Tô màu)
        document.addEventListener('DOMContentLoaded', function() {
            var selectedColor = localStorage.getItem('selectedColor');
            if (selectedColor) {
                document.body.style.backgroundColor = selectedColor;
            }
        });

        // Truyền biến trạng thái đăng nhập từ PHP sang JavaScript
        var isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
    </script>
</head>
<body class="wrapper">
<header>
    <div class="top-bar">
        <h1>Xin Chào!</h1>
        <div class="login">
            <a href="login.php">Đăng Nhập</a> | 
            <a href="register.php">Đăng Ký</a>
        </div>
    </div>
</header>

<nav class="main-nav">
    <ul>
        <li><a href="index.php">Trang Chủ</a></li>
        <li><a href="baihoc_list.php" onclick="return checkLogin(event);">Bài Học</a></li>
        <li><a href="trochoi_list.php" onclick="return checkLogin(event);">Trò Chơi</a></li>
    </ul>
</nav>

<main>
    <h2>Khám Phá Và Học Tập Thật Vui Vẻ!</h2>
    <img src="images/home_banner.jpg" alt="Hình ảnh trang chủ" style="width:40%; margin-top:20px;">
    <p>Hãy tham gia cùng chúng tôi để khám phá thế giới tiếng Việt đầy màu sắc và thú vị. Các bài học và trò chơi được thiết kế riêng cho trẻ em, giúp các bé vừa học vừa chơi một cách hiệu quả.</p>
    <p><a href="register.php" style="font-size:1.5em; color:#FF1493;">Đăng ký ngay!</a></p>
</main>

<footer>
    <p>Bản quyền &copy; 2024 - Trang web học tiếng Việt cho trẻ em</p>
</footer>

<script>
    function checkLogin(event) {
        if (!isLoggedIn) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
            alert('Vui lòng đăng nhập hoặc đăng ký để tiếp tục.');
            return false;
        }
        // Nếu đã đăng nhập, cho phép tiếp tục
        return true;
    }
</script>

</body>
</html>