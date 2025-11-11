<?php
require_once("db.php");
header('Content-Type: application/json');

$sql = "SELECT dh.ma_donhang, kh.ho_ten, dh.ngay_dat, dh.tong_tien, dh.tinh_trang
        FROM don_hang dh JOIN khach_hang kh ON dh.ma_khachhang = kh.ma_khachhang";
$res = $conn->query($sql);
echo json_encode($res->fetch_all(MYSQLI_ASSOC));
?>
