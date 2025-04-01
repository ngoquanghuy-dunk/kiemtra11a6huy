<?php
// Khởi động session
session_start();

// Biến để lưu thông báo
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    
    // Kết nối cơ sở dữ liệu để kiểm tra email
    $conn = new mysqli("localhost", "username", "password", "database");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Kiểm tra email có tồn tại không
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Giả lập gửi email reset (thay bằng logic gửi email thực tế)
        $reset_token = bin2hex(random_bytes(16)); // Tạo token ngẫu nhiên
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $reset_token, $email);
        $stmt->execute();
        
        $message = "Yêu cầu reset mật khẩu đã được gửi đến $email. Vui lòng kiểm tra email của bạn.";
        // Thực tế: gửi email với liên kết reset như "example.com/reset.php?token=$reset_token"
    } else {
        $message = "Email không tồn tại trong hệ thống.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Mật Khẩu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #DBDBDB;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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

        .reset-content {
            max-width: 700px;
            margin: auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .reset-content h1 {
            font-family: 'Georgia', serif;
            font-size: 36px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-family: 'Verdana', sans-serif;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #A08963;
            color: white;
            border: none;
            border-radius: 5px;
            font-family: 'Arial', sans-serif;
            font-size: 20px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #8c7352;
        }

        .message {
            text-align: center;
            font-family: 'Verdana', sans-serif;
            font-size: 16px;
            color: #A08963;
            margin-bottom: 20px;
        }

        footer {
            background-color: #706D54;
            color: white;
            text-align: center;
            padding: 15px;
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
                <li><a href="login.php">Đăng Nhập</a></li>
                <li><a href="logout.php">Đăng Xuất</a></li>
            </ul>
        </nav>
    </header>

    <div class="reset-content">
        <h1>Reset Mật Khẩu</h1>
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="reset_password.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">
            </div>
            <button type="submit" class="btn-submit">Gửi Yêu Cầu</button>
        </form>
    </div>

    <footer>
        <p>© 2025 Bản quyền thuộc về [Tên Trang Web]. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>
</html>