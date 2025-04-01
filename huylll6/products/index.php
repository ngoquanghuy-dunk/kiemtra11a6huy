<?php
// Khởi động session để kiểm tra trạng thái đăng nhập
session_start();

// Biến để lưu thông báo chào mừng
$welcome_message = "Chào mừng đến với trang web của chúng tôi";
$intro_text = "Giới thiệu ngắn gọn về trang web của bạn tại đây.";

// Nếu người dùng đã đăng nhập, chuyển hướng đến dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #DBDBDB;
        }

        header {
            background-color: #A08963;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 22px;
            font-weight: bold;
            font-family: 'Helvetica', sans-serif;
        }

        nav ul li a:hover {
            color: #f0f0f0;
        }

        .main-content {
            text-align: center;
            padding: 50px;
        }

        .main-content h1 {
            font-family: 'Georgia', serif;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .main-content p {
            font-family: 'Verdana', sans-serif;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            text-decoration: none;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-register {
            background-color: #A08963;
            color: white;
        }

        .btn-login {
            background-color: #706D54;
            color: white;
        }

        footer {
            background-color: #706D54;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-family: 'Times New Roman', serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <img src="SU8HhT2n6tL-p-_.png" alt="Logo" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="about.php">Giới Thiệu</a></li>
                <li><a href="contact.php">Liên Hệ</a></li>
                <!-- Hiển thị nút đăng nhập và đăng ký nếu người dùng chưa đăng nhập -->
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="login.php">Đăng Nhập</a></li>
                    <li><a href="register.php">Đăng Ký</a></li>
                <?php else: ?>
                    <!-- Nếu đã đăng nhập, không hiển thị nút đăng nhập và đăng ký -->
                    <li><a href="logout.php">Đăng Xuất</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="main-content">
        <h1><?php echo $welcome_message; ?></h1>
        <p><?php echo $intro_text; ?></p>

        <!-- Hiển thị nút Đăng Ký và Đăng Nhập nếu người dùng chưa đăng nhập -->
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn btn-register">Đăng Ký</a>
            <a href="login.php" class="btn btn-login">Đăng Nhập</a>
        <?php endif; ?>
    </div>

    <footer>
        <p>© 2025 Bản quyền thuộc về [Tên Trang Web]. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>
</html>
