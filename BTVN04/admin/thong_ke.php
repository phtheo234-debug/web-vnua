<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../connect.php";

$loai = $_GET["loai"] ?? "thang";

if (!in_array($loai, ["tuan", "thang"], true)) {
    $loai = "thang";
}

if ($loai == "tuan") {
    // Thống kê tuần hiện tại
    $sql = "SELECT
                COUNT(*) AS tong_don,
                SUM(trang_thai = 'Hoàn thành') AS don_hoan_thanh,
                SUM(IF(trang_thai = 'Hoàn thành', tong_tien, 0)) AS doanh_thu
            FROM don_hang
            WHERE WEEK(ngay_dat, 1) = WEEK(CURDATE(), 1)
            AND YEAR(ngay_dat) = YEAR(CURDATE())";
} else {
    // Thống kê tháng hiện tại
    $sql = "SELECT
                COUNT(*) AS tong_don,
                SUM(trang_thai = 'Hoàn thành') AS don_hoan_thanh,
                SUM(IF(trang_thai = 'Hoàn thành', tong_tien, 0)) AS doanh_thu
            FROM don_hang
            WHERE MONTH(ngay_dat) = MONTH(CURDATE())
            AND YEAR(ngay_dat) = YEAR(CURDATE())";
}

$stmt = $pdo->query($sql);
$tk = $stmt->fetch();

$tong_don = $tk["tong_don"] ?? 0;
$don_hoan_thanh = $tk["don_hoan_thanh"] ?? 0;
$doanh_thu = $tk["doanh_thu"] ?? 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h1>Thống kê đơn hàng</h1>

    <p>
        <a href="home.php">Trang quản trị</a> |
        <a href="mon.php">Quản lý món</a> |
        <a href="don_hang.php">Quản lý đơn hàng</a> |
        <a href="logout.php">Đăng xuất</a>
    </p>

    <h3>Chọn thời gian thống kê</h3>

    <p>
        <a href="thong_ke.php?loai=tuan">Thống kê tuần này</a> |
        <a href="thong_ke.php?loai=thang">Thống kê tháng này</a>
    </p>

    <h2><?= $loai == "tuan" ? "Kết quả tuần này" : "Kết quả tháng này" ?></h2>

    <div class="stats">
        <div class="stat">
            <h3>Tổng số đơn</h3>
            <p><?= $tong_don ?></p>
        </div>
        <div class="stat">
            <h3>Đơn hoàn thành</h3>
            <p><?= $don_hoan_thanh ?></p>
        </div>
        <div class="stat">
            <h3>Doanh thu</h3>
            <p><?= number_format($doanh_thu)?></p>
        </div>
    </div>
</div>
</body>
</html>