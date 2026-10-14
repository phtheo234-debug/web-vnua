<?php
session_start();
require_once "connect.php";

$thong_bao = "";

// Lấy danh sách món
$stmt = $pdo->query("SELECT * FROM mon ORDER BY id");
$dsMon = $stmt->fetchAll();

// Lấy id món chọn từ menu
$id_chon = (int)($_GET["id"] ?? 0);

// Đặt hàng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_khach = trim($_POST["ten_khach"] ?? "");
    $so_dien_thoai = trim($_POST["so_dien_thoai"] ?? "");
    $dia_chi = trim($_POST["dia_chi"] ?? "");
    $dsSoLuong = $_POST["so_luong"] ?? [];

    if ($ten_khach == "" || $so_dien_thoai == "" || $dia_chi == "") {
        $thong_bao = "Vui long nhap day du thong tin!";
    } elseif (!preg_match('/^0[0-9]{9}$/', $so_dien_thoai)) {
        $thong_bao = "Số điện thoại phải bắt đầu bằng số 0 và có đúng 10 chữ số!";
    } else {
        try {
            $dsDatHang = [];
            $tong_tien = 0;

            // Lấy giá tiền lưu từ database
            $stmtMon = $pdo->prepare(
                "SELECT id, ten_mon, gia FROM mon WHERE id = ?"
            );
            foreach ($dsSoLuong as $id => $so_luong) {
                $id = (int)$id;
                $so_luong = filter_var($so_luong, FILTER_VALIDATE_INT);

                if ($so_luong === false || $so_luong < 0) {
                    throw new Exception("Số lượng đặt phải >0!");
                }

                if ($so_luong == 0) {
                    continue;
                }

                $stmtMon->execute([$id]);
                $mon = $stmtMon->fetch();

                if (!$mon) {
                    throw new Exception("Không tồn tại một số món!!!");
                }

                $thanh_tien = $mon["gia"] * $so_luong;
                $tong_tien += $thanh_tien;

                $dsDatHang[] = [
                    "id_mon" => $mon["id"],
                    "ten_mon" => $mon["ten_mon"],
                    "so_luong" => $so_luong,
                    "don_gia" => $mon["gia"]
                ];
            }

            if (count($dsDatHang) == 0) {
                throw new Exception("Bạn chưa đặt món!");
            }

            // Lưu đơn và chi tiết đơn vào cùng trans
            $pdo->beginTransaction();

            $sql = "INSERT INTO don_hang(ten_khach, so_dien_thoai, dia_chi, tong_tien) VALUES (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $ten_khach,
                $so_dien_thoai,
                $dia_chi,
                $tong_tien
            ]);

            $id_don_hang = $pdo->lastInsertId();

            $sqlCT = "INSERT INTO chi_tiet_don_hang(id_don_hang, id_mon, ten_mon, so_luong, don_gia) VALUES (?, ?, ?, ?, ?)";

            $stmtCT = $pdo->prepare($sqlCT);

            foreach ($dsDatHang as $mon) {
                $stmtCT->execute([
                    $id_don_hang,
                    $mon["id_mon"],
                    $mon["ten_mon"],
                    $mon["so_luong"],
                    $mon["don_gia"]
                ]);
            }
            $pdo->commit();

            // Lưu mã món để hiển thị kết quả
            $_SESSION["don_vua_dat"] = $id_don_hang;
            header("Location: dat_hang.php?thanh_cong=1");//1true0false
            exit;

        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $thong_bao = $e instanceof PDOException
                ? "Không lưu được, thử lại!"
                : $e->getMessage();
        }
    }
}

// Hiển thị kq khi đặt
$id_don_moi = 0;

if (isset($_GET["thanh_cong"])) {
    $id_don_moi = (int)($_SESSION["don_vua_dat"] ?? 0);

    if ($id_don_moi > 0) {
        unset($_SESSION["don_vua_dat"]);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Đặt hàng</h1>
    <nav>
        <a href="index.php">Trang chủ</a> |
        <a href="menu.php">Thực đơn</a> |
        <a href="tra_cuu.php">Tra cứu đơn hàng</a>
    </nav>

    <?php if ($id_don_moi > 0): ?>
        <h2>Đặt hàng thành công!</h2>
        <p>Mã đơn hàng của bạn là:
            <strong><?= $id_don_moi ?></strong>
        </p>
        <p>Lưu MÃ ĐƠN HÀNG và SĐT để tra cứu</p>
        <a href="tra_cuu.php">Tra cứu đơn hàng</a>
    <?php else: ?>
        <?php if ($thong_bao != ""): ?>
            <p class="error"><?= htmlspecialchars($thong_bao) ?></p>
        <?php endif; ?>
        <form method="POST">
            <h2>Chọn đồ uống</h2>
            <?php foreach ($dsMon as $mon): ?>
                <div class="drink">
                    <h3><?= htmlspecialchars($mon["ten_mon"]) ?></h3>

                    <p>Giá: <?= number_format($mon["gia"]) ?></p>

                    <label>Số lượng:
                        <input type="number" name="so_luong[<?= $mon["id"] ?>]" min="0" step="1" value="<?= $id_chon == $mon["id"] ? 1 : 0 ?>">
                    </label>
                </div>
            <?php endforeach; ?>

            <h2>Thông tin nhận hàng</h2>

            <label>Họ và tên</label>
            <input type="text" name="ten_khach" maxlength="100" required value="<?= htmlspecialchars($_POST["ten_khach"] ?? "") ?>">

            <label>Số điện thoại</label>
            <input type="tel" name="so_dien_thoai" length="10" required value="<?= htmlspecialchars($_POST["so_dien_thoai"] ?? "") ?>">

            <label>Địa chỉ nhận hàng</label>
            <textarea name="dia_chi" maxlength="255" required><?= htmlspecialchars($_POST["dia_chi"] ?? "") ?></textarea>

            <button type="submit">Xác nhận đặt hàng</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>