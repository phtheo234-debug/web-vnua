-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 14, 2026 lúc 08:32 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shopmilktea`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `ten_dang_nhap`, `mat_khau`) VALUES
(1, 'thao', '9999');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` int(11) NOT NULL,
  `id_don_hang` int(11) NOT NULL,
  `id_mon` int(11) DEFAULT NULL,
  `ten_mon` varchar(100) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`id`, `id_don_hang`, `id_mon`, `ten_mon`, `so_luong`, `don_gia`) VALUES
(1, 1, 5, 'Trà sữa socola', 1, 35000),
(2, 2, 6, 'Trà quýt', 1, 25000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL,
  `ten_khach` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(15) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `tong_tien` decimal(12,0) NOT NULL DEFAULT 0,
  `trang_thai` enum('Chờ xác nhận','Đang chuẩn bị','Đang giao','Hoàn thành','Đã hủy') NOT NULL DEFAULT 'Chờ xác nhận',
  `ngay_dat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`id`, `ten_khach`, `so_dien_thoai`, `dia_chi`, `tong_tien`, `trang_thai`, `ngay_dat`) VALUES
(1, 'ta', '0123456789', 'gjhf', 35000, 'Hoàn thành', '2026-10-14 23:00:10'),
(2, 'bj', '0123456788', 'ggj', 25000, 'Đang giao', '2026-10-15 01:27:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mon`
--

CREATE TABLE `mon` (
  `id` int(11) NOT NULL,
  `ten_mon` varchar(100) NOT NULL,
  `gia` int(11) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `mon`
--

INSERT INTO `mon` (`id`, `ten_mon`, `gia`, `mo_ta`, `hinh_anh`) VALUES
(1, 'Trà sữa trân châu', 30000, 'Trà sữa truyền thống', 'images/3b1cd28ac392eceb06cf8c4565659306.jpg'),
(2, 'Trà sữa matcha', 35000, 'Trà sữa vị matcha', 'images/34ebac2ba1b9ef2e15d3752e77416b97.jpg'),
(3, 'Trà đào cam sả', 32000, 'Trà trái cây thanh mát', 'images/d855fce8db65d4ca91fbb9d51fdecbc9.jpg'),
(4, 'Trà vải', 30000, 'Trà vải ngọt dịu', 'images/9665eab8a80865b72e7434aeed0f4727.jpg'),
(5, 'Trà sữa socola', 35000, 'Trà sữa vị socola', 'images/f000598e6add645e7a6a4e8e328564a4.jpg'),
(6, 'Trà quýt', 25000, 'abc', 'images/b6a2053b647b3f703813298e50aa0333.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`);

--
-- Chỉ mục cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_don_hang` (`id_don_hang`),
  ADD KEY `id_mon` (`id_mon`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mon`
--
ALTER TABLE `mon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `mon`
--
ALTER TABLE `mon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`id_mon`) REFERENCES `mon` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
