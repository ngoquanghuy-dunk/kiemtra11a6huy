<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Xác thực tạm thời (thay bằng kiểm tra trong cơ sở dữ liệu)
    if ($username === 'admin' && $password === 'matkhau') {
        $_SESSION['user'] = $username;
        header('Location: index.php'); // Chuyển hướng đến trang chủ
        exit();
    } else {
        $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="POST" action="">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" required><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
