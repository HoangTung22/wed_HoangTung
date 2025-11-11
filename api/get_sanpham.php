<?php
$conn = new mysqli("localhost", "root", "", "quanlyvattuthucuong");
$conn->set_charset("utf8");

$search = $_GET['search'] ?? '';
$id_danhmuc_con = $_GET['id_danhmuc_con'] ?? '';

if ($search != '') {
  $sql = "SELECT * FROM sanpham WHERE ten LIKE '%$search%'";
} elseif ($id_danhmuc_con != '') {
  $sql = "SELECT * FROM sanpham WHERE id_danhmuc_con = $id_danhmuc_con";
} else {
  $sql = "SELECT * FROM sanpham";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    // ✅ Format giá tiền
    $gia = number_format($row['gia'], 0, ',', '.');

    // ✅ Xuất HTML từng sản phẩm
    echo "
      <div class='col-md-4'>
        <div class='product-card'>
          <img src='../images/{$row['hinh_anh']}' alt='{$row['ten']}'>
          <h6 class='mt-2 fw-bold'>{$row['ten']}</h6>
          <p class='text-muted mb-1'>{$row['loai']}</p>
          <p class='fw-bold text-primary fs-5'>{$gia} đ</p>

          <div class='d-flex justify-content-center gap-2'>
            <button class='btn btn-outline-primary btn-sm' 
                    onclick=\"addToCart({$row['id']}, '{$row['ten']}', {$row['gia']})\">
              🛒 Thêm vào giỏ
            </button>

            <button class='btn btn-success btn-sm' 
                    onclick=\"buyNow({$row['id']}, '{$row['ten']}', {$row['gia']})\">
              ⚡ Mua ngay
            </button>
          </div>
        </div>
      </div>
    ";
  }
} else {
  echo "<div class='text-center text-muted mt-5'>Không có sản phẩm nào.</div>";
}
?>
