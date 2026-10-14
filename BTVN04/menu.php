<?php
require_once "connect.php";

$tu_khoa = trim($_GET["tu_khoa"] ?? "");

$sql = "SELECT * FROM mon
        WHERE ten_mon LIKE ?
        ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(["%" . $tu_khoa . "%"]);

$dsMon = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Thực đơn đồ uống</h1>
    <nav>
        <a href="index.php">Trang chủ</a> |
        <a href="menu.php">Thực đơn</a> |
        <a href="tra_cuu.php">Tra cứu đơn hàng</a>
    </nav>
    <form method="GET">
        <label for="tu_khoa">Tìm đồ uống</label>
        <input type="text" id="tu_khoa" name="tu_khoa" placeholder="Nhập tên món..." value="<?= htmlspecialchars($tu_khoa) ?>">
        <button type="submit">Tìm kiếm</button>
    </form>
    <h2>Kết quả tìm được</h2>

    <?php if (count($dsMon) > 0): ?>
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
    <?php else: ?>
        <p>Không tìm ra đồ uống phù hợp</p>
    <?php endif; ?>
</div>
</body>
</html>
