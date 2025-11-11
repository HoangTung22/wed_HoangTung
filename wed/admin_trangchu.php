<?php
session_start();
include('../api/db.php');

// ✅ Kiểm tra quyền đăng nhập admin
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
  header("Location: login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>PetShop Admin | Quản lý</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
   body {
  background-color: #f3f8ff;
  font-family: 'Poppins', sans-serif;
}

.navbar {
  background: linear-gradient(90deg, #63a4ff, #83eaf1);
  color: white;
}

.navbar-brand {
  font-weight: bold;
  color: #fff !important;
}

/* 🔹 Sidebar tổng thể */
.sidebar {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  height: calc(100vh - 100px);
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* 🌈 Sidebar tổng thể */
.sidebar {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  height: calc(100vh - 100px);
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* 🌿 Nút sidebar bình thường */
.sidebar a {
  display: block;
  color: #333;
  padding: 10px 15px;
  border-radius: 8px;
  margin-bottom: 8px;
  font-weight: 500;
  border: 2px solid #63a4ff; /* viền xanh nhạt */
  background-color: #ffffff; /* nền trắng */
  transition: all 0.3s ease;
}

/* 💙 Khi rê chuột qua — sáng xanh nhẹ */
.sidebar a:hover {
  background: linear-gradient(90deg, #75b4ff, #9ae2ff);
  color: white;
  border-color: #63a4ff;
}

/* 💎 Khi được chọn (active) — giống màu thanh navbar */
.sidebar a.active {
  background: linear-gradient(90deg, #63a4ff, #83eaf1);
  border: 2px solid #63a4ff;
  color: #fff !important;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 0 8px rgba(99,164,255,0.4);
}

}

  </style>
</head>
<body>
  <!-- 🔹 Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fa-solid fa-shield-dog"></i> PetShop Admin</a>
      <div class="text-white fw-bold ms-auto me-3">
        👋 Xin chào, <?= $_SESSION['user']; ?>
      </div>
      <a href="../wed/logout.php" class="btn btn-light btn-sm">Đăng xuất</a>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3">
        <div class="sidebar">
          <a href="#" class="active" id="btn-add">🐾 Thêm sản phẩm</a>
          <a href="#" id="btn-order">📦 Đơn hàng</a>
        </div>
      </div>

      <!-- Nội dung chính -->
      <div class="col-md-9">
        <!-- 🐾 Thêm sản phẩm -->
        <div id="section-add">
          <h4 class="text-primary mb-3"><i class="fa fa-plus-circle"></i> Thêm sản phẩm mới</h4>

          <form id="formAddProduct" enctype="multipart/form-data" class="card p-3 shadow-sm">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="ten" class="form-control" required>
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-label">Giá (VNĐ)</label>
                <input type="number" name="gia" class="form-control" required>
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-label">Loại</label>
                <input type="text" name="loai" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Danh mục con</label>
                <select name="id_danhmuc_con" class="form-select" id="selectDanhMuc" required></select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Hình ảnh</label>
                <input type="file" name="hinh_anh" class="form-control" accept="image/*" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
          </form>
        </div>

        <!-- 📦 Đơn hàng -->
        <div id="section-order" style="display:none;">
          <h4 class="text-primary mb-3"><i class="fa fa-receipt"></i> Danh sách đơn hàng</h4>
          <div id="listDonHang" class="table-responsive"></div>
        </div>
      </div>
    </div>
  </div>

  <footer>🐶 2TU PetShop Admin © 2025</footer>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
  $(document).ready(function(){
    // 🔹 Chuyển tab
    $("#btn-add").click(function(){
      $("#section-add").show();
      $("#section-order").hide();
      $(".sidebar a").removeClass("active");
      $(this).addClass("active");
    });
    $("#btn-order").click(function(){
      $("#section-add").hide();
      $("#section-order").show();
      $(".sidebar a").removeClass("active");
      $(this).addClass("active");
      loadDonHang();
    });

    // 🔹 Load danh mục con
    $.get("../api/get_danhmuc.php", function(data){
      $("#selectDanhMuc").html(data);
    });

    // 🔹 Gửi form thêm sản phẩm
    $("#formAddProduct").submit(function(e){
      e.preventDefault();
      let formData = new FormData(this);
      $.ajax({
        url: "../api/admin_add_sanpham.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res){
          alert(res);
          $("#formAddProduct")[0].reset();
        }
      });
    });

    // 🔹 Load danh sách đơn hàng
    function loadDonHang() {
      $.get("../api/admin_get_donhang.php", function(data){
        $("#listDonHang").html(data);
      });
    }
  });
  </script>
</body>
</html>
