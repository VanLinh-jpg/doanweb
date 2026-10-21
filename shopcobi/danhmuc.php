<?php 
// 1. Nhúng file kết nối CSDL nếu trong header.php chưa có
require_once 'connect.php'; 

// 2. Đảm bảo kết nối sử dụng UTF-8
if (isset($conn)) {
    $conn->set_charset("utf8mb4");
}

// 3. Lấy ID danh mục từ URL
$id_dm = isset($_GET['id']) ? intval($_GET['id']) : 0;
$ten_danh_muc = "Sản Phẩm";

// 4. Lấy tên danh mục nếu id > 0
if ($id_dm > 0 && isset($conn)) {
    $stmt = $conn->prepare("SELECT TenDanhMuc FROM DanhMuc WHERE ID_DanhMuc = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id_dm);
        $stmt->execute();
        $res_ten = $stmt->get_result();
        if ($res_ten && $res_ten->num_rows > 0) {
            $ten_danh_muc = $res_ten->fetch_assoc()['TenDanhMuc'];
        }
        $stmt->close();
    }
}

include 'header.php'; 
?>

<div class="container my-5 pt-4">
    <h2 class="text-center mb-5 brand-text" style="font-size: 2.5rem; color: #1a3a2a; font-weight: bold;">
        <?php echo htmlspecialchars($ten_danh_muc); ?>
    </h2>

    <div class="row">
        <?php
        if (isset($conn)) {
            // Truy vấn lấy danh sách sản phẩm theo danh mục
            if ($id_dm > 0) {
                $sql = "SELECT ID_SanPham, TenSanPham, Gia, HinhAnh FROM SanPham WHERE ID_DanhMuc = ? ORDER BY ID_SanPham DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_dm);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $sql = "SELECT ID_SanPham, TenSanPham, Gia, HinhAnh FROM SanPham ORDER BY ID_SanPham DESC";
                $result = $conn->query($sql);
            }

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Kiểm tra đường dẫn ảnh
                    $hinh_anh = !empty($row['HinhAnh']) ? $row['HinhAnh'] : 'default.jpg';
                    $anh = 'images/' . $hinh_anh;
                    
                    if (!file_exists($anh)) {
                        $anh = 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=500&fit=crop';
                    }
        ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <a href="chitiet.php?id=<?php echo $row['ID_SanPham']; ?>" class="text-decoration-none text-dark">
                            <div class="card product-card h-100 text-center border-0 shadow-sm" style="transition: transform 0.2s;">
                                <div class="p-3" style="background:#f8f9fa; border-radius: 8px 8px 0 0;">
                                    <img src="<?php echo $anh; ?>" class="card-img-top" style="object-fit:contain; height:200px;" alt="<?php echo htmlspecialchars($row['TenSanPham']); ?>">
                                </div>
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h6 class="product-title fw-bold text-truncate mb-2"><?php echo htmlspecialchars($row['TenSanPham']); ?></h6>
                                    <p class="product-price mt-auto mb-0 fw-bold" style="color:#2d6a4f; font-size: 1.1rem;">
                                        <?php echo number_format($row['Gia'], 0, ',', '.'); ?> đ
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
        <?php
                }
            } else {
                echo "<div class='col-12'><div class='alert alert-warning text-center w-100 my-4'>Danh mục này hiện chưa có sản phẩm nào.</div></div>";
            }
        } else {
            echo "<div class='col-12'><div class='alert alert-danger text-center w-100 my-4'>Lỗi: Không thể kết nối đến cơ sở dữ liệu!</div></div>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>