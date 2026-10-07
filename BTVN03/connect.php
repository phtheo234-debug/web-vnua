<?php
$dsn = "mysql:host=127.0.0.1;port=3306;dbname=quanlysp;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $dsSanPham = $pdo->query("SELECT id, ten_san_pham, gia, so_luong, mo_ta FROM san_pham ORDER BY id")->fetchAll();
    echo json_encode($dsSanPham);
} catch (PDOException $e) {
    die("Khong ket noi duoc databasde: " . $e->getMessage()
    . "\nHay kiem tra: MySQL da bat chua? Chay file database.sql chua?Mat khau trong config.php da dung chua?");
}
?>