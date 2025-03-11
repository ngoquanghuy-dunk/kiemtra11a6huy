<?php
// register.php
session_start();

$errors = [];
$username = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy và xử lý dữ liệu đầu vào
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $repeat_password = htmlspecialchars(trim($_POST['repeat-password']));

    // Kiểm tra dữ liệu đầu vào
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

    // Nếu không có lỗi, xử lý đăng ký thành công
    if (empty($errors)) {
        // Lưu thông tin người dùng vào cơ sở dữ liệu (giả sử thành công)
        $_SESSION['success'] = "Chào mừng $username, bạn đã đăng ký thành công!";
        $username = "";
        $email = "";
        // Không lưu mật khẩu thô, cần mã hóa (password_hash)
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./reset.css" />
    <link rel="stylesheet" href="./style.css" />
    <style>
        body {
            background-color: #556b2f; /* Olive */
            color: #8b0000; /* Dark Red (Rust) */
            font-family: Arial, sans-serif;
        }
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #form-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2.active {
            color: #8b0000; /* Rust */
        }
        h2.inactive {
            color: #556b2f; /* Olive */
        }
        .success-message {
            color: #556b2f;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .error-message {
            color: #8b0000;
            font-size: 0.9em;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #556b2f;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #8b0000;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #556b2f;
        }
        a {
            color: #8b0000;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <title>Register Page</title>
</head>
<body>
    <div class="wrapper fade-in-down">
        <div id="form-content">
            <!-- Tabs Titles -->
            <a href="/login.php">
                <h2 class="inactive underline-hover">Đăng nhập</h2>
            </a>
            <a href="/register.php">
                <h2 class="active">Đăng ký</h2>
            </a>

            <!-- Icon -->
            <div class="fade-in first">
                <img src="avatar.png" id="avatar" alt="User Icon" />
            </div>

            <!-- Hiển thị thông báo thành công -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="">
                <input
                    type="text"
                    id="username"
                    class="fade-in first"
                    name="username"
                    placeholder="Họ tên"
                    value="<?php echo htmlspecialchars($username); ?>"
                />
                <?php if (isset($errors['username'])): ?>
                    <div class="error-message"> <?php echo $errors['username']; ?> </div>
                <?php endif; ?>

                <input
                    type="email"
                    id="Email"
                    class="fade-in second"
                    name="email"
                    placeholder="Email"
                    value="<?php echo htmlspecialchars($email); ?>"
                />
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"> <?php echo $errors['email']; ?> </div>
                <?php endif; ?>

                <input
                    type="password"
                    id="password"
                    class="fade-in third"
                    name="password"
                    placeholder="Mật khẩu"
                />
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"> <?php echo $errors['password']; ?> </div>
                <?php endif; ?>

                <input
                    type="password"
                    id="repeat-password"
                    class="fade-in fourth"
                    name="repeat-password"
                    placeholder="Xác nhận mật khẩu"
                />
                <?php if (isset($errors['repeat-password'])): ?>
                    <div class="error-message"> <?php echo $errors['repeat-password']; ?> </div>
                <?php endif; ?>

                <input type="submit" class="fade-in five" value="Đăng ký" />
            </form>

            <!-- Remind Password -->
            <div id="form-footer">
                <a class="underline-hover" href="#">Quên mật khẩu?</a>
            </div>
        </div>
    </div>
</body>
</html>
