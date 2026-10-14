<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../connect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: mon.php");
    exit;
}

$id = $_POST["id"] ?? "";

if (!ctype_digit((string)$id) || $id == "0") {
    header("Location: mon.php");
    exit;
}

$sql = "DELETE FROM mon WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: mon.php");
exit;
?>