<?php
ob_start();
require_once "connect.php";
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạ Phương Thảo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
        }

        .btn-submit {
            padding: 8px 18px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #333;
            color: white;
        }

        .form-sua {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: center;
            margin-bottom: 8px;
        }

        .form-sua input {
            width: 100%;
            max-width: 150px;
            padding: 5px 8px;
            font-size: 13px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-sua {
            width: 100%;
            max-width: 150px;
            padding: 6px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-sua:hover {
            background-color: #0056b3;
        }

        .xoa {
            display: inline-block;
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .xoa:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Quản lý sản phẩm</h1>

    <div>
        <form action="create.php" method="POST">
            <input type="text" name="ten_san_pham" placeholder="Tên sản phẩm" required>
            <input type="number" name="gia" placeholder="Giá" required>
            <input type="number" name="so_luong" placeholder="Số lượng" required>
            <input type="text" name="mo_ta" placeholder="Mô tả">
            <button class="btn-submit" type="submit">Thêm sản phẩm</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>

        <?php foreach ($dsSanPham as $sanPham): ?>
            <tr>
                <td><?= $sanPham["id"] ?></td>
                <td><?= $sanPham["ten_san_pham"] ?></td>
                <td><?= number_format($sanPham["gia"]) ?></td>
                <td><?= $sanPham["so_luong"] ?></td>
                <td><?= $sanPham["mo_ta"] ?></td>
                <td>
                    <form class="form-sua" action="update.php?id=<?= $sanPham['id'] ?>" method="POST">
                        <input type="text" name="ten_san_pham" value="<?= $sanPham['ten_san_pham'] ?>" placeholder="Tên SP">
                        <input type="number" name="gia" value="<?= $sanPham['gia'] ?>" placeholder="Giá">
                        <input type="number" name="so_luong" value="<?= $sanPham['so_luong'] ?>" placeholder="Số lượng">
                        <input type="text" name="mo_ta" value="<?= $sanPham['mo_ta'] ?>" placeholder="Mô tả">
                        <button class="btn-sua" type="submit">Sửa</button>
                    </form>
                    <a class="xoa" href="delete.php?id=<?= $sanPham['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>