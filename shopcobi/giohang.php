<?php
include 'header.php';

if(!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = array();
}

// 1. THÊM VÀO GIỎ
if(isset($_POST['them_gio_hang'])) {
    $id_sp  = $_POST['id_sp'];
    $ten_sp = $_POST['ten_sp'];
    $gia_sp = $_POST['gia_sp'];
    $hinh_anh = basename($_POST['hinh_anh']);
    $so_luong = (int)$_POST['so_luong'];

    // Kiểm tra tồn kho
    $kiem_tra_kho = $conn->query("SELECT SoLuongTon FROM SanPham WHERE ID_SanPham = '$id_sp'");
    $ton_kho_hien_tai = 0;
    if($kiem_tra_kho && $kiem_tra_kho->num_rows > 0){
        $row_kho = $kiem_tra_kho->fetch_assoc();
        $ton_kho_hien_tai = (int)$row_kho['SoLuongTon'];
    }

    $kiem_tra = false;
    for ($i = 0; $i < count($_SESSION['giohang']); $i++) {
        if ($_SESSION['giohang'][$i]['id'] == $id_sp) {
            $sl_moi = $_SESSION['giohang'][$i]['soluong'] + $so_luong;
            $_SESSION['giohang'][$i]['soluong'] = ($sl_moi > $ton_kho_hien_tai) ? $ton_kho_hien_tai : $sl_moi;
            $kiem_tra = true;
            break;
        }
    }
    if (!$kiem_tra) {
        if($so_luong > $ton_kho_hien_tai) $so_luong = $ton_kho_hien_tai;
        $_SESSION['giohang'][] = array('id' => $id_sp, 'ten' => $ten_sp, 'gia' => $gia_sp, 'hinhanh' => $hinh_anh, 'soluong' => $so_luong);
    }
    echo "<script>window.location.href='giohang.php';</script>";
}

// 2. TĂNG / GIẢM
if(isset($_GET['action']) && isset($_GET['id_update'])) {
    $action = $_GET['action'];
    $id_update = $_GET['id_update'];

    $res_kho = $conn->query("SELECT SoLuongTon FROM SanPham WHERE ID_SanPham = '$id_update'");
    $ton_kho = 0;
    if($res_kho && $res_kho->num_rows > 0){ $row_k = $res_kho->fetch_assoc(); $ton_kho = (int)$row_k['SoLuongTon']; }

    for ($i = 0; $i < count($_SESSION['giohang']); $i++) {
        if ($_SESSION['giohang'][$i]['id'] == $id_update) {
            if ($action == 'tang') {
                if($_SESSION['giohang'][$i]['soluong'] < $ton_kho) {
                    $_SESSION['giohang'][$i]['soluong']++;
                } else {
                    echo "<script>alert('Chỉ còn tối đa $ton_kho chiếc trong kho!');</script>";
                }
            } elseif ($action == 'giam') {
                $_SESSION['giohang'][$i]['soluong']--;
                if ($_SESSION['giohang'][$i]['soluong'] <= 0) {
                    array_splice($_SESSION['giohang'], $i, 1);
                }
            }
            break;
        }
    }
    echo "<script>window.location.href='giohang.php';</script>";
}

// 3. XÓA
if(isset($_GET['xoa'])) {
    $id_xoa = $_GET['xoa'];
    for ($i = 0; $i < count($_SESSION['giohang']); $i++) {
        if ($_SESSION['giohang'][$i]['id'] == $id_xoa) {
            array_splice($_SESSION['giohang'], $i, 1); break;
        }
    }
    echo "<script>window.location.href='giohang.php';</script>";
}
?>

