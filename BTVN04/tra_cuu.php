<?php
require_once "connect.php";

$so_dien_thoai = trim($_GET["so_dien_thoai"] ?? "");
$dsDonHang = [];

if ($so_dien_thoai != "") {
    $sql = "SELECT * FROM don_hang
            WHERE so_dien_thoai = ?
            ORDER BY ngay_dat DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$so_dien_thoai]);
    $dsDonHang = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Tra cứu đơn hàng</h1>
    <nav>
        <a href="index.php">Trang chủ</a> |
        <a href="menu.php">Thực đơn</a> |
        <a href="dat_hang.php">Đặt hàng</a>
    </nav>

    <form method="GET">
        <label>Nhập số điện thoại đặt hàng</label>

        <input type="tel" name="so_dien_thoai" length="10" required value="<?= htmlspecialchars($so_dien_thoai) ?>" placeholder="Ví dụ: 0912345678">

        <button type="submit">Tra cứu</button>
    </form>

    <?php if ($so_dien_thoai != ""): ?>
        <h2>Kết quả tra cứu</h2>
        <?php if (count($dsDonHang) > 0): ?>
            <?php foreach ($dsDonHang as $don): ?>
                <div class="drink">
                    <h3>Đơn hàng #<?= (int)$don["id"] ?></h3>
                    <p>Ngày đặt: <?= htmlspecialchars($don["ngay_dat"]) ?></p>
                    <p>Tổng tiền:
                        <strong><?= number_format($don["tong_tien"]) ?></strong>
                    </p>
                    <p>Trạng thái:
                        <strong><?= htmlspecialchars($don["trang_thai"]) ?></strong>
                    </p>
                    <h4>Chi tiết đồ uống</h4>
                    <?php
                    $sqlCT = "SELECT ten_mon, so_luong, don_gia FROM chi_tiet_don_hang WHERE id_don_hang = ?";

                    $stmtCT = $pdo->prepare($sqlCT);
                    $stmtCT->execute([$don["id"]]);
                    $dsChiTiet = $stmtCT->fetchAll();
                    ?>

                    <ul>
                        <?php foreach ($dsChiTiet as $ct): ?>
                            <li><?= htmlspecialchars($ct["ten_mon"]) ?> - <?= (int)$ct["so_luong"] ?> cốc x <?= number_format($ct["don_gia"]) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p>Không tìm thấy đơn hàng với số điện thoại này.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>