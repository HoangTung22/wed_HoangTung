<?php
session_start();
$conn = new mysqli("localhost", "root", "", "quanlyvattuthucuong");
$conn->set_charset("utf8");

$username = $_POST['username'];
$password = $_POST['password'];

// --- Kiểm tra nhân viên (admin) ---
$sql_nv = "SELECT * FROM nhan_vien WHERE email='$username' AND so_dien_thoai='$password'";
$result_nv = $conn->query($sql_nv);

// --- Kiểm tra khách hàng ---
$sql_kh = "SELECT * FROM khachhang WHERE username='$username' AND password='$password'";
$result_kh = $conn->query($sql_kh);

// --- Xử lý đăng nhập ---
if ($result_nv->num_rows > 0) {
    $_SESSION['user'] = $username;
    $_SESSION['role'] = 'admin'; // ✅ đổi từ 'nhan_vien' thành 'admin'

    // ✅ vì check_login nằm trong /api/, nên đường dẫn phải nhảy ra 1 cấp tới /wed/
    header("Location: ../wed/admin_trangchu.php");
    exit();
}
elseif ($result_kh->num_rows > 0) {
    $_SESSION['user'] = $username;
    $_SESSION['role'] = 'khachhang';

    // ✅ tương tự, sang trang chủ khách
    header("Location: ../wed/trangchu.php");
    exit();
}
else {
    echo "<script>alert('Sai tài khoản hoặc mật khẩu!'); window.location='../wed/login.html';</script>";
}
?>
