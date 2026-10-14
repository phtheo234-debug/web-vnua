<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../connect.php";

$id = $_GET["id"] ?? "";

if (!ctype_digit((string)$id) || $id == "0") {
    header("Location: mon.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM mon WHERE id = ?");
$stmt->execute([$id]);
$mon = $stmt->fetch();

if (!$mon) {
    die("Không tìm thấy món!");
}

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_mon = trim($_POST["ten_mon"] ?? "");
    $gia = $_POST["gia"] ?? "";
    $mo_ta = trim($_POST["mo_ta"] ?? "");

    // Giữ ảnh cũ nếu không chọn ảnh mới
    $hinh_anh = $mon["hinh_anh"] ?? "";

    if ($ten_mon == "" || !is_numeric($gia) || $gia <= 0) {
        $thong_bao = "Vui lòng nhập tên món và giá hợp lệ!";
    } else {
        if (isset($_FILES["hinh_anh"])
            && $_FILES["hinh_anh"]["error"] != UPLOAD_ERR_NO_FILE) {

            if ($_FILES["hinh_anh"]["error"] != UPLOAD_ERR_OK) {
                $thong_bao = "Tải ảnh lên thất bại!";
            } else {
                // Chỉ cho phép JPG, PNG
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $loai_anh = $finfo->file(
                    $_FILES["hinh_anh"]["tmp_name"]
                );

                $ds_loai_anh = [
                    "image/jpeg" => "jpg",
                    "image/png" => "png",
                ];

                if (!isset($ds_loai_anh[$loai_anh])) {
                    $thong_bao = "Chỉ chấp nhận ảnh JPG, PNG!";
                } elseif (getimagesize(
                    $_FILES["hinh_anh"]["tmp_name"]
                ) === false) {
                    $thong_bao = "File tải lên không phải ảnh hợp lệ!";
                } else {
                    $thu_muc = "../images/";

                    if (!is_dir($thu_muc)) {
                        mkdir($thu_muc, 0755, true);
                    }

                    $ten_file = basename($_FILES["hinh_anh"]["name"]);
                    
                    if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $thu_muc . $ten_file)) {
                        $hinh_anh = "images/" . $ten_file;
                    } else {
                            $thong_bao = "Không thể lưu ảnh!";
                    }
                }
            }
        }

        if ($thong_bao == "") {
            $sql = "UPDATE mon SET ten_mon = ?, gia = ?, mo_ta = ?, hinh_anh = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $ten_mon,
                $gia,
                $mo_ta,
                $hinh_anh,
                $id
            ]);

            header("Location: mon.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa món</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h1>Sửa thông tin món</h1>

    <p style="color:red;"><?= htmlspecialchars($thong_bao) ?></p>

    <form method="POST" enctype="multipart/form-data">
        <label>Tên món:</label>
        <input type="text" name="ten_mon" value="<?= htmlspecialchars($mon["ten_mon"]) ?>" required>
        <label>Giá:</label>
        <input type="number" name="gia" min="1" value="<?= htmlspecialchars((string)$mon["gia"]) ?>" required>
        <label>Mô tả:</label>
        <textarea name="mo_ta"><?= htmlspecialchars($mon["mo_ta"] ?? "") ?></textarea>
        <label>Ảnh hiện tại:</label>

        <?php if (!empty($mon["hinh_anh"])) { ?>
            <p>
                <img src="../<?= htmlspecialchars($mon["hinh_anh"]) ?>" alt="Ảnh món hiện tại" style="width:180px; height:140px; object-fit:cover;">
            </p>
        <?php } else { ?>
            <p>Chưa có ảnh.</p>
        <?php } ?>

        <label>Chọn ảnh mới (không bắt buộc):</label>
        <input type="file" name="hinh_anh" accept=".jpg,.jpeg,.png">

        <p>Chỉ nhận ảnh JPG, PNG.</p>

        <button type="submit">Lưu thay đổi</button>
    </form>

    <p><a href="mon.php">Quay lại danh sách món</a></p>
</div>
</body>
</html>