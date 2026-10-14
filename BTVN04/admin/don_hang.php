<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../connect.php";

$ds_trang_thai = [
    "Chờ xác nhận",
    "Đang chuẩn bị",
    "Đang giao",
    "Hoàn thành",
    "Đã hủy"
];

$thong_bao = "";

// Cập nhật trạng thái đơn hàng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"] ?? "";
    $trang_thai = $_POST["trang_thai"] ?? "";

    if (ctype_digit((string)$id) && $id != "0" && in_array($trang_thai, $ds_trang_thai, true)) {
        $sql = "UPDATE don_hang
                SET trang_thai = ?
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$trang_thai, $id]);

        header("Location: don_hang.php");
        exit;
    } else {
        $thong_bao = "Thông tin cập nhật không hợp lệ!";
    }
}

// Lấy danh sách đơn hàng
$sql = "SELECT * FROM don_hang ORDER BY ngay_dat DESC";
$stmt = $pdo->query($sql);
$ds_don_hang = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h1>Quản lý đơn hàng</h1>

    <p>
        <a href="home.php">Trang quản trị</a> |
        <a href="mon.php">Quản lý món</a> |
        <a href="thong_ke.php">Thống kê</a> |
        <a href="logout.php">Đăng xuất</a>
    </p>

    <p style="color:red;"><?= htmlspecialchars($thong_bao) ?></p>

    <?php if (count($ds_don_hang) == 0) { ?>
        <p>Chưa có đơn hàng nào.</p>
    <?php } else { ?>
        <?php foreach ($ds_don_hang as $don) { ?>
            <div class="order-box">
                <h3>Đơn hàng #<?= $don["id"] ?></h3>
                <p><strong>Khách hàng:</strong> <?= htmlspecialchars($don["ten_khach"]) ?></p>
                <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($don["so_dien_thoai"]) ?></p>
                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($don["dia_chi"]) ?></p>
                <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($don["ngay_dat"]) ?></p>
                <p><strong>Tổng tiền:</strong> <?= number_format($don["tong_tien"]) ?></p>
                <p><strong>Chi tiết món:</strong></p>

                <?php
                $sql_ct = "SELECT ten_mon, so_luong, don_gia FROM chi_tiet_don_hang WHERE id_don_hang = ?";
                $stmt_ct = $pdo->prepare($sql_ct);
                $stmt_ct->execute([$don["id"]]);
                $ds_chi_tiet = $stmt_ct->fetchAll();
                ?>

                <ul>
                    <?php foreach ($ds_chi_tiet as $ct) { ?>
                        <li><?= htmlspecialchars($ct["ten_mon"]) ?> - <?= $ct["so_luong"] ?> cốc x <?= number_format($ct["don_gia"]) ?></li>
                    <?php } ?>
                </ul>

                <form method="POST">
                    <input type="hidden" name="id" value="<?= $don["id"] ?>">

                    <label>Trạng thái đơn hàng:</label>
                    <select name="trang_thai">
                        <?php foreach ($ds_trang_thai as $tt) { ?>
                            <option value="<?= htmlspecialchars($tt) ?>"<?= $don["trang_thai"] == $tt ? "selected" : "" ?>><?= htmlspecialchars($tt) ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit">Cập nhật trạng thái</button>
                </form>
            </div>
        <?php } ?>
    <?php } ?>
</div>
</body>
</html>