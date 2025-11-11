<?php
include('db.php');

$sql = "SELECT d.id, d.ma_don, d.ngay_dat, d.tong_tien, d.trang_thai,
               k.ho_ten, k.sdt, k.dia_chi
        FROM donhang d
        JOIN khachhang k ON d.id_khachhang = k.id
        ORDER BY d.ngay_dat DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table class='table table-bordered align-middle'>
          <thead class='table-light'>
            <tr>
              <th>Mã đơn</th>
              <th>Ngày đặt</th>
              <th>Khách hàng</th>
              <th>Số điện thoại</th>
              <th>Địa chỉ</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
            </tr>
          </thead><tbody>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['ma_don']}</td>
            <td>{$row['ngay_dat']}</td>
            <td>{$row['ho_ten']}</td>
            <td>{$row['sdt']}</td>
            <td>{$row['dia_chi']}</td>
            <td>" . number_format($row['tong_tien'], 0, ',', '.') . " đ</td>
            <td>{$row['trang_thai']}</td>
          </tr>";
  }
  echo "</tbody></table>";
} else {
  echo "<p class='text-center text-muted mt-3'>Chưa có đơn hàng nào.</p>";
}
?>
