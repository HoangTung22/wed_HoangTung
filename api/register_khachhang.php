<?php
include("db.php");

// Lấy dữ liệu từ form
$ten = $_POST['ten'];
$email = $_POST['email'];
$so_dien_thoai = $_POST['so_dien_thoai'];
$dia_chi = $_POST['dia_chi'];
$username = $_POST['username'];
$password = $_POST['password'];

// Mã hóa mật khẩu để bảo mật
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Kiểm tra trùng username hoặc email
$check = $conn->prepare("SELECT * FROM khachhang WHERE username=? OR email=?");
$check->bind_param("ss", $username, $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại!'); window.location='../wed/register.html';</script>";
  exit();
}

// Thêm dữ liệu vào database
$stmt = $conn->prepare("INSERT INTO khachhang (ten_khachhang, email, sdt, dia_chi, username, password)
                        VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $ten, $email, $so_dien_thoai, $dia_chi, $username, $password);

if ($stmt->execute()) {
  echo "<script>alert('Đăng ký thành công! Hãy đăng nhập ngay.'); window.location='../wed/login.html';</script>";
} else {
  echo "<script>alert('Lỗi khi đăng ký. Vui lòng thử lại!'); window.location='../wed/register.html';</script>";
}

$stmt->close();
$conn->close();
?>
