<?php 
include 'header.php'; 

// Truy vấn Top sản phẩm bán chạy
$sql_banchay = "SELECT sp.*, COALESCE(SUM(ct.SoLuong), 0) AS TongBan 
                FROM SanPham sp 
                LEFT JOIN ChiTietDonHang ct ON sp.ID_SanPham = ct.ID_SanPham 
                GROUP BY sp.ID_SanPham 
                ORDER BY TongBan DESC 
                LIMIT 6";
$res_banchay = $conn->query($sql_banchay);
?>

<!-- TOP BANNER FLASH SALE -->
<div style="background: linear-gradient(90deg, #1a3a2a 0%, #2d6a4f 100%); color: white; padding: 12px 15px; position: relative; z-index: 1000; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
    <div class="container d-flex flex-column flex-md-row justify-content-center align-items-center text-center">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <span class="badge fw-bold fs-6 me-3" style="background-color: #c9a84c; color: #1a1a1a; animation: pulse 1.5s infinite;">🎱 KHAI TRƯƠNG</span>
            <span class="fw-bold" style="letter-spacing: 1px; font-size: 0.95rem;">GIẢM ĐẾN 30% TẤT CẢ CƠ BI NHÂN DỊP KHAI TRƯƠNG — SỐ LƯỢNG CÓ HẠN!</span>
        </div>
<a href="khuyenmai.php" class="btn btn-sm fw-bold ms-md-4 mt-2 mt-md-0" style="color: #1a3a2a; background-color: #c9a84c; border-radius: 20px; padding: 5px 20px; text-transform: uppercase; letter-spacing: 1px;">
    Mua Ngay <i class="bi bi-caret-right-fill"></i>
</a>
    </div>
</div>

