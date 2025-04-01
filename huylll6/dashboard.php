<?php
// Khởi động session để kiểm tra đăng nhập
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Kết nối cơ sở dữ liệu để lấy số liệu (giả định)
$conn = new mysqli("localhost", "username", "password", "database");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy số liệu tổng quan
$products_count = $conn->query("SELECT COUNT(*) FROM products")->fetch_row()[0];
$users_count = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$orders_count = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" width="device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        .dashboard-content {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        .dashboard-content h1 {
            font-family: 'Georgia', serif;
            font-size: 36px;
            margin-bottom: 30px;
            text-align: center;
            white-space: nowrap; /* Ngăn tách chữ "Bảng Điều Khiển" */
            word-break: keep-all;
            overflow-wrap: normal;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-box {
            background-color: #fff;
            padding: 20px;
            width: 30%;
            min-width: 200px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .stat-box h2 {
            font-family: 'Verdana', sans-serif;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .stat-box p {
            font-family: 'Arial', sans-serif;
            font-size: 32px;
            color: #A08963;
            font-weight: bold;
        }

        .btn-products {
            display: block;
            width: 250px;
            margin: 0 auto;
            padding: 15px;
            background-color: #A08963;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            text-align: center;
        }

        .btn-products:hover {
            background-color: #8c7352;
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

    <div class="dashboard-content">
        <h1>Bảng Điều Khiển</h1>
        <div class="stats">
            <div class="stat-box">
                <h2>Sản phẩm</h2>
                <p><?php echo $products_count; ?></p>
            </div>
            <div class="stat-box">
                <h2>Người dùng</h2>
                <p><?php echo $users_count; ?></p>
            </div>
            <div class="stat-box">
                <h2>Đơn hàng</h2>
                <p><?php echo $orders_count; ?></p>
            </div>
        </div>
        <a href="products/index.php" class="btn-products">Xem Danh Sách Sản Phẩm</a>
    </div>

    <footer>
        <p>© 2025 Bản quyền thuộc về [Tên Trang Web]. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>
</html>