<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $conn->real_escape_string($_POST['ten_dang_nhap']);
    $mat_khau = $_POST['mat_khau'];

    // Kiểm tra nếu là admin mặc định
    if ($ten_dang_nhap == 'admin' && $mat_khau == '123') {
        // Đảm bảo admin mặc định tồn tại trong cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE ten_dang_nhap = 'admin'");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            // Thêm admin mặc định vào cơ sở dữ liệu
            $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO nguoi_dung (ten_dang_nhap, email, mat_khau, vai_tro) VALUES ('admin', 'admin@example.com', ?, 'admin')");
            $stmt->bind_param("s", $hashed_password);
            $stmt->execute();
        } else {
            // Kiểm tra mật khẩu
            $row = $result->fetch_assoc();
            if (!password_verify($mat_khau, $row['mat_khau'])) {
                // Cập nhật mật khẩu mới cho admin mặc định
                $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE nguoi_dung SET mat_khau = ? WHERE ten_dang_nhap = 'admin'");
                $stmt->bind_param("s", $hashed_password);
                $stmt->execute();
            }
        }
        $_SESSION['ten_dang_nhap'] = 'admin';
        $_SESSION['vai_tro'] = 'admin';
        header("Location: admin.php");
        exit();
    } else {
        // Kiểm tra thông tin đăng nhập của người dùng
        $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ?");
        $stmt->bind_param("s", $ten_dang_nhap);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($mat_khau, $row['mat_khau'])) {
                $_SESSION['ten_dang_nhap'] = $row['ten_dang_nhap'];
                $_SESSION['vai_tro'] = $row['vai_tro'];
                if ($row['vai_tro'] == 'admin') {
                    header("Location: admin.php");
                    exit();
                } else {
                    header("Location: user_home.php");
                    exit();
                }
            } else {
                $error = "Sai mật khẩu!";
            }
        } else {
            $error = "Tên đăng nhập không tồn tại!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
    <h2>Đăng Nhập</h2>
    <?php if (isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
    <form action="" method="POST">
        <label>Tên Đăng Nhập:</label><br>
        <input type="text" name="ten_dang_nhap" required><br><br>

        <label>Mật Khẩu:</label><br>
        <input type="password" name="mat_khau" required><br><br>

        <input type="submit" value="Đăng Nhập">
    </form>
</main>

</body>
</html>