<style>
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .hero-carousel-item { min-height: 500px; display: flex; align-items: center; width: 100%; }
    .carousel-control-prev, .carousel-control-next { width: 5%; opacity: 1; }
    .carousel-btn-box {
        background-color: #1a3a2a; width: 45px; height: 45px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; transition: 0.3s;
    }
    .carousel-btn-box:hover { background-color: #c9a84c; }
    .brand-product-list { animation: fadeIn 0.5s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .scroll-horizontal {
        display: flex; flex-wrap: nowrap; overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; -ms-overflow-style: none;
        padding-bottom: 15px;
    }
    .scroll-horizontal::-webkit-scrollbar { display: none; }
    .serif-font { font-family: 'Playfair Display', serif; }

    .marquee-container {
        width: 100%; overflow: hidden;
        background-color: #1a3a2a; padding: 14px 0;
        display: flex; align-items: center;
    }
    .marquee-content {
        display: inline-block; white-space: nowrap;
        animation: marquee-scroll 28s linear infinite;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem; color: #c9a84c;
        letter-spacing: 3px; text-transform: uppercase; font-weight: 600;
    }
    .marquee-content span { margin: 0 40px; }
    @keyframes marquee-scroll {
        0% { transform: translateX(100vw); }
        100% { transform: translateX(-100%); }
    }
</style>

<!-- 1. BANNER SLIDER -->
<div id="mainHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500">
    <div class="carousel-inner">

        <!-- SLIDE 1: Mezz -->
        <div class="carousel-item active">
            <div class="container-fluid p-0">
                <div class="row g-0" style="background-color: #0f2318; min-height: 520px;">
                    <div class="col-md-6 p-0 d-flex justify-content-center align-items-center" style="background-color: #1a3a2a;">
                        <img src="images/baner1.jpg" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop'" class="w-100" style="height: 520px; object-fit: cover;" alt="Mezz">
                    </div>
                    <div class="col-md-6 d-flex align-items-center p-5" style="background-color: #0f2318;">
                        <div style="max-width: 520px; margin: 0 auto;">
                            <h5 class="text-uppercase mb-3" style="letter-spacing: 2px; font-size: 1rem; color: #c9a84c; font-weight: 600;">MEZZ CUES — NHẬT BẢN</h5>
                            <h1 class="brand-text mb-4" style="font-size: 3.5rem; line-height: 1.15; color: #fff; font-weight: 700; letter-spacing: -1px;">
                                Cơ Mezz<br>EC7-WH<br><span style="color: #c9a84c;">Đỉnh Cao<br>Tinh Xảo</span>
                            </h1>
                            <p class="mb-5" style="font-size: 1rem; line-height: 1.7; color: #aaa;">
                                Crafted with Japanese precision — Cơ bi Mezz được làm từ gỗ maple cao cấp, khớp nối Uni-Loc, joint cứng vững, đem lại cảm giác đánh hoàn hảo cho mọi level.
                            </p>
                            <a href="sanpham.php" class="btn d-inline-flex justify-content-between align-items-center" style="background-color: #c9a84c; color: #1a1a1a; border-radius: 0; padding: 15px 25px; font-weight: 700; font-size: 0.95rem; letter-spacing: 1px; width: 230px; border: none;">
                                <span>KHÁM PHÁ NGAY</span><span>→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 2: Predator -->
        <div class="carousel-item">
            <div class="container-fluid p-0">
                <div class="row g-0" style="background-color: #1c1200; min-height: 520px;">
                    <div class="col-md-6 p-0 d-flex justify-content-center align-items-center" style="background-color: #2e1f00;">
                        <img src="images/baner2.jpg" onerror="this.src='https://images.unsplash.com/photo-1555680202-c86f0e12f086?w=800&h=600&fit=crop'" class="w-100" style="height: 520px; object-fit: cover;" alt="Predator">
                    </div>
                    <div class="col-md-6 d-flex align-items-center p-5" style="background-color: #1c1200;">
                        <div style="max-width: 520px; margin: 0 auto;">
                            <h5 class="text-uppercase mb-3" style="letter-spacing: 2px; font-size: 1rem; color: #f5c518; font-weight: 600;">PREDATOR CUES — MỸ</h5>
                            <h1 class="brand-text mb-4" style="font-size: 3.5rem; line-height: 1.15; color: #fff; font-weight: 700;">
                                Predator<br>REVO 12.4<br><span style="color: #f5c518;">Công Nghệ<br>Carbon Fiber</span>
                            </h1>
                            <p class="mb-5" style="font-size: 1rem; line-height: 1.7; color: #aaa;">
                                Shaft carbon fiber tiên tiến nhất thế giới — Độ thẳng vĩnh cửu, cảm giác đánh vượt trội. Lựa chọn của các pro player hàng đầu tại World Pool Championship.
                            </p>
                            <a href="sanpham.php" class="btn d-inline-flex justify-content-between align-items-center" style="background-color: #f5c518; color: #1a1a1a; border-radius: 0; padding: 15px 25px; font-weight: 700; font-size: 0.95rem; letter-spacing: 1px; width: 230px; border: none;">
                                <span>KHÁM PHÁ NGAY</span><span>→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 3: Viking -->
        <div class="carousel-item">
            <div class="container-fluid p-0">
                <div class="row g-0" style="background-color: #0a1628; min-height: 520px;">
                    <div class="col-md-6 p-0 d-flex justify-content-center align-items-center" style="background-color: #0d2040;">
                        <img src="images/baner3.webp" onerror="this.src='https://images.unsplash.com/photo-1567581935884-3349723552ca?w=800&h=600&fit=crop'" class="w-100" style="height: 520px; object-fit: cover;" alt="Viking">
                    </div>
                    <div class="col-md-6 d-flex align-items-center p-5" style="background-color: #0a1628;">
                        <div style="max-width: 520px; margin: 0 auto;">
                            <h5 class="text-uppercase mb-3" style="letter-spacing: 2px; font-size: 1rem; color: #87ceeb; font-weight: 600;">VIKING CUES — MỸ</h5>
                            <h1 class="brand-text mb-4" style="font-size: 3.5rem; line-height: 1.15; color: #fff; font-weight: 700;">
                                Viking<br>A775<br><span style="color: #87ceeb;">Giá Tốt<br>Chất Lượng</span>
                            </h1>
                            <p class="mb-5" style="font-size: 1rem; line-height: 1.7; color: #aaa;">
                                Thương hiệu cơ bi uy tín 50 năm từ Mỹ. Phù hợp cho người mới bắt đầu đến trung cấp, chất gỗ maple chuẩn, giá cả hợp lý — Sự lựa chọn thông minh.
                            </p>
                            <a href="sanpham.php" class="btn d-inline-flex justify-content-between align-items-center" style="background-color: #87ceeb; color: #0a1628; border-radius: 0; padding: 15px 25px; font-weight: 700; font-size: 0.95rem; letter-spacing: 1px; width: 230px; border: none;">
                                <span>KHÁM PHÁ NGAY</span><span>→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 4: McDermott -->
        <div class="carousel-item">
            <div class="container-fluid p-0">
                <div class="row g-0" style="background-color: #1a0a00; min-height: 520px;">
                    <div class="col-md-6 p-0 d-flex justify-content-center align-items-center" style="background-color: #2e1500;">
                        <img src="images/baner4.webp" onerror="this.src='https://images.unsplash.com/photo-1591491634026-62f0e24b0ba4?w=800&h=600&fit=crop'" class="w-100" style="height: 520px; object-fit: cover;" alt="McDermott">
                    </div>
                    <div class="col-md-6 d-flex align-items-center p-5" style="background-color: #1a0a00;">
                        <div style="max-width: 520px; margin: 0 auto;">
                            <h5 class="text-uppercase mb-3" style="letter-spacing: 2px; font-size: 1rem; color: #cd7f32; font-weight: 600;">McDERMOTT CUES — MỸ</h5>
                            <h1 class="brand-text mb-4" style="font-size: 3.5rem; line-height: 1.15; color: #fff; font-weight: 700;">
                                McDermott<br>G228<br><span style="color: #cd7f32;">Handcrafted<br>In USA</span>
                            </h1>
                            <p class="mb-5" style="font-size: 1rem; line-height: 1.7; color: #aaa;">
                                Mỗi chiếc cơ McDermott là một tác phẩm nghệ thuật được thủ công tại Mỹ. Gỗ North American Hard Rock Maple, khảm trai, điêu khắc tinh xảo — biểu tượng đẳng cấp.
                            </p>
                            <a href="sanpham.php" class="btn d-inline-flex justify-content-between align-items-center" style="background-color: #cd7f32; color: #fff; border-radius: 0; padding: 15px 25px; font-weight: 700; font-size: 0.95rem; letter-spacing: 1px; width: 230px; border: none;">
                                <span>KHÁM PHÁ NGAY</span><span>→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainHeroCarousel" data-bs-slide="prev">
            <div class="carousel-btn-box shadow"><i class="bi bi-chevron-left fs-5"></i></div>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainHeroCarousel" data-bs-slide="next">
            <div class="carousel-btn-box shadow"><i class="bi bi-chevron-right fs-5"></i></div>
        </button>
    </div>
</div>

<!-- 2. DANH SÁCH SẢN PHẨM THEO HÃNG -->
<div class="container my-5 pt-5" style="min-height: 600px;">
    <h2 class="text-center mb-5 brand-text" style="font-size: 2.5rem;" id="danhMucTieuDe">Khám Phá Sản Phẩm Mezz</h2>
    
    <?php
    $thuonghieu_list = ['Mezz', 'Predator', 'Viking', 'McDermott'];
    
    foreach ($thuonghieu_list as $index => $th) {
        $displayClass = ($index == 0) ? '' : 'd-none';
        echo "<div class='row brand-product-list $displayClass' id='brand-products-$index'>";
        
        $sql = "SELECT ID_SanPham, TenSanPham, Gia, HinhAnh FROM SanPham WHERE ThuongHieu = '$th' LIMIT 8";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $anhHienThi = 'images/' . $row['HinhAnh'];
                if(!file_exists($anhHienThi)) $anhHienThi = 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=500&fit=crop';
    ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="chitiet.php?id=<?php echo $row['ID_SanPham']; ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 text-center border-0 shadow-sm" style="transition: 0.3s;">
                        <div class="p-4" style="background-color: #f8f9fa;">
                            <img src="<?php echo $anhHienThi; ?>" class="card-img-top product-img" style="object-fit: contain; height: 220px;" alt="Ảnh SP">
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <h6 class="product-title" style="font-size: 0.95rem; color: #333; line-height: 1.5;"><?php echo $row['TenSanPham']; ?></h6>
                            <p class="product-price mt-2 mb-0 fw-bold" style="color: #2d6a4f; font-size: 1.1rem;"><?php echo number_format($row['Gia'], 0, ',', '.'); ?> đ</p>
                        </div>
                    </div>
                </a>
            </div>
    <?php 
            } 
        } else {
            echo "<div class='alert alert-warning text-center w-100'>Chưa có sản phẩm $th. Quay lại sau nhé!</div>";
        }
        echo "</div>"; 
    }
    ?>
