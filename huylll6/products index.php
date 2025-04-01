<?php
// Khởi động session để kiểm tra đăng nhập
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Kết nối cơ sở dữ liệu để lấy danh sách sản phẩm
$conn = new mysqli("localhost", "username", "password", "database");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
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

        .products-content {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        .products-content h1 {
            font-family: 'Georgia', serif;
            font-size: 36px;
            margin-bottom: 30px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            font-family: 'Verdana', sans-serif;
            font-size: 16px;
        }

        th {
            background-color: #A08963;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            font-family: 'Arial', sans-serif;
            font-size: 14px;
        }

        .btn-edit {
            background-color: #A08963;
            color: white;
            margin-right: 5px;
        }

        .btn-delete {
            background-color: #706D54;
            color: white;
        }

        .btn-add {
            display: block;
            width: 200px;
            margin: 30px auto 0;
            padding: 15px;
            background-color: #A08963;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            text-align: center;
        }

        .btn-add:hover {
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
                <li><a href="../index.php">Trang Chủ</a></li>
                <li><a href="../about.php">Giới Thiệu</a></li>
                <li><a href="../contact.php">Liên Hệ</a></li>
                <li><a href="../login.php">Đăng Nhập</a></li>
                <li><a href="../logout.php">Đăng Xuất</a></li>
            </ul>
        </nav>
    </header>

    <div class="products-content">
        <h1>Danh Sách Sản Phẩm</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit">Sửa</a>
                            <a href="delete-product.php?id=<?php echo $row['id']; ?>" class="action-btn btn-delete">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="add-product.php" class="btn-add">Thêm Sản Phẩm</a>
    </div>

    <footer>
        <p>© 2025 Bản quyền thuộc về [Tên Trang Web]. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>