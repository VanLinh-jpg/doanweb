<?php 
include 'header.php'; 

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM SanPham WHERE ID_SanPham = $id";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $sp = $result->fetch_assoc();
        $duongDanAnh = 'images/' . $sp['HinhAnh'];
        $anhHienThi = file_exists($duongDanAnh) ? $duongDanAnh : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=800&fit=crop';
    } else {
        echo "<h2 class='text-center mt-5 mb-5 py-5'>Không tìm thấy sản phẩm!</h2>";
        include 'footer.php'; exit;
    }
} else {
    echo "<h2 class='text-center mt-5 mb-5 py-5'>Lỗi: Bạn chưa chọn sản phẩm nào!</h2>";
    include 'footer.php'; exit;
}
?>

<div class="container my-5 pt-4">
    <div class="row align-items-start">
        
        <!-- ẢNH SẢN PHẨM -->
        <div class="col-md-6 mb-4 text-center">
            <img src="<?php echo $anhHienThi; ?>" alt="Ảnh Sản Phẩm" style="width: 100%; max-height: 500px; object-fit: contain; border-radius: 8px; background: #f8f9fa; padding: 20px;">
        </div>

        <!-- THÔNG TIN SẢN PHẨM -->
        <div class="col-md-6 px-lg-5">
            <span class="badge mb-3" style="background-color: #2d6a4f; font-size: 0.85rem;"><?php echo $sp['ThuongHieu'] ?? 'Khác'; ?></span>
            <h1 class="brand-text" style="font-size: 2.2rem; font-weight: 700; margin-bottom: 15px;"><?php echo $sp['TenSanPham']; ?></h1>
            <p style="font-size: 2rem; font-weight: 700; color: #2d6a4f; margin-bottom: 25px;">
                <?php echo number_format($sp['Gia'], 0, ',', '.'); ?> VNĐ
            </p>
            
            <hr class="my-4">
            
            <?php if(!empty($sp['LoaiDa'])): ?>
            <div class="mb-4">
                <h6 class="fw-bold text-uppercase mb-2" style="color: #1a3a2a;">Phân loại:</h6>
                <p class="text-muted" style="font-size: 1.05rem;"><?php echo $sp['LoaiDa']; ?></p>
            </div>
            <?php endif; ?>
            
            <?php if(!empty($sp['MoTa'])): ?>
            <div class="mb-4">
                <h6 class="fw-bold text-uppercase mb-2" style="color: #1a3a2a;">Mô tả sản phẩm:</h6>
                <p class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                    <?php echo nl2br($sp['MoTa']); ?>
                </p>
            </div>
            <?php endif; ?>

            <!-- TRẠNG THÁI TỒN KHO -->
            <div class="mb-4">
                <?php if($sp['SoLuongTon'] > 0): ?>
                    <span class="badge bg-success fs-6">✅ Còn hàng (<?php echo $sp['SoLuongTon']; ?> sản phẩm)</span>
                <?php else: ?>
                    <span class="badge bg-danger fs-6">❌ Hết hàng</span>
                <?php endif; ?>
            </div>

            <!-- FORM THÊM VÀO GIỎ -->
            <form action="giohang.php" method="POST" class="d-flex mt-4">
                <input type="hidden" name="id_sp" value="<?php echo $sp['ID_SanPham']; ?>">
                <input type="hidden" name="ten_sp" value="<?php echo $sp['TenSanPham']; ?>">
                <input type="hidden" name="gia_sp" value="<?php echo $sp['Gia']; ?>">
                <input type="hidden" name="hinh_anh" value="<?php echo $anhHienThi; ?>">
                
                <input type="number" name="so_luong" class="form-control text-center me-3" value="1" min="1" max="<?php echo $sp['SoLuongTon']; ?>" style="width: 80px; font-weight: bold;" <?php if($sp['SoLuongTon'] == 0) echo 'disabled'; ?>>
                <button type="submit" name="them_gio_hang" <?php if($sp['SoLuongTon'] == 0) echo 'disabled'; ?> style="background-color: #1a3a2a; color: #fff; padding: 15px 30px; font-weight: 600; width: 100%; border: none; letter-spacing: 1px; transition: 0.3s;" onmouseover="this.style.backgroundColor='#2d6a4f'" onmouseout="this.style.backgroundColor='#1a3a2a'">
                    🎱 THÊM VÀO GIỎ HÀNG
                </button>
            </form>

            <div class="mt-4 p-3 rounded text-center" style="background-color: #f0f7f2; border-left: 4px solid #2d6a4f;">
                <p class="mb-1 small">✅ Hàng chính hãng 100% — Bảo hành 12 tháng</p>
                <p class="mb-1 small">🚚 Giao hàng toàn quốc từ 1-5 ngày</p>
                <p class="mb-0 small">↩️ Đổi trả miễn phí trong 7 ngày nếu lỗi NSX</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