</div>
<!-- 3. BANNER GIỚI THIỆU PHỤ KIỆN -->
<div class="container-fluid my-5 p-0">
    <div class="row g-0" style="background-color: #f0f7f2; min-height: 400px;">
        <div class="col-md-6 p-5 d-flex flex-column justify-content-center text-center text-md-start">
            <h5 class="fw-bold mb-3" style="letter-spacing: 2px; color: #2d6a4f;">PHỤ KIỆN CAO CẤP</h5>
            <h2 class="display-5 fw-bold mb-4" style="color: #1a3a2a;">Đầy Đủ Phụ Kiện<br>Cho Dân Chơi Bida</h2>
            <p class="lead mb-4" style="color: #555;">Bao cơ, phấn bi Triangle & Master, găng tay, cầu bi, đế cơ — tất cả đều có tại Shop Co Bida với giá tốt nhất thị trường.</p>
            <div>
                <a href="danhmuc.php?id=3" class="btn btn-dark px-4 py-3" style="border-radius: 0; letter-spacing: 1px; font-weight: 500; background-color: #1a3a2a;">
                    XEM PHỤ KIỆN →
                </a>
            </div>
        </div>
        <div class="col-md-6 p-0 position-relative" style="min-height: 400px; background-color: #1a3a2a; display: flex; align-items: center; justify-content: center;">
            <img src="images/phukien.jpg" onerror="this.src='https://images.unsplash.com/photo-1587329310686-91414b8e3cb7?w=800&h=400&fit=crop'" class="w-100 h-100" style="object-fit: cover; opacity: 0.85;">
        </div>
    </div>
