<?php
ob_start();
require_once "connect.php";
ob_end_clean();

$tenSanPham = $_POST["ten_san_pham"];
$gia = $_POST["gia"];
$soLuong = $_POST["so_luong"];
$moTa = $_POST["mo_ta"];

$sql = "INSERT INTO san_pham(ten_san_pham, gia, so_luong, mo_ta) VALUES (?, ?, ?, ?)";

$lsql = $pdo->prepare($sql);

$lsql->execute([
    $tenSanPham,
    $gia,
    $soLuong,
    $moTa
]);

header("Location: index.php");
exit;
?>