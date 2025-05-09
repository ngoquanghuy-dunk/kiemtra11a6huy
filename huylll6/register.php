<?php
session_start();

$errors = [];
$username = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $repeat_password = htmlspecialchars(trim($_POST['repeat-password']));

    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập họ tên.";
    }

    if (empty($email)) {
        $errors['email'] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không đúng định dạng.";
    }

    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    if ($password !== $repeat_password) {
        $errors['repeat-password'] = "Mật khẩu xác nhận không khớp.";
    }

    if (empty($errors)) {
        // Kết nối cơ sở dữ liệu để lưu thông tin
        $conn = new mysqli("localhost", "username", "password", "database");
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Mã hóa mật khẩu trước khi lưu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Chào mừng $username, bạn đã đăng ký thành công!";
            $username = "";
            $email = "";
        } else {
            $errors['database'] = "Đăng ký thất bại. Vui lòng thử lại.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
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

        .register-content {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .register-content h1 {
            font-family: 'Georgia', serif;
            font-size: 36px;
            margin-bottom: 30px;
            text-align: center;
        }

        .success-message {
            text-align: center;
            font-family: 'Verdana', sans-serif;
            font-size: 16px;
            color: #A08963;
            margin-bottom: 20px;
        }

        .error-message {
            font-family: 'Verdana', sans-serif;
            font-size: 14px;
            color: #706D54;
            margin-top: 5px;
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

    <div class="register-content">
        <h1>Đăng Ký</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors['database'])): ?>
            <div class="error-message"><?php echo $errors['database']; ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Họ tên</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                <?php if (isset($errors['username'])): ?>
                    <div class="error-message"><?php echo $errors['username']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="repeat-password">Xác nhận mật khẩu</label>
                <input type="password" id="repeat-password" name="repeat-password" required>
                <?php if (isset($errors['repeat-password'])): ?>
                    <div class="error-message"><?php echo $errors['repeat-password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-submit">Đăng Ký</button>
        </form>

        <div class="form-footer">
            <a href="reset_password.php">Quên mật khẩu?</a>
        </div>
    </div>

    <footer>
        <p>© 2025 Bản quyền thuộc về [Tên Trang Web]. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>
</html>