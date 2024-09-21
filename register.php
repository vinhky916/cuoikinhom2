<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $conn->real_escape_string($_POST['ten_dang_nhap']);
    $email = $conn->real_escape_string($_POST['email']);
    $mat_khau = $_POST['mat_khau'];
    $mat_khau2 = $_POST['mat_khau2'];

    if ($mat_khau != $mat_khau2) {
        $error = "Mật khẩu không khớp!";
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);

        // Kiểm tra tên đăng nhập đã tồn tại chưa
        $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ?");
        $stmt->bind_param("s", $ten_dang_nhap);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Tên đăng nhập đã tồn tại!";
        } else {
            // Thêm người dùng vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO nguoi_dung (ten_dang_nhap, email, mat_khau, vai_tro) VALUES (?, ?, ?, 'user')");
            $stmt->bind_param("sss", $ten_dang_nhap, $email, $hashed_password);
            if ($stmt->execute()) {
                $_SESSION['ten_dang_nhap'] = $ten_dang_nhap;
                $_SESSION['vai_tro'] = 'user';
                header("Location: user_home.php");
                exit();
            } else {
                $error = "Đã xảy ra lỗi, vui lòng thử lại!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
    <h2>Đăng Ký</h2>
    <?php if (isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
    <form action="" method="POST">
        <label>Tên Đăng Nhập:</label><br>
        <input type="text" name="ten_dang_nhap" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mật Khẩu:</label><br>
        <input type="password" name="mat_khau" required><br><br>

        <label>Nhập Lại Mật Khẩu:</label><br>
        <input type="password" name="mat_khau2" required><br><br>

        <input type="submit" value="Đăng Ký">
    </form>
</main>

</body>
</html>