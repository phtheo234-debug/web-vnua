<?php
session_start();
require_once "../connect.php";

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_dang_nhap = trim($_POST["ten_dang_nhap"] ?? "");
    $mat_khau = $_POST["mat_khau"] ?? "";

    $sql = "SELECT * FROM admin WHERE ten_dang_nhap = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ten_dang_nhap]);

    $admin = $stmt->fetch();

    if ($admin && $mat_khau == $admin["mat_khau"]) {
        session_regenerate_id(true);

        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_name"] = $admin["ten_dang_nhap"];

        header("Location: home.php");
        exit;
    } else {
        $thong_bao = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Login-ad</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">
    <h2>Đăng nhập - Chủ tiệm</h2>

    <p class="error"><?= htmlspecialchars($thong_bao) ?></p>

    <form method="POST">
        <label>Tên đăng nhập</label>
        <input type="text" name="ten_dang_nhap" required>
        <label>Mật khẩu</label>
        <input type="password" name="mat_khau" required>
        <button type="submit">Đăng nhập</button>
    </form>

    <p><a href="../index.php">Về trang chủ</a></p>
</div>
</body>
</html>