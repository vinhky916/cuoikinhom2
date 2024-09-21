<?php
session_start();
include 'config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin bài học từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM bai_hoc WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$bai_hoc = $result->fetch_assoc();

if (!$bai_hoc) {
    echo "Bài học không tồn tại.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $bai_hoc['tieu_de']; ?></title>
    <link rel="stylesheet" href="style.css">
    <!-- Thêm phông chữ từ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Coiny&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Coiny', cursive;
        }
        .number-lesson, .content {
            text-align: center;
        }
        .number-lesson .item, .color-lesson .item {
            display: inline-block;
            margin: 20px;
        }
        .number-lesson img, .color-lesson img {
            width: 100px;
        }
        .number-lesson input[type="text"], .color-lesson input[type="text"] {
            width: 100px;
            margin-top: 10px;
            text-align: center;
        }
        .number-lesson button, .color-lesson button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #FF69B4;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .number-lesson button:hover, .color-lesson button:hover {
            background-color: #FF1493;
        }
        /* Định dạng cho video */
        .content iframe {
            margin-top: 20px;
            border-radius: 15px;
        }
    </style>
</head>
<body class="wrapper">

<header>
    <div class="top-bar">
        <h1><?php echo $bai_hoc['tieu_de']; ?></h1>
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
    <?php if ($bai_hoc['tieu_de'] == 'Học số đếm từ 1 đến 10'): ?>
        <!-- Nội dung đặc biệt cho bài học "Học số đếm từ 1 đến 10" -->
        <div class="number-lesson">
            <h2>Bài học: Học số đếm từ 1 đến 10</h2>
            <div class="item">
                <img src="images/apple.webp" alt="1 quả táo">
                <br>
                <input type="text" name="number1" placeholder="Điền số">
            </div>
            <div class="item">
                <img src="images/orange.jpg" alt="1 quả cam">
                <img src="images/orange.jpg" alt="2 quả cam">
                <br>
                <input type="text" name="number2" placeholder="Điền số">
            </div>
            <div class="item">
                <img src="images/banana.jpg" alt="1 quả chuối">
                <img src="images/banana.jpg" alt="2 quả chuối">
                <img src="images/banana.jpg" alt="3 quả chuối">
                <br>
                <input type="text" name="number3" placeholder="Điền số">
            </div>
            <br>
            <button onclick="checkAnswers()">Kiểm tra kết quả</button>
        </div>

        <script>
        function checkAnswers() {
            let score = 0;
            let ans1 = document.getElementsByName('number1')[0].value.trim();
            let ans2 = document.getElementsByName('number2')[0].value.trim();
            let ans3 = document.getElementsByName('number3')[0].value.trim();

            if (ans1 == '1') score++;
            if (ans2 == '2') score++;
            if (ans3 == '3') score++;

            alert('Bạn trả lời đúng ' + score + ' trên 3 câu hỏi.');
        }
        </script>
    <?php elseif ($bai_hoc['tieu_de'] == 'Học chữ cái tiếng Việt'): ?>
        <!-- Nội dung đặc biệt cho bài học "Học chữ cái tiếng Việt" -->
        <div class="content">
            <h2><?php echo $bai_hoc['tieu_de']; ?></h2>
            <p><?php echo nl2br(htmlspecialchars_decode($bai_hoc['noi_dung'])); ?></p>
            <!-- Chèn video YouTube -->
            <iframe width="1000" height="600" src="https://www.youtube.com/embed/O1wECMvWeyU" title="Học chữ cái tiếng Việt" frameborder="0" allowfullscreen></iframe>
        </div>
    <?php elseif ($bai_hoc['tieu_de'] == 'Học màu sắc'): ?>
        <!-- Nội dung đặc biệt cho bài học "Học màu sắc" -->
        <div class="content">
            <h2><?php echo $bai_hoc['tieu_de']; ?></h2>
            <div class="color-lesson">
                <div class="item">
                    <img src="images/pink_umbrella.jpg" alt="Cây dù màu hồng">
                    <br>
                    <input type="text" name="color1" placeholder="Màu gì?">
                </div>
                <div class="item">
                    <img src="images/yellow_sandal.jpg" alt="Chiếc dép màu vàng">
                    <br>
                    <input type="text" name="color2" placeholder="Màu gì?">
                </div>
                <div class="item">
                    <img src="images/blue_pencilcase.webp" alt="Hộp bút màu xanh dương">
                    <br>
                    <input type="text" name="color3" placeholder="Màu gì?">
                </div>
                <br>
                <button onclick="checkColors()">Kiểm tra kết quả</button>
            </div>
            <script>
            function checkColors() {
                let score = 0;
                let ans1 = document.getElementsByName('color1')[0].value.trim().toLowerCase();
                let ans2 = document.getElementsByName('color2')[0].value.trim().toLowerCase();
                let ans3 = document.getElementsByName('color3')[0].value.trim().toLowerCase();

                if (ans1 == 'hồng' || ans1 == 'màu hồng') score++;
                if (ans2 == 'vàng' || ans2 == 'màu vàng') score++;
                if (ans3 == 'xanh dương' || ans3 == 'màu xanh dương' || ans3 == 'xanh nước biển') score++;

                alert('Bạn trả lời đúng ' + score + ' trên 3 câu hỏi.');
            }
            </script>
        </div>
    <?php else: ?>
        <!-- Hiển thị nội dung bình thường cho các bài học khác -->
        <div>
            <?php echo nl2br(htmlspecialchars_decode($bai_hoc['noi_dung'])); ?>
        </div>
    <?php endif; ?>
</main>

<footer>
    <p>Bản quyền &copy; 2024 - Trang web học tiếng Việt cho trẻ em</p>
</footer>

</body>
</html>