<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../connect.php";

$sql = "SELECT * FROM mon ORDER BY id DESC";
$stmt = $pdo->query($sql);
$ds_mon = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý menu</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h1>Quản lý menu</h1>

    <p>
        <a href="home.php">Trang quản trị</a> |
        <a href="them_mon.php">+ Thêm món mới</a> |
        <a href="don_hang.php">Quản lý đơn hàng</a> |
        <a href="logout.php">Đăng xuất</a>
    </p>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên món</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Ảnh</th>
            <th>Thao tác</th>
        </tr>

        <?php foreach ($ds_mon as $mon) { ?>
            <tr>
                <td><?= $mon["id"] ?></td>
                <td><?= htmlspecialchars($mon["ten_mon"]) ?></td>
                <td><?= number_format($mon["gia"]) ?></td>
                <td><?= htmlspecialchars($mon["mo_ta"] ?? "") ?></td>
                <td>
                    <?php if (!empty($mon["hinh_anh"])) { ?>
                        <img src="../<?= htmlspecialchars($mon["hinh_anh"]) ?>" alt="Ảnh món" style="width:80px; height:70px; object-fit:cover;">
                    <?php } else { ?>
                        Chưa có ảnh
                    <?php } ?>
                </td>
                <td>
                    <a href="sua_mon.php?id=<?= $mon["id"] ?>">Sửa</a>
                    <form action="xoa_mon.php" method="POST"
                          onsubmit="return confirm('Bạn có chắc muốn xóa món này?');">
                        <input type="hidden" name="id" value="<?= $mon["id"] ?>">
                        <button type="submit" class="btn-delete">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php if (count($ds_mon) == 0) { ?>
        <p>Chưa có món nào trong menu.</p>
    <?php } ?>
</div>
</body>
</html>