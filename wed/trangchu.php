<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetShop - Trang chủ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f3f8ff;
      font-family: 'Poppins', sans-serif;
      color: #333;
    }
    /* 🔹 Navbar */
    .navbar {
      background: linear-gradient(90deg, #63a4ff, #83eaf1);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .navbar-brand {
      font-weight: 700;
      color: #fff !important;
      letter-spacing: 1px;
    }
    .nav-link {
      color: #fff !important;
      margin-right: 12px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .nav-link:hover {
      text-decoration: underline;
      color: #f0f9ff !important;
    }

    /* 🔹 Sidebar */
    .sidebar {
      background: #ffffff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      height: calc(100vh - 120px);
      overflow-y: auto;
    }
    .category {
      margin-bottom: 15px;
      border-radius: 8px;
    }
    .category h5 {
      position: relative;
      cursor: pointer;
      background: linear-gradient(90deg, #63a4ff, #83eaf1);
      color: white;
      padding: 10px 15px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
    }
    .category h5::after {
      content: '\f078';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      right: 15px;
      transition: transform 0.3s;
    }
    .category.collapsed h5::after {
      transform: rotate(-90deg);
    }
    .subcategory {
      margin-left: 10px;
      list-style: none;
      padding-left: 0;
    }
    .subcategory li {
      padding: 7px 10px;
      cursor: pointer;
      color: #444;
      border-radius: 6px;
      transition: background 0.3s, color 0.3s;
      font-size: 15px;
    }
    .subcategory li:hover {
      background-color: #e3f2ff;
      color: #007bff;
    }
    .subcategory li.active {
      background-color: #63a4ff;
      color: white !important;
      font-weight: 600;
      border: 2px solid #83eaf1;
    }

    /* 🔹 Product card */
    .product-card {
      border: none;
      transition: all 0.3s ease;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      text-align: center;
      padding: 12px;
    }
    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(99,164,255,0.4);
    }

    /* 🔹 Footer */
    footer {
      background: linear-gradient(90deg, #63a4ff, #83eaf1);
      color: white;
      padding: 20px;
      text-align: center;
      font-weight: 500;
      margin-top: 50px;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    /* 🔹 Search box */
    .search-box {
      display: flex;
      gap: 10px;
      margin-bottom: 15px;
    }
    .search-box input {
      border-radius: 8px;
      border: 1px solid #ddd;
      padding: 8px 12px;
    }
    .search-box button {
      background: linear-gradient(90deg, #63a4ff, #83eaf1);
      border: none;
      color: #fff;
      border-radius: 8px;
      padding: 8px 15px;
      font-weight: 500;
      transition: all 0.3s;
    }
    .search-box button:hover {
      background: linear-gradient(90deg, #5598ff, #70d8e6);
    }
    /* 🛒 Cart icon */
#cart-icon {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: linear-gradient(90deg, #63a4ff, #83eaf1);
  color: white;
  border-radius: 50%;
  width: 55px;
  height: 55px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  z-index: 1000;
}
#cart-count {
  position: absolute;
  top: 10px;
  right: 10px;
  background: red;
  color: white;
  border-radius: 50%;
  font-size: 12px;
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* 🧾 Popup cart */
#cart-popup {
  position: fixed;
  bottom: 85px;
  right: 20px;
  width: 300px;
  display: none;
  z-index: 1001;
}
#cart-popup.show {
  display: block;
}

  </style>
</head>
<body>

<!-- 🔹 Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="fa-solid fa-paw"></i> PetShop</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="#">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Sản phẩm</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
      </ul>

      <!-- 👋 Hiển thị người dùng -->
      <div class="text-white fw-bold me-3">
        Xin chào, <?= htmlspecialchars($_SESSION['user']); ?> 👋
      </div>
      <a href="../wed/logout.php" class="btn btn-light btn-sm fw-bold px-3">Đăng xuất</a>
    </div>
  </div>
</nav>

<!-- 🔹 Main content -->
<div class="container-fluid mt-4">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3">
      <div class="sidebar" id="category-list"></div>
    </div>

    <!-- Product area -->
    <div class="col-md-9">
      <div class="search-box">
        <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
        <button id="btnSearch"><i class="fa fa-search"></i> Tìm</button>
      </div>
      <div class="row g-4" id="product-list">
        <div class="text-center text-muted mt-5">Chọn danh mục con hoặc nhập từ khóa để xem sản phẩm...</div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  🐾 Cùng chăm sóc thú cưng với 2TU PetShop 🐶🐱
</footer>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){

  // 🔹 Tải danh mục chính & phụ
  $.get("../api/get_danhmuc.php", function(data){
      $("#category-list").html(data);
  });

  // 🔹 Mở/đóng danh mục
  $(document).on("click", ".category h5", function(){
      const category = $(this).parent();
      category.toggleClass("collapsed");
      category.find(".subcategory").slideToggle(200);
  });

  // 🔹 Lọc sản phẩm theo danh mục con
  $(document).on("click", ".subcategory li", function(){
      let id_danhmuc_con = $(this).data("id");
      $(".subcategory li").removeClass("active");
      $(this).addClass("active");
      $.get("../api/get_sanpham.php?id_danhmuc_con=" + id_danhmuc_con, function(data){
          $("#product-list").html(data);
      });
  });

  // 🔹 Tìm kiếm sản phẩm
  $("#btnSearch").click(function(){
      let keyword = $("#search").val().trim();
      if (keyword === "") {
          $("#product-list").html('<div class="text-center text-muted mt-5">Vui lòng nhập từ khóa tìm kiếm...</div>');
          return;
      }
      $(".subcategory li").removeClass("active");
      $.get("../api/get_sanpham.php?search=" + keyword, function(data){
          $("#product-list").html(data);
      });
  });

});
// 🛒 Giỏ hàng cục bộ (lưu trong localStorage)
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// ✅ Hàm thêm vào giỏ hàng
function addToCart(id, name, price) {
  let item = cart.find(p => p.id === id);
  if (item) {
    item.quantity++;
  } else {
    cart.push({ id, name, price, quantity: 1 });
  }
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  showCartIcon();
}

// ✅ Hàm mua ngay
function buyNow(id, name, price) {
  let order = [{ id, name, price, quantity: 1 }];
  localStorage.setItem("order_now", JSON.stringify(order));
  window.location.href = "thanhtoan.html";
}

// ✅ Hiển thị số lượng giỏ hàng
function updateCartCount() {
  const count = cart.reduce((sum, p) => sum + p.quantity, 0);
  document.getElementById("cart-count").innerText = count;
}

// ✅ Hiển thị giỏ hàng mini khi ấn icon
function toggleCart() {
  document.getElementById("cart-popup").classList.toggle("show");
  renderCartItems();
}

// ✅ Render sản phẩm trong popup
function renderCartItems() {
  let container = document.getElementById("cart-items");
  container.innerHTML = "";
  let total = 0;

  if (cart.length === 0) {
    container.innerHTML = "<p class='text-muted text-center'>Giỏ hàng trống 😿</p>";
    document.getElementById("cart-total").innerText = "0 đ";
    return;
  }

  cart.forEach(p => {
    total += p.price * p.quantity;
    container.innerHTML += `
      <div class="d-flex justify-content-between align-items-center border-bottom py-2">
        <div>
          <strong>${p.name}</strong><br>
          <small>${p.price.toLocaleString()} đ × ${p.quantity}</small>
        </div>
        <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${p.id})">X</button>
      </div>`;
  });

  document.getElementById("cart-total").innerText = total.toLocaleString() + " đ";
}

// ✅ Xóa sản phẩm trong giỏ
function removeItem(id) {
  cart = cart.filter(p => p.id !== id);
  localStorage.setItem("cart", JSON.stringify(cart));
  renderCartItems();
  updateCartCount();
}

// ✅ Mua tất cả trong giỏ hàng
function checkoutCart() {
  if (cart.length === 0) {
    alert("Giỏ hàng đang trống!");
    return;
  }
  localStorage.setItem("order_now", JSON.stringify(cart));
  window.location.href = "thanhtoan.html";
}

// ✅ Tạo icon giỏ hàng ở góc phải
function showCartIcon() {
  if (!document.getElementById("cart-icon")) {
    $("body").append(`
      <div id="cart-icon" onclick="toggleCart()">
        🛒 <span id="cart-count">0</span>
      </div>
      <div id="cart-popup" class="card shadow">
        <div class="card-header fw-bold">Giỏ hàng</div>
        <div class="card-body" id="cart-items"></div>
        <div class="card-footer text-end">
          Tổng: <span id="cart-total" class="fw-bold text-primary">0 đ</span><br>
          <button class="btn btn-success btn-sm mt-2 w-100" onclick="checkoutCart()">Mua ngay</button>
        </div>
      </div>
    `);
  }
  updateCartCount();
}
showCartIcon();

</script>
</body>
</html>
