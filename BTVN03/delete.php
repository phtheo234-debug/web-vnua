<?php
ob_start();
require_once "connect.php";
ob_end_clean();

$id = $_GET["id"];
$sql = "DELETE FROM san_pham WHERE id = ?";

$lsql = $pdo->prepare($sql);

$lsql->execute([$id]);

header("Location: index.php");
exit;
?>