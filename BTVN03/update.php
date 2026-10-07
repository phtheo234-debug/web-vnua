<?php
ob_start();
require_once "connect.php";
ob_end_clean();

$id = $_GET["id"];
$tenSanPham = $_POST["ten_san_pham"];
$gia = $_POST["gia"];
$soLuong = $_POST["so_luong"];
$moTa = $_POST["mo_ta"];

$sql = "UPDATE san_pham SET ten_san_pham = ?,gia = ?,so_luong = ?,mo_ta = ? WHERE id = ?";

$lsql = $pdo->prepare($sql);

$lsql->execute([
    $tenSanPham,
    $gia,
    $soLuong,
    $moTa,
    $id
]);

header("Location: index.php");
exit;
?>