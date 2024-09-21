<?php
session_start();
include 'config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin trò chơi từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM tro_choi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tro_choi = $result->fetch_assoc();

if (!$tro_choi) {
    echo "Trò chơi không tồn tại.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $tro_choi['ten_tro_choi']; ?></title>
    <link rel="stylesheet" href="style.css">
    <!-- Thêm phông chữ từ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Coiny&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Coiny', cursive;
        }
        .game-content {
            text-align: center;
            margin: 20px;
        }
        .game-content img {
            max-width: 100%;
            height: auto;
        }
        .game-content input[type="text"] {
            width: 100px;
            margin-top: 10px;
            text-align: center;
            font-size: 18px;
            padding: 5px;
        }
        .game-content button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #FF69B4;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .game-content button:hover {
            background-color: #FF1493;
        }
        /* CSS cho trò chơi kéo thả */
        .drag-container {
            margin-top: 30px;
        }
        .drag-container h2 {
            margin-bottom: 20px;
        }
        .letters {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .letter {
            width: 60px;
            height: 60px;
            background-color: #FFB6C1;
            margin: 5px;
            font-size: 30px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            cursor: move;
            user-select: none;
        }
        .drop-area {
            margin-top: 20px;
            min-height: 60px;
            border: 2px dashed #FF69B4;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }
        /* CSS cho trò chơi Tô màu */
        .color-palette {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .color-palette div {
            width: 50px;
            height: 50px;
            margin: 5px;
            cursor: pointer;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
        .color-game-info {
            text-align: center;
            margin-top: 20px;
        }
        .exit-game {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #FF69B4;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .exit-game:hover {
            background-color: #FF1493;
        }
    </style>
</head>
<body class="wrapper">

<header>
    <div class="top-bar">
        <h1><?php echo $tro_choi['ten_tro_choi']; ?></h1>
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
    <?php
    // Trò chơi "Đố vui về số đếm"
    if ($tro_choi['ten_tro_choi'] == 'Đố vui về số đếm') {
    ?>
        <div class="game-content">
            <h2>Có bao nhiêu màn hình vi tính trong bức hình?</h2>
            <img src="images/may_tinh.jpg" alt="Hình ảnh màn hình vi tính">
            <br>
            <input type="text" name="answer_count" placeholder="Nhập số">
            <br>
            <button onclick="checkAnswerCount()">Kiểm tra kết quả</button>
        </div>
        <script>
            function checkAnswerCount() {
                let answer = document.getElementsByName('answer_count')[0].value.trim();
                if (answer == '2') {
                    alert('Chúc mừng! Bạn đã trả lời đúng.');
                } else {
                    alert('Rất tiếc! Đáp án chưa đúng. Hãy thử lại.');
                }
            }
        </script>
    <?php
    }
    // Trò chơi "Ghép chữ cái"
    elseif ($tro_choi['ten_tro_choi'] == 'Ghép chữ cái') {
    ?>
        <div class="game-content">
            <h2>Sắp xếp các chữ cái để tạo thành từ có nghĩa:</h2>
            <div class="drag-container">
                <div class="letters" id="letters">
                    <!-- Các chữ cái bị xáo trộn -->
                    <div class="letter" draggable="true" ondragstart="drag(event)" id="ma">M</div>
                    <div class="letter" draggable="true" ondragstart="drag(event)" id="a">A</div>
                    <div class="letter" draggable="true" ondragstart="drag(event)" id="y">Y</div>
                    <div class="letter" draggable="true" ondragstart="drag(event)" id="ba">B</div>
                    <div class="letter" draggable="true" ondragstart="drag(event)" id="ay">A</div>
                    <div class="letter" draggable="true" ondragstart="drag(event)" id="y2">Y</div>
                </div>
                <div class="drop-area" id="dropArea" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <!-- Khu vực thả chữ cái -->
                </div>
                <button onclick="checkWord()">Kiểm tra kết quả</button>
            </div>
        </div>
        <script>
            function allowDrop(ev) {
                ev.preventDefault();
            }

            function drag(ev) {
                ev.dataTransfer.setData("text", ev.target.id);
            }

            function drop(ev) {
                ev.preventDefault();
                var data = ev.dataTransfer.getData("text");
                var nodeCopy = document.getElementById(data).cloneNode(true);
                nodeCopy.id = data + "_dragged";
                ev.target.appendChild(nodeCopy);
                document.getElementById(data).style.visibility = "hidden";
            }

            function checkWord() {
                var letters = document.querySelectorAll('#dropArea .letter');
                var word = '';
                letters.forEach(function(letter) {
                    word += letter.textContent;
                });
                word = word.toUpperCase().replace(/\s+/g, '');
                if (word === 'MÁYBAY' || word === 'MAYBAY') {
                    alert('Chúc mừng! Bạn đã ghép đúng từ "Máy bay".');
                } else {
                    alert('Rất tiếc! Bạn chưa ghép đúng. Hãy thử lại.');
                }
            }
        </script>
    <?php
    }
    // Trò chơi "Tô màu"
    elseif ($tro_choi['ten_tro_choi'] == 'Tô màu') {
    ?>
        <div class="game-content">
            <h2>Chọn màu yêu thích để thay đổi giao diện trang chủ!</h2>
            <div class="color-palette">
                <div onclick="changeColor('#FFB6C1')" style="background-color: #FFB6C1;"></div>
                <div onclick="changeColor('#ADD8E6')" style="background-color: #ADD8E6;"></div>
                <div onclick="changeColor('#90EE90')" style="background-color: #90EE90;"></div>
                <div onclick="changeColor('#FFFFE0')" style="background-color: #FFFFE0;"></div>
                <div onclick="changeColor('#FFA07A')" style="background-color: #FFA07A;"></div>
            </div>
            <div class="color-game-info">
                <p>Nhấn vào màu sắc để thay đổi màu nền của trang chủ.</p>
            </div>
            <button class="exit-game" onclick="exitGame()">Thoát trò chơi</button>
        </div>
        <script>
            var originalColor = localStorage.getItem('originalColor') || '#FFFAF0';

            function changeColor(color) {
                document.body.style.backgroundColor = color;
                localStorage.setItem('selectedColor', color);
            }

            function exitGame() {
                localStorage.removeItem('selectedColor');
                window.location.href = 'index.php';
            }

            // Lưu màu nền ban đầu
            if (!localStorage.getItem('originalColor')) {
                localStorage.setItem('originalColor', document.body.style.backgroundColor);
            }

            // Kiểm tra và áp dụng màu nền đã chọn
            var selectedColor = localStorage.getItem('selectedColor');
            if (selectedColor) {
                document.body.style.backgroundColor = selectedColor;
            }
        </script>
    <?php
    }
    else {
        // Nếu là trò chơi khác, bạn có thể thêm nội dung tương ứng ở đây
        echo '<p>Trò chơi đang được cập nhật.</p>';
    }
    ?>
</main>

<footer>
    <p>Bản quyền &copy; 2024 - Trang web học tiếng Việt cho trẻ em</p>
</footer>

</body>
</html>