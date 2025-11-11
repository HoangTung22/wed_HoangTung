<?php
$conn = new mysqli("localhost", "root", "", "quanlyvattuthucuong");
$conn->set_charset("utf8");

$sql = "SELECT * FROM danhmuc";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
  echo "<div class='category'>";
  echo "<h5>" . htmlspecialchars($row['ten_danhmuc']) . "</h5>";
  
  $sql_sub = "SELECT * FROM danhmuc_con WHERE id_danhmuc = " . $row['id'];
  $sub_result = $conn->query($sql_sub);
  
  echo "<ul class='subcategory'>";
  while($sub = $sub_result->fetch_assoc()) {
    echo "<li data-id='{$sub['id']}'>" . htmlspecialchars($sub['ten_danhmuc_con']) . "</li>";
  }
  echo "</ul>";
  echo "</div>";
}
?>
