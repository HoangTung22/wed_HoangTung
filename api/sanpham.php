<?php
require_once("db.php"); // file này chứa $conn = new mysqli(...);
header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  // -------------------- GET: Lấy danh sách sản phẩm --------------------
  case 'GET':
    if (isset($_GET['id'])) {
      // Lấy 1 sản phẩm cụ thể theo ID
      $id = intval($_GET['id']);
      $stmt = $conn->prepare("SELECT * FROM sanpham WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      echo json_encode($result->fetch_assoc(), JSON_UNESCAPED_UNICODE);
    } else {
      // Lấy toàn bộ sản phẩm
      $res = $conn->query("SELECT * FROM sanpham");
      echo json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_UNESCAPED_UNICODE);
    }
    break;

  // -------------------- POST: Thêm sản phẩm mới --------------------
  case 'POST':
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['ten'], $data['loai'], $data['gia'], $data['mo_ta'], $data['hinh_anh'])) {
      echo json_encode(["error" => "Thiếu dữ liệu đầu vào"], JSON_UNESCAPED_UNICODE);
      exit;
    }

    $stmt = $conn->prepare("INSERT INTO sanpham (ten, loai, gia, mo_ta, hinh_anh) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $data['ten'], $data['loai'], $data['gia'], $data['mo_ta'], $data['hinh_anh']);
    $success = $stmt->execute();
    echo json_encode(["success" => $success], JSON_UNESCAPED_UNICODE);
    break;

  // -------------------- PUT: Cập nhật sản phẩm --------------------
  case 'PUT':
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id'])) {
      echo json_encode(["error" => "Thiếu ID sản phẩm"], JSON_UNESCAPED_UNICODE);
      exit;
    }

    $stmt = $conn->prepare("UPDATE sanpham SET ten=?, loai=?, gia=?, mo_ta=?, hinh_anh=? WHERE id=?");
    $stmt->bind_param("ssdssi", $data['ten'], $data['loai'], $data['gia'], $data['mo_ta'], $data['hinh_anh'], $data['id']);
    $success = $stmt->execute();
    echo json_encode(["success" => $success], JSON_UNESCAPED_UNICODE);
    break;

  // -------------------- DELETE: Xóa sản phẩm --------------------
  case 'DELETE':
    if (!isset($_GET['id'])) {
      echo json_encode(["error" => "Thiếu ID sản phẩm cần xóa"], JSON_UNESCAPED_UNICODE);
      exit;
    }

    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM sanpham WHERE id=?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    echo json_encode(["success" => $success], JSON_UNESCAPED_UNICODE);
    break;

  // -------------------- Mặc định --------------------
  default:
    echo json_encode(["error" => "Phương thức không hợp lệ"], JSON_UNESCAPED_UNICODE);
    break;
}
?>
