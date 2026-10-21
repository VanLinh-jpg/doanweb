<?php
include 'header.php';
if (!isset($_SESSION['VaiTro']) || $_SESSION['VaiTro'] !== 'Admin') {
    echo "<script>alert('⛔ Bạn không có quyền truy cập!'); window.location.href='index.php';</script>";
    exit;
}
?>
<style>
    .admin-card { transition: all 0.3s ease; border-radius: 8px; }
    .admin-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.12) !important; }
</style>

<div class="container my-5 pt-4 pb-5" style="min-height: 60vh;">
    <h2 class="text-center mb-5 brand-text" style="font-size: 2.5rem; color: #1a3a2a;">Bảng Điều Khiển Quản Trị</h2>
    <div class="row justify-content-center px-lg-5">
        
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 py-4 px-3 text-center admin-card" style="border-bottom: 4px solid #2d6a4f !important;">
                <div class="card-body d-flex flex-column">
                    <i class="bi bi-box-seam fs-1 mb-3" style="color: #2d6a4f;"></i>
                    <h5 class="fw-bold mb-3">Sản Phẩm & Tồn Kho</h5>
                    <a href="admin_sanpham.php" class="btn mt-auto w-100 py-2 fw-bold text-white" style="background-color: #1a3a2a;">Quản Lý SP</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 py-4 px-3 text-center admin-card" style="border-bottom: 4px solid #c9a84c !important;">
                <div class="card-body d-flex flex-column">
                    <i class="bi bi-receipt fs-1 mb-3" style="color: #c9a84c;"></i>
                    <h5 class="fw-bold mb-3">Quản Lý Đơn Hàng</h5>
                    <a href="admin_donhang.php" class="btn mt-auto w-100 py-2 fw-bold text-white" style="background-color: #c9a84c; color: #1a1a1a !important;">Xem Đơn Hàng</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 py-4 px-3 text-center admin-card" style="border-bottom: 4px solid #5c3d1e !important;">
                <div class="card-body d-flex flex-column">
                    <i class="bi bi-people-fill fs-1 mb-3" style="color: #5c3d1e;"></i>
                    <h5 class="fw-bold mb-3">Tài Khoản Khách Hàng</h5>
                    <a href="admin_taikhoan.php" class="btn mt-auto w-100 py-2 fw-bold text-white" style="background-color: #5c3d1e;">Xem Tài Khoản</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 py-4 px-3 text-center admin-card" style="border-bottom: 4px solid #d9534f !important;">
                <div class="card-body d-flex flex-column">
                    <i class="bi bi-bar-chart-fill fs-1 mb-3 text-danger"></i>
                    <h5 class="fw-bold mb-3 text-danger">Thống Kê & Báo Cáo</h5>
                    <a href="admin_thongke.php" class="btn btn-danger mt-auto w-100 py-2 fw-bold">Xem Báo Cáo</a>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>

