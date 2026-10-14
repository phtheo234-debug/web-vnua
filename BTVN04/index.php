<?php
require_once "connect.php";

$sql = "SELECT * FROM mon ORDER BY id DESC";
$stmt = $pdo->query($sql);
$dsMon = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạ Phương Thảo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Tiệm trà sữa</h1>
    <nav>
        <a href="index.php">Trang chủ</a> |
        <a href="menu.php">Thực đơn</a> |
        <a href="tra_cuu.php">Tra cứu đơn hàng</a> |
        <a href="admin/login.php">Quản trị</a>
    </nav>
    <h2>Menu</h2>

    <div class="menu">
        <?php foreach ($dsMon as $mon): ?>
            <div class="drink">
                <?php if (!empty($mon["hinh_anh"])): ?>
                    <img src="<?= htmlspecialchars($mon["hinh_anh"]) ?>" alt="<?= htmlspecialchars($mon["ten_mon"]) ?>">
                <?php endif; ?>

                <h3><?= htmlspecialchars($mon["ten_mon"]) ?></h3>

                <p><?= htmlspecialchars($mon["mo_ta"] ?? "") ?></p>

                <p class="price"><?= number_format($mon["gia"]) ?></p>

                <a href="dat_hang.php?id=<?= (int)$mon["id"] ?>">Đặt món</a>
            </div>
        <?php endforeach; ?>
    </div>

    <p><a href="menu.php">Xem toàn bộ thực đơn</a></p>
</div>
</body>
</html>
