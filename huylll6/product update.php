<?php
// Khởi động session
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "username", "password", "database");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID sản phẩm từ URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    header("Location: index.php"); // Nếu không có ID, quay lại danh sách
    exit();
}

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT name, price, description FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header("Location: index.php"); // Nếu không tìm thấy sản phẩm, quay lại danh sách
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật Sản Phẩm</title>
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

        .update-content {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .update-content h1 {
            font-family: 'Georgia', serif;
            font-size: 36px;
            margin-bottom: 30px;
            text-align: center;
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

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
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

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            color: #A08963;
            text-decoration: none;
        }

        .back-link:hover {
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
                <li><a href="../index.php">Trang Chủ</a></li>
                <li><a href="../about.php">Giới Thiệu</a></li>
                <li><a href="../contact.php">Liên Hệ</a></li>
                <li><a href="../login.php">Đăng Nhập</a></li>
                <li><a href="../logout.php">Đăng Xuất</a></li>
            </ul>
        </nav>
    </header>

    <div class="update-content">
        <h1>Cập nhật Sản Phẩm</h1>
        <form action="update-product.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="name">Tên</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <button type="submit" class="btn-submit">Cập nhật</button>
        </form>
        <a href="index.php" class="back-link">Quay lại Danh Sách Sản Phẩm</a>
    </div>

    <footer>
        <p>© 2025 Bản quyền thuộc về [Tên Trang Web]. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>
</html>