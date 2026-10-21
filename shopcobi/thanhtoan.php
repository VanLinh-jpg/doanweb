<?php 
include 'header.php'; 

if(!isset($_SESSION['ID_User'])) {
    echo "<script>alert('Vui lòng đăng nhập để đặt hàng!'); window.location.href='dangnhap.php';</script>";
    exit;
}

if(empty($_SESSION['giohang'])) {
    echo "<script>alert('Giỏ hàng đang trống!'); window.location.href='giohang.php';</script>";
    exit;
}

$hoTen_san = $_SESSION['HoTen'];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dat_hang'])) {
    $hoten      = $conn->real_escape_string($_POST['hoten']);
    $sdt        = $conn->real_escape_string($_POST['sdt']);
    $tinh_thanh = $conn->real_escape_string($_POST['tinh_thanh']);
    $quan_huyen = $conn->real_escape_string($_POST['quan_huyen']);
    $dia_chi    = $conn->real_escape_string($_POST['dia_chi']);
    $ghi_chu    = $conn->real_escape_string($_POST['ghi_chu']);
    $pt_thanhtoan = $conn->real_escape_string($_POST['pt_thanhtoan']);
    $dia_chi_day_du = $dia_chi . ", " . $quan_huyen . ", " . $tinh_thanh;

    $tong_tien = 0;
    foreach($_SESSION['giohang'] as $sp) {
        $tong_tien += ($sp['gia'] * $sp['soluong']);
    }

    $id_user_sql = $_SESSION['ID_User'];

    $sql_donhang = "INSERT INTO DonHang (ID_User, HoTenGiaoHang, SDTGiaoHang, DiaChiGiaoHang, GhiChu, PhuongThucThanhToan, TongTien, TrangThai) 
                    VALUES ($id_user_sql, '$hoten', '$sdt', '$dia_chi_day_du', '$ghi_chu', '$pt_thanhtoan', $tong_tien, 'Chờ xử lý')";
    
    if($conn->query($sql_donhang) === TRUE) {
        $id_donhang = $conn->insert_id;

        foreach($_SESSION['giohang'] as $sp) {
            $id_sp_db  = $conn->real_escape_string($sp['id']);
            $soluong_db = $sp['soluong'];
            $giaban_db  = $sp['gia'];
            $conn->query("INSERT INTO ChiTietDonHang (ID_DonHang, ID_SanPham, SoLuong, GiaBan) VALUES ($id_donhang, '$id_sp_db', $soluong_db, $giaban_db)");
        }

        unset($_SESSION['giohang']);
        echo "<script>alert('🎉 ĐẶT HÀNG THÀNH CÔNG!\\n\\nMã đơn: #$id_donhang\\nGiao đến: $dia_chi_day_du\\nChúng tôi sẽ liên hệ xác nhận qua số $sdt.'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Lỗi khi đặt hàng: " . $conn->error . "');</script>";
    }
}
?>

<div class="container my-5 pt-4 pb-5">
    <h2 class="text-center mb-5 brand-text" style="font-size: 2.5rem;">Thanh Toán Đơn Hàng</h2>
    
    <form action="thanhtoan.php" method="POST">
        <div class="row">
            
            <!-- THÔNG TIN GIAO HÀNG -->
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white fw-bold py-3" style="background-color: #1a3a2a;">
                        <i class="bi bi-geo-alt-fill me-2" style="color: #c9a84c;"></i> THÔNG TIN GIAO HÀNG
                    </div>
                    <div class="card-body p-4 bg-light">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Họ và Tên <span class="text-danger">*</span></label>
                                <input type="text" name="hoten" class="form-control" value="<?php echo $hoTen_san; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="sdt" class="form-control" required placeholder="0909 xxx xxx">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                <select name="tinh_thanh" id="province" class="form-select" required>
                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quận / Huyện <span class="text-danger">*</span></label>
                                <select name="quan_huyen" id="district" class="form-select" required>
                                    <option value="">-- Chọn Quận/Huyện --</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                            <input type="text" name="dia_chi" class="form-control" required placeholder="Số nhà, Tên đường, Phường/Xã...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ghi chú (Tùy chọn)</label>
                            <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi giao..."></textarea>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Phương thức thanh toán</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="pt_thanhtoan" id="cod" value="Thanh toán khi nhận hàng (COD)" checked>
                            <label class="form-check-label" for="cod">Thanh toán tiền mặt khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pt_thanhtoan" id="bank" value="Chuyển khoản ngân hàng">
                            <label class="form-check-label" for="bank">Chuyển khoản ngân hàng (Nhân viên sẽ liên hệ xác nhận)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TÓM TẮT ĐƠN HÀNG -->
            <div class="col-md-5">
                <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                    <div class="card-header text-white fw-bold py-3" style="background-color: #1a3a2a;">
                        <i class="bi bi-bag-check-fill me-2" style="color: #c9a84c;"></i> TÓM TẮT ĐƠN HÀNG
                    </div>
                    <div class="card-body p-4">
                        <?php 
                        $tong_tien_hien_thi = 0;
                        foreach($_SESSION['giohang'] as $sp): 
                            $thanh_tien = $sp['gia'] * $sp['soluong'];
                            $tong_tien_hien_thi += $thanh_tien;
                            $anh_hien_thi = 'images/' . basename($sp['hinhanh']);
                        ?>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $anh_hien_thi; ?>" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=100&h=100&fit=crop'" style="width:55px;height:55px;object-fit:contain;border-radius:4px;border:1px solid #eee;" class="me-3">
                                    <div>
                                        <h6 class="mb-1" style="font-size:0.9rem;font-weight:600;"><?php echo $sp['ten']; ?></h6>
                                        <small class="text-muted">SL: <?php echo $sp['soluong']; ?></small>
                                    </div>
                                </div>
                                <div class="fw-bold ms-2" style="color:#2d6a4f;white-space:nowrap;"><?php echo number_format($thanh_tien, 0, ',', '.'); ?> đ</div>
                            </div>
                        <?php endforeach; ?>

                        <div class="d-flex justify-content-between mt-4 mb-2">
                            <h5 class="fw-bold mb-0">TỔNG CỘNG:</h5>
                            <h3 class="fw-bold mb-0" style="color: #2d6a4f;"><?php echo number_format($tong_tien_hien_thi, 0, ',', '.'); ?> đ</h3>
                        </div>
                        <p class="text-end text-muted small mb-4">(Miễn phí vận chuyển cho đơn từ 500K)</p>

                        <button type="submit" name="dat_hang" class="btn text-white w-100 py-3 fw-bold" style="background-color: #1a3a2a; letter-spacing: 1px; font-size: 1.1rem;">
                            🎱 XÁC NHẬN ĐẶT HÀNG
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- API Tỉnh Thành -->
<script>
    fetch('https://provinces.open-api.vn/api/?depth=2')
        .then(r => r.json())
        .then(data => {
            let pSel = document.getElementById('province');
            let dSel = document.getElementById('district');
            data.forEach(p => { let o = document.createElement('option'); o.value = p.name; o.dataset.code = p.code; o.text = p.name; pSel.add(o); });
            pSel.addEventListener('change', function() {
                dSel.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
                let code = this.options[this.selectedIndex].dataset.code;
                if(code) { let prov = data.find(p => p.code == code); if(prov && prov.districts) { prov.districts.forEach(d => { let o = document.createElement('option'); o.value = d.name; o.text = d.name; dSel.add(o); }); } }
            });
        });
</script>

<?php include 'footer.php'; ?>

