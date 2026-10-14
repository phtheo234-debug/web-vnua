<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../connect.php";

// Đếm món
$so_mon = $pdo->query(
    "SELECT COUNT(*) FROM mon"
)->fetchColumn();

// Đếm đơn hàng
$so_don = $pdo->query(
    "SELECT COUNT(*) FROM don_hang"
)->fetchColumn();

// Đếm đơn chờ xử lý
$so_don_cho = $pdo->query(
    "SELECT COUNT(*) FROM don_hang
     WHERE trang_thai = 'Chờ xác nhận'"
)->fetchColumn();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ quản trị</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">
    <h1>Quản trị tiệm trà sữa</h1>
    <p>Xin chào, <?= htmlspecialchars($_SESSION["admin_name"]) ?> !</p>

    <div class="stats">
        <div class="stat">
            <h3>Số món</h3>
            <p><?= $so_mon ?></p>
        </div>
        <div class="stat">
            <h3>Tổng đơn hàng</h3>
            <p><?= $so_don ?></p>
        </div>
        <div class="stat">
            <h3>Đơn chờ xác nhận</h3>
            <p><?= $so_don_cho ?></p>
        </div>
    </div>

    <h2>Chức năng quản lý</h2>
    <p><a href="mon.php">Quản lý món</a></p>
    <p><a href="don_hang.php">Quản lý đơn hàng</a></p>
    <p><a href="thong_ke.php">Thống kê doanh thu</a></p>
    <p><a href="logout.php">Đăng xuất</a></p>
    <p><a href="../index.php">Xem trang khách hàng</a></p>
</div>
</body>
</html>