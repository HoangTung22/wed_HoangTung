<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ten = $_POST['ten'];
  $gia = $_POST['gia'];
  $loai = $_POST['loai'];
  $id_danhmuc_con = $_POST['id_danhmuc_con'];

  // Upload hình ảnh
  $targetDir = "../images/";
  $fileName = basename($_FILES["hinh_anh"]["name"]);
  $targetFile = $targetDir . $fileName;

  if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $targetFile)) {
    $sql = "INSERT INTO sanpham (ten, gia, loai, hinh_anh, id_danhmuc_con)
            VALUES ('$ten', '$gia', '$loai', '$fileName', '$id_danhmuc_con')";
    if ($conn->query($sql)) {
      echo "✅ Thêm sản phẩm thành công!";
    } else {
      echo "❌ Lỗi thêm sản phẩm: " . $conn->error;
    }
  } else {
    echo "❌ Lỗi upload ảnh.";
  }
}
?>