<div class="container my-5 pt-4 pb-5">
    <h2 class="text-center mb-5 brand-text" style="font-size: 2.5rem;">Giỏ Hàng Của Bạn</h2>

    <?php if(count($_SESSION['giohang']) > 0): ?>
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered align-middle text-center mb-0 bg-white">
                <thead class="text-white" style="background-color: #1a3a2a;">
                    <tr>
                        <th>Hình Ảnh</th>
                        <th>Sản Phẩm</th>
                        <th>Đơn Giá</th>
                        <th style="width: 150px;">Số Lượng</th>
                        <th>Thành Tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tong_tien = 0;
                    $co_loi_kho = false;

                    foreach($_SESSION['giohang'] as $key => $sp): 
                        $id_hien_tai = $sp['id'];
                        $check_kho = $conn->query("SELECT SoLuongTon FROM SanPham WHERE ID_SanPham = '$id_hien_tai'");
                        $kho_thuc_te = 0;
                        if($check_kho && $check_kho->num_rows > 0){
                            $r = $check_kho->fetch_assoc();
                            $kho_thuc_te = (int)$r['SoLuongTon'];
                        }

                        if($sp['soluong'] > $kho_thuc_te) {
                            $_SESSION['giohang'][$key]['soluong'] = $kho_thuc_te;
                            $sp['soluong'] = $kho_thuc_te;
                            $co_loi_kho = true;
                        }

                        $thanh_tien = $sp['gia'] * $sp['soluong'];
                        $tong_tien += $thanh_tien;
                        $anh_hien_thi = 'images/' . basename($sp['hinhanh']);
                    ?>
                        <tr>
                            <td><img src="<?php echo $anh_hien_thi; ?>" alt="SP" style="width: 80px; height: 80px; object-fit: contain; border-radius: 4px;"></td>
                            <td class="fw-bold text-start">
                                <?php echo $sp['ten']; ?>
                                <?php if($kho_thuc_te == 0): ?><br><span class="badge bg-danger">Hết hàng</span><?php endif; ?>
                            </td>
                            <td style="color: #2d6a4f; font-weight: 600;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?> đ</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="giohang.php?action=giam&id_update=<?php echo $sp['id']; ?>" class="btn btn-sm d-flex justify-content-center align-items-center fw-bold" style="width:30px;height:30px;border:1px solid #1a3a2a;color:#1a3a2a;text-decoration:none;">-</a>
                                    <input type="text" class="form-control text-center mx-2 p-0 border-0 fw-bold" value="<?php echo $sp['soluong']; ?>" readonly style="width:40px;background:transparent;">
                                    <a href="giohang.php?action=tang&id_update=<?php echo $sp['id']; ?>" class="btn btn-sm d-flex justify-content-center align-items-center fw-bold" style="width:30px;height:30px;border:1px solid #1a3a2a;color:#1a3a2a;text-decoration:none;">+</a>
                                </div>
                            </td>
                            <td class="fw-bold text-danger"><?php echo number_format($thanh_tien, 0, ',', '.'); ?> đ</td>
                            <td><a href="giohang.php?xoa=<?php echo $sp['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa sản phẩm này?')">X</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if($co_loi_kho): ?>
            <div class="alert alert-warning mt-3">
                <i class="bi bi-exclamation-triangle-fill text-warning"></i> Hệ thống đã tự động điều chỉnh số lượng do kho không đủ hàng.
            </div>
        <?php endif; ?>

        <div class="row mt-4 align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <a href="index.php" class="btn btn-outline-dark px-4 py-2">← TIẾP TỤC MUA SẮM</a>
            </div>
            <div class="col-md-6 text-md-end text-center">
                <h4 class="mb-3">Tổng cộng: <span class="fw-bold fs-2" style="color: #2d6a4f;"><?php echo number_format($tong_tien, 0, ',', '.'); ?> đ</span></h4>
                <a href="thanhtoan.php" class="btn text-white px-5 py-3 fw-bold" style="background-color: #1a3a2a; letter-spacing: 1px;">TIẾN HÀNH THANH TOÁN</a>
            </div>
        </div>

    <?php else: ?>
        <div class="alert text-center py-5 shadow-sm border-0" style="background-color: #f0f7f2;">
            <i class="bi bi-cart-x" style="font-size: 3rem; color: #2d6a4f;"></i>
            <h4 class="mb-3 mt-3">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-muted mb-4">Hãy chọn những cây cơ bi ưng ý và quay lại đây nhé.</p>
            <a href="index.php" class="btn text-white px-4 py-2" style="background-color: #1a3a2a;">🎱 MUA SẮM NGAY</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

