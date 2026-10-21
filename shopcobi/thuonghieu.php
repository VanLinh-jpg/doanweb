<?php include 'header.php'; 

$brand = isset($_GET['brand']) ? $conn->real_escape_string($_GET['brand']) : '';
?>

<div class="container my-5 pt-4">
    <h2 class="text-center mb-5 brand-text" style="font-size: 2.5rem;">
        <?php echo $brand ? "Thương Hiệu: $brand" : "Tất Cả Thương Hiệu"; ?>
    </h2>

    <div class="row">
        <?php
        $sql = $brand 
            ? "SELECT ID_SanPham, TenSanPham, Gia, HinhAnh FROM SanPham WHERE ThuongHieu = '$brand' ORDER BY ID_SanPham DESC"
            : "SELECT ID_SanPham, TenSanPham, Gia, HinhAnh FROM SanPham ORDER BY ID_SanPham DESC";
        
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $anh = 'images/' . $row['HinhAnh'];
                if(!file_exists($anh)) $anh = 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=500&fit=crop';
        ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="chitiet.php?id=<?php echo $row['ID_SanPham']; ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 text-center border-0 shadow-sm">
                        <div class="p-4" style="background:#f8f9fa;">
                            <img src="<?php echo $anh; ?>" class="card-img-top" style="object-fit:contain;height:200px;" alt="SP">
                        </div>
                        <div class="card-body">
                            <h6 class="product-title"><?php echo $row['TenSanPham']; ?></h6>
                            <p class="product-price mt-2 mb-0 fw-bold" style="color:#2d6a4f;"><?php echo number_format($row['Gia'], 0, ',', '.'); ?> đ</p>
                        </div>
                    </div>
                </a>
            </div>
        <?php
            }
        } else {
            echo "<div class='alert alert-warning text-center w-100'>Chưa có sản phẩm thương hiệu $brand. Quay lại sau nhé!</div>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>

