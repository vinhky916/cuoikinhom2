<?php
session_start();
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Trò Chơi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <!-- Header -->
    <div class="top-bar">
        <h1>Quản lý Trò Chơi</h1>
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
    <h2>Danh sách Trò Chơi</h2>
    <a href="add_trochoi.php">Thêm Trò Chơi Mới</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên Trò Chơi</th>
            <th>Mô Tả</th>
            <th>Đường Dẫn</th>
            <th>Ngày Tạo</th>
            <th>Hành Động</th>
        </tr>
        <?php
        $sql = "SELECT * FROM tro_choi";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['ten_tro_choi']}</td>
                        <td>{$row['mo_ta']}</td>
                        <td>{$row['duong_dan']}</td>
                        <td>{$row['ngay_tao']}</td>
                        <td>
                            <a href='edit_trochoi.php?id={$row['id']}'>Sửa</a> |
                            <a href='delete_trochoi.php?id={$row['id']}' onclick='return confirm(\"Bạn có chắc muốn xóa trò chơi này?\")'>Xóa</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có trò chơi nào.</td></tr>";
        }
        ?>
    </table>
</main>

</body>
</html>