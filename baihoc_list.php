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
    <title>Danh Sách Bài Học</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="wrapper">

<header>
    <div class="top-bar">
        <h1>Danh Sách Bài Học</h1>
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
        <li><a href="<?php echo isset($_SESSION['vai_tro']) && $_SESSION['vai_tro'] == 'user' ? 'user_home.php' : 'index.php'; ?>">Trang Chủ</a></li>
        <li><a href="baihoc_list.php">Bài Học</a></li>
        <li><a href="trochoi_list.php">Trò Chơi</a></li>
    </ul>
</nav>

<main>
    <h2>Khám Phá Các Bài Học Thú Vị!</h2>
    <div class="lesson-list">
        <?php
        $sql = "SELECT * FROM bai_hoc ORDER BY ngay_tao DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Xác định hình ảnh cho từng bài học
                $hinh_anh = '';
                if ($row['tieu_de'] == 'Học số đếm từ 1 đến 10') {
                    $hinh_anh = 'images/so_dem.jpeg'; // Hình ảnh cho bài học "Học số đếm từ 1 đến 10"
                } elseif ($row['tieu_de'] == 'Học chữ cái tiếng Việt') {
                    $hinh_anh = 'images/chu_cai.jpg'; // Hình ảnh cho bài học "Học chữ cái tiếng Việt"
                } elseif ($row['tieu_de'] == 'Học màu sắc') {
                    $hinh_anh = 'images/mau_sac.jpg'; // Hình ảnh cho bài học "Học màu sắc"
                } else {
                    $hinh_anh = 'images/baihoc.jpg'; // Hình ảnh mặc định
                }

                echo '
                <div class="card">
                    <img src="' . $hinh_anh . '" alt="Bài Học">
                    <h3>' . $row['tieu_de'] . '</h3>
                    <p>' . $row['mo_ta'] . '</p>
                    <a href="baihoc_detail.php?id=' . $row['id'] . '">Học Ngay</a>
                </div>';
            }
        } else {
            echo '<p>Chưa có bài học nào.</p>';
        }
        ?>
    </div>
</main>

<footer>
    <p>Bản quyền &copy; 2024 - Trang web học tiếng Việt cho trẻ em</p>
</footer>

</body>
</html>