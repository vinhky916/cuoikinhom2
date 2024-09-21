<?php
$servername = "localhost";
$username = "root"; // Thay bằng tên người dùng cơ sở dữ liệu của bạn
$password = ""; // Thay bằng mật khẩu cơ sở dữ liệu của bạn
$dbname = "cuoi_ki";

// Tạo kết nối
$conn = new mysqli("localhost", "root", "", "cuoi_ki");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập bộ ký tự để tránh lỗi font
$conn->set_charset("utf8");
?>