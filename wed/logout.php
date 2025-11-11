<?php
// Bắt đầu session để có thể truy cập dữ liệu đăng nhập
session_start();

// Xóa toàn bộ dữ liệu session (user, role, v.v.)
session_unset(); 

// Hủy session hiện tại
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập
header("Location: login.html");
exit();
?>
