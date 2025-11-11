<?php
require_once("db.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $sql = "SELECT sp.ten_sanpham, k.ten_kho, t.so_luong, t.ngay_cap_nhat
          FROM ton_kho t
          JOIN sanpham sp ON sp.ma_sanpham = t.ma_sanpham
          JOIN kho_hang k ON k.ma_kho = t.ma_kho";
  $res = $conn->query($sql);
  echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}
?>
