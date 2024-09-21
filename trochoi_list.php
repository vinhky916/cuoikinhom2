<?php
session_start();
include 'config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['ten_dang_nhap'])) {
    // Chuyển hướng đến trang đăng nhập hoặc hiển thị thông báo
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Trò Chơi</title>
    <link rel="stylesheet" href="style.css">
    <!-- Thêm phông chữ từ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Coiny&display=swap" rel="stylesheet">
</head>
<body class="wrapper">

<header>
    <div class="top-bar">
        <h1>Danh Sách Trò Chơi</h1>
        <div class="login">
            <?php
            if (isset($_SESSION['ten_dang_nhap'])) {
                echo '<a href="logout.php">Đăng Xuất</a>';
            } else {
                echo '<a href="login.php">Đăng Nhập</a> | <a href="register.php">Đăng Ký</a>';
            }
            ?>
        </div>
    </div>
</header>

<nav class="main-nav">
    <ul>
        <li><a href="<?php echo (isset($_SESSION['vai_tro']) && $_SESSION['vai_tro'] == 'user') ? 'user_home.php' : 'index.php'; ?>">Trang Chủ</a></li>
        <li><a href="baihoc_list.php">Bài Học</a></li>
        <li><a href="trochoi_list.php">Trò Chơi</a></li>
    </ul>
</nav>

<main>
    <h2>Chơi Và Học Thật Vui!</h2>
    <div class="game-list">
        <?php
        $sql = "SELECT * FROM tro_choi ORDER BY ngay_tao DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Xác định hình ảnh cho từng trò chơi
                $hinh_anh = '';
                if ($row['ten_tro_choi'] == 'Đố vui về số đếm') {
                    $hinh_anh = 'images/do_vui.png';
                } elseif ($row['ten_tro_choi'] == 'Ghép chữ cái') {
                    $hinh_anh = 'images/ghep_chu.png';
                } elseif ($row['ten_tro_choi'] == 'Tô màu') {
                    $hinh_anh = 'images/to_mau.jpg';
                } else {
                    $hinh_anh = 'images/baihoc.jpg'; // Hình ảnh mặc định
                }

                echo '
                <div class="card">
                    <img src="' . $hinh_anh . '" alt="Trò Chơi">
                    <h3>' . $row['ten_tro_choi'] . '</h3>
                    <p>' . $row['mo_ta'] . '</p>
                    <a href="trochoi_detail.php?id=' . $row['id'] . '">Chơi Ngay</a>
                </div>';
            }
        } else {
            echo '<p>Chưa có trò chơi nào.</p>';
        }
        ?>
    </div>
</main>

<footer>
    <p>Bản quyền &copy; 2024 - Trang web học tiếng Việt cho trẻ em</p>
</footer>

</body>
</html>