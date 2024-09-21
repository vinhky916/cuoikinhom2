<?php
session_start();
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tieu_de = $conn->real_escape_string($_POST['tieu_de']);
    $mo_ta = $conn->real_escape_string($_POST['mo_ta']);
    $noi_dung = $conn->real_escape_string($_POST['noi_dung']);

    $stmt = $conn->prepare("UPDATE bai_hoc SET tieu_de = ?, mo_ta = ?, noi_dung = ? WHERE id = ?");
    $stmt->bind_param("sssi", $tieu_de, $mo_ta, $noi_dung, $id);

    if ($stmt->execute()) {
        header("Location: manage_baihoc.php");
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM bai_hoc WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bai_hoc = $result->fetch_assoc();
    if (!$bai_hoc) {
        echo "Bài học không tồn tại.";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Bài Học</title>
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
    <h2>Sửa Bài Học</h2>
    <form action="" method="POST">
        <label>Tiêu Đề:</label><br>
        <input type="text" name="tieu_de" value="<?php echo $bai_hoc['tieu_de']; ?>" required><br><br>

        <label>Mô Tả:</label><br>
        <textarea name="mo_ta" required><?php echo $bai_hoc['mo_ta']; ?></textarea><br><br>

        <label>Nội Dung:</label><br>
        <textarea name="noi_dung" required><?php echo $bai_hoc['noi_dung']; ?></textarea><br><br>

        <input type="submit" value="Cập Nhật Bài Học">
    </form>
</main>

</body>
</html>