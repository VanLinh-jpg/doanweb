<?php 
include 'header.php'; 

// Lấy tất cả sản phẩm
$sql_sale = "SELECT * FROM SanPham ORDER BY ID_SanPham DESC";
$res_sale = $conn->query($sql_sale);
?>

<div class="container py-5">
    <!-- Tiêu đề khuyến mãi -->
    <div class="text-center mb-5">
        <span class="badge bg-danger fs-6 px-3 py-2 text-uppercase mb-2">🔥 Chương Trình Khai Trương 🔥</span>
        <h1 class="fw-bold text-uppercase" style="color: #1a3a2a;">Sản Phẩm Sale Khuyến Mãi 30%</h1>
        <p class="text-muted">Tất cả sản phẩm cơ bi & phụ kiện cao cấp đang được áp dụng ưu đãi giảm 30% giá niêm yết!</p>
    </div>

    <div class="row">
        <?php 
        if ($res_sale && $res_sale->num_rows > 0) {
            while ($row = $res_sale->fetch_assoc()) {
                $id_sp = $row['ID_SanPham'];
                $ten_sp = $row['TenSanPham'];
                $gia_goc = $row['Gia'];
                
                // Tính giá giảm 30%
                $gia_sale = $gia_goc * 0.7;

                // Xử lý ảnh
                $anh_sp = 'images/' . $row['HinhAnh'];
                if (!file_exists($anh_sp) || empty($row['HinhAnh'])) {
                    $anh_sp = 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=500&fit=crop';
                }
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm position-relative product-card" style="transition: 0.3s;">
                <!-- Badge -30% -->
                <span class="position-absolute top-0 start-0 bg-danger text-white fw-bold px-2 py-1" style="font-size: 0.8rem; z-index: 2; border-bottom-right-radius: 8px;">
                    -30%
                </span>

                <a href="chitiet.php?id=<?php echo $id_sp; ?>" class="text-decoration-none text-dark">
                    <div class="p-3 text-center" style="background-color: #f8f9fa;">
                        <img src="<?php echo $anh_sp; ?>" class="card-img-top" style="object-fit: contain; height: 220px;" alt="<?php echo $ten_sp; ?>">
                    </div>
                    <div class="card-body p-3 text-center">
                        <h6 class="card-title fw-bold text-truncate" style="font-size: 0.95rem; color: #333;" title="<?php echo $ten_sp; ?>">
                            <?php echo $ten_sp; ?>
                        </h6>
                        <div class="mt-2">
                            <!-- Giá sau giảm 30% -->
                            <span class="fw-bold text-danger fs-5 me-2"><?php echo number_format($gia_sale, 0, ',', '.'); ?> đ</span>
                            <!-- Giá gốc gạch ngang -->
                            <small class="text-muted text-decoration-line-through"><?php echo number_format($gia_goc, 0, ',', '.'); ?> đ</small>
                        </div>
                    </div>
                </a>

                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <form action="giohang.php" method="POST" class="m-0 text-center">
                        <input type="hidden" name="id_sp" value="<?php echo $id_sp; ?>">
                        <input type="hidden" name="ten_sp" value="<?php echo $ten_sp; ?>">
                        <input type="hidden" name="gia_sp" value="<?php echo $gia_sale; ?>">
                        <input type="hidden" name="hinh_anh" value="<?php echo $anh_sp; ?>">
                        <input type="hidden" name="so_luong" value="1">
                        <button type="submit" name="them_gio_hang" class="btn w-100 text-white fw-bold" style="background-color: #2d6a4f; border-radius: 4px;">
                            <i class="bi bi-cart-plus me-1"></i> Thêm Vào Giỏ
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h4>Hiện chưa có sản phẩm nào trong chương trình khuyến mãi.</h4></div>';
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>