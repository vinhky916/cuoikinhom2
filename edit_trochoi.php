<?php
session_start();
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_tro_choi = $conn->real_escape_string($_POST['ten_tro_choi']);
    $mo_ta = $conn->real_escape_string($_POST['mo_ta']);
    $duong_dan = $conn->real_escape_string($_POST['duong_dan']);

    $stmt = $conn->prepare("UPDATE tro_choi SET ten_tro_choi = ?, mo_ta = ?, duong_dan = ? WHERE id = ?");
    $stmt->bind_param("sssi", $ten_tro_choi, $mo_ta, $duong_dan, $id);

    if ($stmt->execute()) {
        header("Location: manage_trochoi.php");
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM tro_choi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tro_choi = $result->fetch_assoc();
    if (!$tro_choi) {
        echo "Trò chơi không tồn tại.";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Trò Chơi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <!-- Header -->
    <div class="top-bar">
        <h1>Sửa Trò Chơi</h1>
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
    <h2>Sửa Trò Chơi</h2>
    <form action="" method="POST">
        <label>Tên Trò Chơi:</label><br>
        <input type="text" name="ten_tro_choi" value="<?php echo $tro_choi['ten_tro_choi']; ?>" required><br><br>

        <label>Mô Tả:</label><br>
        <textarea name="mo_ta" required><?php echo $tro_choi['mo_ta']; ?></textarea><br><br>

        <label>Đường Dẫn:</label><br>
        <input type="text" name="duong_dan" value="<?php echo $tro_choi['duong_dan']; ?>" required><br><br>

        <input type="submit" value="Cập Nhật Trò Chơi">
    </form>
</main>

</body>
</html>