</div>

<!-- 4. SẢN PHẨM BÁN CHẠY -->
<div class="container-fluid py-5" style="background-color: #f8faf8;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-md-3 mb-5 mb-md-0 pe-md-4">
                <h1 class="serif-font fw-bold" style="font-size: 3.5rem; line-height: 1.1; color: #1a3a2a;">
                    Sản phẩm<br>
                    <span class="text-uppercase" style="font-size: 2.8rem; color: #2d6a4f;">Bán Chạy</span>
                </h1>
                <p class="text-muted mt-4" style="font-size: 0.95rem; line-height: 1.7;">
                    CueMaster tự hào cung cấp những cây cơ bi và phụ kiện được tin tưởng bởi hàng nghìn tay cơ trên toàn quốc.
                </p>
            </div>

            <div class="col-md-9">
                <div class="scroll-horizontal">
                    <?php 
                    if ($res_banchay && $res_banchay->num_rows > 0) {
                        while ($row = $res_banchay->fetch_assoc()) {
                            $id_sp = $row['ID_SanPham'];
                            $ten_sp = $row['TenSanPham'];
                            $gia_sp = number_format($row['Gia'], 0, ',', '.') . ' đ';
                            
                            $anh_sp = 'images/' . $row['HinhAnh'];
                            if (!file_exists($anh_sp) || empty($row['HinhAnh'])) {
                                $anh_sp = 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop';
                            }

                            $mo_ta_ngan = mb_substr(strip_tags($row['MoTa']), 0, 50) . '...';
                    ?>
                    <div class="col-10 col-sm-6 col-lg-4 flex-shrink-0 pe-3 pe-lg-4">
                        <div class="card h-100 border-0 bg-transparent">
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="background-color: #e8f5e9; height: 280px; border-radius: 6px;">
                                <img src="<?php echo $anh_sp; ?>" class="img-fluid" style="max-height: 220px; object-fit: contain;" alt="<?php echo $ten_sp; ?>">
                            </div>
                            <div class="card-body px-0 pb-0 d-flex justify-content-between align-items-end">
                                <div class="pe-2">
                                    <h6 class="card-title fw-bold mb-1 text-dark" style="font-size: 0.95rem; line-height: 1.4;"><?php echo $ten_sp; ?></h6>
                                    <p class="text-muted mb-3" style="font-size: 0.75rem;"><?php echo $mo_ta_ngan; ?></p>
                                    <div class="fw-bold" style="font-size: 1rem; color: #2d6a4f;"><?php echo $gia_sp; ?></div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Đã bán <?php echo $row['TongBan']; ?></small>
                                </div>
                                <form action="giohang.php" method="POST" class="m-0">
                                    <input type="hidden" name="id_sp" value="<?php echo $id_sp; ?>">
                                    <input type="hidden" name="ten_sp" value="<?php echo $ten_sp; ?>">
                                    <input type="hidden" name="gia_sp" value="<?php echo $row['Gia']; ?>">
                                    <input type="hidden" name="hinh_anh" value="<?php echo $anh_sp; ?>">
                                    <input type="hidden" name="so_luong" value="1">
                                    <button type="submit" name="them_gio_hang" class="btn border-0 shadow-sm" style="background-color: #2d6a4f; border-radius: 4px; padding: 10px 12px; transition: 0.2s;">
                                        <i class="bi bi-bag-plus text-white"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5. BANNER ĐĂNG KÝ / CTA -->
<div class="container-fluid text-center text-white" style="background: linear-gradient(rgba(26,58,42,0.88), rgba(26,58,42,0.88)), url('https://images.unsplash.com/photo-1567581935884-3349723552ca?w=1600&h=600&fit=crop'); background-size: cover; background-position: center; padding: 80px 15px;">
    <h5 class="text-uppercase mb-3" style="letter-spacing: 2px; color: #c9a84c; font-weight: 600;">Ưu Đãi Thành Viên</h5>
    <h1 class="serif-font fw-bold mb-3" style="font-size: 3rem; letter-spacing: 1px; color: #fff;">
        ĐĂNG KÝ — NHẬN NGAY 50K
    </h1>
    <p class="mb-5 mx-auto" style="font-size: 1.1rem; line-height: 1.6; opacity: 0.9; max-width: 650px;">
        Tạo tài khoản CueMaster hôm nay, nhận ngay voucher 50.000đ cho đơn hàng đầu tiên và ưu đãi thành viên độc quyền mỗi tháng.
    </p>
    <a href="dangky.php" class="btn rounded-0 px-5 py-3 fw-bold shadow-sm" style="background-color: #c9a84c; color: #1a1a1a; letter-spacing: 1px; border: none; font-size: 1.05rem;">
        ĐĂNG KÝ MIỄN PHÍ
    </a>
</div>

<!-- 6. MARQUEE -->
<div class="marquee-container">
    <div class="marquee-content">
        <span>🎱 CUEMASTER — THIÊN ĐƯỜNG CƠ BI VIỆT NAM</span>
        <span>🏆 PHÂN PHỐI CHÍNH HÃNG MEZZ, PREDATOR, VIKING, McDERMOTT</span>
        <span>✅ BẢO HÀNH 12 THÁNG CHÍNH HÃNG</span>
        <span>🚚 FREESHIP ĐƠN TỪ 500K TOÀN QUỐC</span>
        <span>🎱 CUEMASTER — THIÊN ĐƯỜNG CƠ BI VIỆT NAM</span>
        <span>🏆 PHÂN PHỐI CHÍNH HÃNG MEZZ, PREDATOR, VIKING, McDERMOTT</span>
        <span>✅ BẢO HÀNH 12 THÁNG CHÍNH HÃNG</span>
        <span>🚚 FREESHIP ĐƠN TỪ 500K TOÀN QUỐC</span>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myCarousel = document.getElementById('mainHeroCarousel');
        var tieuDe = document.getElementById('danhMucTieuDe');
        var tenCacHang = ['Mezz', 'Predator', 'Viking', 'McDermott'];

        myCarousel.addEventListener('slide.bs.carousel', function (e) {
            var nextIndex = e.to;
            tieuDe.innerHTML = "Khám Phá Sản Phẩm " + tenCacHang[nextIndex];

            var allLists = document.querySelectorAll('.brand-product-list');
            allLists.forEach(function(list) { list.classList.add('d-none'); });
            
            var activeList = document.getElementById('brand-products-' + nextIndex);
            if(activeList) { activeList.classList.remove('d-none'); }
        });
    });
</script>

<?php include 'footer.php'; ?>

