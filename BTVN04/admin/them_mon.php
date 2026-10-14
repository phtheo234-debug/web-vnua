<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../connect.php";

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_mon = trim($_POST["ten_mon"] ?? "");
    $gia = $_POST["gia"] ?? "";
    $mo_ta = trim($_POST["mo_ta"] ?? "");
    $hinh_anh = "";

    if ($ten_mon == "" || !is_numeric($gia) || $gia <= 0) {
        $thong_bao = "Vui lòng nhập tên món và giá hợp lệ!";
    } else {
        // Kiểm tra người dùng có chọn ảnh không
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
            $sql = "INSERT INTO mon
                    (ten_mon, gia, mo_ta, hinh_anh)
                    VALUES (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $ten_mon,
                $gia,
                $mo_ta,
                $hinh_anh
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
    <title>Thêm món</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h1>Thêm món mới</h1>

    <p style="color:red;"><?= htmlspecialchars($thong_bao) ?></p>

    <form method="POST" enctype="multipart/form-data">
        <label>Tên món:</label>
        <input type="text" name="ten_mon" required>
        <label>Giá:</label>
        <input type="number" name="gia" min="1" required>
        <label>Mô tả:</label>
        <textarea name="mo_ta"></textarea>
        <label>Chọn ảnh món:</label>
        <input type="file" name="hinh_anh" accept=".jpg,.jpeg,.png">
        <p>Nhận JPG, PNG</p>
        <button type="submit">Thêm món</button>
    </form>

    <p><a href="mon.php">Quay lại danh sách món</a></p>
</div>
</body>
</html>