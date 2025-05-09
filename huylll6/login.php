<?php
session_start();

// Nếu đã đăng nhập, chuyển hướng đến dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli("localhost", "username", "password", "database");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Kiểm tra thông tin đăng nhập
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Lưu thông tin vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // Chuyển hướng đến dashboard
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
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
    <title>Đăng Nhập</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #DBDBDB;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .login-content {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .login-content h1 {
            font-family: 'Georgia', serif;
            font-size: 36px;
            margin-bottom: 30px;
            text-align: center;
        }

        .error-message {
            font-family: 'Verdana', sans-serif;
            font-size: 16px;
            color: #706D54;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-family: 'Verdana', sans-serif;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
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
            font-size: 18px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #8c7352;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            color: #A08963;
            text-decoration: none;
        }

        .form-footer a:hover {
            color: #8c7352;
        }

        footer {
            background-color: #706D54;
            color: white;
            text-align: center;
            padding: 15px;
            width: 100%;
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            margin-top: auto;
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

    <div class="login-content">
        <h1>Đăng Nhập</h1>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">Đăng Nhập</button>
        </form>

        <div class="form-footer">
            <a href="reset_password.php">Quên mật khẩu?</a> | 
            <a href="register.php">Đăng ký</a>
        </div>
    </div>

    <footer>
        <p>© 2025 Bản quyền thuộc về [Tên Trang Web]. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>
</html>
