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
    <title>Quản lý Bài Học</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <!-- Header -->
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
    <h2>Danh sách Bài Học</h2>
    <a href="add_baihoc.php">Thêm Bài Học Mới</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tiêu Đề</th>
            <th>Mô Tả</th>
            <th>Ngày Tạo</th>
            <th>Hành Động</th>
        </tr>
        <?php
        $sql = "SELECT * FROM bai_hoc";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['tieu_de']}</td>
                        <td>{$row['mo_ta']}</td>
                        <td>{$row['ngay_tao']}</td>
                        <td>
                            <a href='edit_baihoc.php?id={$row['id']}'>Sửa</a> |
                            <a href='delete_baihoc.php?id={$row['id']}' onclick='return confirm(\"Bạn có chắc muốn xóa bài học này?\")'>Xóa</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Không có bài học nào.</td></tr>";
        }
        ?>
    </table>
</main>

</body>
</html>