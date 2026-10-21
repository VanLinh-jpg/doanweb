<?php
include 'header.php';
if (!isset($_SESSION['VaiTro']) || $_SESSION['VaiTro'] !== 'Admin') {
    echo "<script>alert('⛔ Bạn không có quyền truy cập!'); window.location.href='index.php';</script>";
    exit;
}

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
}

// XÓA SẢN PHẨM
if (isset($_GET['delete_id'])) {
    $id_del = intval($_GET['delete_id']);
    $sql_del = "DELETE FROM SanPham WHERE ID_SanPham = $id_del";
    if ($conn->query($sql_del) === TRUE) {
        echo "<script>alert('✅ Đã xóa sản phẩm thành công!'); window.location='admin_sanpham.php';</script>";
    } else {
        echo "<script>alert('⛔ Không thể xóa! Sản phẩm này đã nằm trong đơn hàng.'); window.location='admin_sanpham.php';</script>";
    }
}

// THÊM SẢN PHẨM
if (isset($_POST['them_sp'])) {
    $ten       = $conn->real_escape_string($_POST['ten']);
    $gianhap   = intval($_POST['gianhap']);
    $gia       = intval($_POST['gia']);
    $tonkho    = intval($_POST['tonkho']);
    $phanloai  = $conn->real_escape_string($_POST['phanloai']);
    $thuonghieu = $conn->real_escape_string($_POST['thuonghieu']);
    $danhmuc   = intval($_POST['danhmuc']);
    $mota      = $conn->real_escape_string($_POST['mota']);

    $hinhanh = "";
    if(isset($_FILES['hinhanh_upload']) && $_FILES['hinhanh_upload']['error'] == 0) {
        $ext_allowed = ['jpg','jpeg','png','webp','gif'];
        $ext = strtolower(pathinfo($_FILES['hinhanh_upload']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, $ext_allowed)) {
            $hinhanh = time() . '_' . basename($_FILES['hinhanh_upload']['name']);
            move_uploaded_file($_FILES['hinhanh_upload']['tmp_name'], "images/" . $hinhanh);
        }
    }

    $conn->query("INSERT INTO SanPham (TenSanPham, GiaNhap, Gia, SoLuongTon, LoaiDa, ThuongHieu, ID_DanhMuc, HinhAnh, MoTa) VALUES ('$ten', $gianhap, $gia, $tonkho, '$phanloai', '$thuonghieu', $danhmuc, '$hinhanh', '$mota')");
    echo "<script>window.location='admin_sanpham.php';</script>";
}

// SỬA SẢN PHẨM
if (isset($_POST['sua_sp'])) {
    $id_sua    = intval($_POST['id_sua']);
    $ten       = $conn->real_escape_string($_POST['ten']);
    $gianhap   = intval($_POST['gianhap']);
    $gia       = intval($_POST['gia']);
    $tonkho    = intval($_POST['tonkho']);
    $phanloai  = $conn->real_escape_string($_POST['phanloai']);
    $thuonghieu = $conn->real_escape_string($_POST['thuonghieu']);
    $danhmuc   = intval($_POST['danhmuc']);
    $mota      = $conn->real_escape_string($_POST['mota']);
    $hinhanh   = $conn->real_escape_string($_POST['hinhanh_cu']);

    if(isset($_FILES['hinhanh_upload']) && $_FILES['hinhanh_upload']['error'] == 0) {
        $ext_allowed = ['jpg','jpeg','png','webp','gif'];
        $ext = strtolower(pathinfo($_FILES['hinhanh_upload']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, $ext_allowed)) {
            $hinhanh_moi = time() . '_' . basename($_FILES['hinhanh_upload']['name']);
            if(move_uploaded_file($_FILES['hinhanh_upload']['tmp_name'], "images/" . $hinhanh_moi)) {
                $hinhanh = $hinhanh_moi;
            }
        }
    }

    $conn->query("UPDATE SanPham SET TenSanPham='$ten', GiaNhap=$gianhap, Gia=$gia, SoLuongTon=$tonkho, LoaiDa='$phanloai', ThuongHieu='$thuonghieu', ID_DanhMuc=$danhmuc, HinhAnh='$hinhanh', MoTa='$mota' WHERE ID_SanPham=$id_sua");
    echo "<script>window.location='admin_sanpham.php';</script>";
}

$danh_muc_options = "";
$res_dm = $conn->query("SELECT * FROM DanhMuc");
while($row_dm = $res_dm->fetch_assoc()) {
    $danh_muc_options .= "<option value='".$row_dm['ID_DanhMuc']."'>".$row_dm['TenDanhMuc']."</option>";
}
?>

<div class="container-fluid px-4 my-5 pt-4 pb-5" style="min-height: 60vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="brand-text" style="color: #1a3a2a; font-weight: 500;">Quản Lý Sản Phẩm 🎱</h2>
        
        <div class="position-relative w-25">
            <form action="admin_sanpham.php" method="GET" class="d-flex">
                <input type="text" name="search" id="adminInputSearch" autocomplete="off" class="form-control me-2" placeholder="Tìm tên SP, Thương hiệu..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="btn" style="background-color: #1a3a2a; color: #fff;">Tìm</button>
            </form>
            <div id="adminSearchBox" class="position-absolute shadow rounded bg-white overflow-hidden border w-100 mt-1" style="z-index: 999; max-height: 350px; overflow-y: auto; display: none;"></div>
        </div>

        <div>
            <button class="btn fw-bold me-2 text-white" style="background-color: #2d6a4f;" data-bs-toggle="modal" data-bs-target="#modalThem">+ Thêm Sản Phẩm</button>
            <a href="admin.php" class="btn btn-outline-dark">← Về Dashboard</a>
        </div>
    </div>

    <div class="table-responsive shadow-sm bg-white p-3 rounded border">
        <table class="table table-hover align-middle text-center mb-0">
            <thead class="text-white" style="background-color: #1a3a2a;">
                <tr>
                    <th>STT</th>
                    <th>Hình Ảnh</th>
                    <th class="text-start">Tên Sản Phẩm</th>
                    <th>Thương Hiệu</th>
                    <th>Giá Bán</th>
                    <th>Tồn Kho</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM SanPham";
                if (!empty($search_query)) {
                    $sql .= " WHERE TenSanPham LIKE '%$search_query%' OR ThuongHieu LIKE '%$search_query%'";
                }
                $sql .= " ORDER BY ID_SanPham DESC";

                $result = $conn->query($sql);
                if($result && $result->num_rows > 0) {
                    $stt = $result->num_rows;
                    while($row = $result->fetch_assoc()) {
                        $anh = 'images/' . $row['HinhAnh'];
                        if(!file_exists($anh) || empty($row['HinhAnh'])) $anh = 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=100&h=100&fit=crop';
                        
                        $tonKho = $row['SoLuongTon'];
                        $badgeTonKho = ($tonKho > 5) ? 'bg-success' : 'bg-danger';

                        $ten_escaped      = htmlspecialchars($row['TenSanPham'], ENT_QUOTES, 'UTF-8');
                        $phanloai_escaped = htmlspecialchars($row['LoaiDa'] ?? '', ENT_QUOTES, 'UTF-8');
                        $thuonghieu_escaped = htmlspecialchars($row['ThuongHieu'] ?? '', ENT_QUOTES, 'UTF-8');
                        $hinhanh_escaped  = htmlspecialchars($row['HinhAnh'], ENT_QUOTES, 'UTF-8');
                        $mota_escaped     = htmlspecialchars($row['MoTa'] ?? '', ENT_QUOTES, 'UTF-8');
                        $ten_escaped      = str_replace(["\r\n", "\r", "\n"], "\\n", $ten_escaped);
                        $mota_escaped     = str_replace(["\r\n", "\r", "\n"], "\\n", $mota_escaped);
                ?>
                <tr>
                    <td class="fw-bold"><?php echo $stt; ?></td>
                    <td><img src="<?php echo $anh; ?>" style="width:50px;height:50px;object-fit:contain;border-radius:4px;"></td>
                    <td class="text-start fw-bold"><?php echo $row['TenSanPham']; ?></td>
                    <td><span class="badge" style="background-color: #2d6a4f;"><?php echo $row['ThuongHieu'] ?? 'Khác'; ?></span></td>
                    <td style="color: #2d6a4f; font-weight: bold;"><?php echo number_format($row['Gia'], 0, ',', '.'); ?> đ</td>
                    <td><span class="badge fs-6 <?php echo $badgeTonKho; ?>"><?php echo $tonKho; ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="suaSanPham(
                            '<?php echo $row['ID_SanPham']; ?>','<?php echo $ten_escaped; ?>',
                            '<?php echo $row['GiaNhap']; ?>','<?php echo $row['Gia']; ?>','<?php echo $row['SoLuongTon']; ?>',
                            '<?php echo $phanloai_escaped; ?>','<?php echo $thuonghieu_escaped; ?>',
                            '<?php echo $row['ID_DanhMuc']; ?>','<?php echo $hinhanh_escaped; ?>',
                            '<?php echo $mota_escaped; ?>'
                        )">Sửa</button>
                        <a href="admin_sanpham.php?delete_id=<?php echo $row['ID_SanPham']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?');" class="btn btn-sm btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php 
                        $stt--;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center py-4 text-danger fw-bold'>Không tìm thấy sản phẩm nào!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL THÊM -->
<div class="modal fade" id="modalThem" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #1a3a2a;">
                <h5 class="modal-title">Thêm Sản Phẩm Mới 🎱</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="admin_sanpham.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body row">
                    <div class="col-md-12 mb-3"><label class="fw-bold">Tên Sản Phẩm:</label><input type="text" name="ten" class="form-control" required></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Giá Nhập:</label><input type="number" name="gianhap" class="form-control" required></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Giá Bán:</label><input type="number" name="gia" class="form-control" required></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Số Lượng Tồn:</label><input type="number" name="tonkho" class="form-control" required></div>
                    
                    <div class="col-md-4 mb-3"><label class="fw-bold">Thương Hiệu:</label>
                        <select name="thuonghieu" class="form-select">
                            <option value="Mezz">Mezz</option>
                            <option value="Predator">Predator</option>
                            <option value="Viking">Viking</option>
                            <option value="McDermott">McDermott</option>
                            <option value="Khác">Khác...</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Phân Loại:</label><input type="text" name="phanloai" class="form-control" placeholder="Cơ tập, Cơ thi đấu, Phụ kiện..."></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Danh Mục:</label>
                        <select name="danhmuc" class="form-select"><?php echo $danh_muc_options; ?></select>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold text-danger">Tải Hình Ảnh Lên:</label>
                        <input type="file" name="hinhanh_upload" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-12 mb-3"><label class="fw-bold">Mô tả:</label><textarea name="mota" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" name="them_sp" class="btn text-white fw-bold" style="background-color: #2d6a4f;">Lưu Sản Phẩm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL SỬA -->
<div class="modal fade" id="modalSua" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #2d6a4f;">
                <h5 class="modal-title">Sửa Thông Tin Sản Phẩm</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="admin_sanpham.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body row">
                    <input type="hidden" name="id_sua" id="edit_id">
                    <input type="hidden" name="hinhanh_cu" id="edit_hinhanh_cu">
                    <div class="col-md-12 mb-3"><label class="fw-bold">Tên Sản Phẩm:</label><input type="text" name="ten" id="edit_ten" class="form-control" required></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Giá Nhập:</label><input type="number" name="gianhap" id="edit_gianhap" class="form-control" required></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Giá Bán:</label><input type="number" name="gia" id="edit_gia" class="form-control" required></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Số Lượng Tồn:</label><input type="number" name="tonkho" id="edit_tonkho" class="form-control" required></div>
                    
                    <div class="col-md-4 mb-3"><label class="fw-bold">Thương Hiệu:</label>
                        <select name="thuonghieu" id="edit_thuonghieu" class="form-select">
                            <option value="Mezz">Mezz</option>
                            <option value="Predator">Predator</option>
                            <option value="Viking">Viking</option>
                            <option value="McDermott">McDermott</option>
                            <option value="Khác">Khác...</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Phân Loại:</label><input type="text" name="phanloai" id="edit_phanloai" class="form-control"></div>
                    <div class="col-md-4 mb-3"><label class="fw-bold">Danh Mục:</label>
                        <select name="danhmuc" id="edit_danhmuc" class="form-select"><?php echo $danh_muc_options; ?></select>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold text-primary">Thay đổi ảnh (Bỏ trống để giữ ảnh cũ):</label>
                        <input type="file" name="hinhanh_upload" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-12 mb-3"><label class="fw-bold">Mô tả:</label><textarea name="mota" id="edit_mota" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" name="sua_sp" class="btn text-white fw-bold" style="background-color: #2d6a4f;">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function suaSanPham(id, ten, gianhap, gia, tonkho, phanloai, thuonghieu, danhmuc, hinhanh, mota) {
    let parser = new DOMParser();
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_ten').value = parser.parseFromString(ten, 'text/html').body.textContent;
    document.getElementById('edit_gianhap').value = gianhap;
    document.getElementById('edit_gia').value = gia;
    document.getElementById('edit_tonkho').value = tonkho;
    document.getElementById('edit_phanloai').value = parser.parseFromString(phanloai, 'text/html').body.textContent;
    document.getElementById('edit_thuonghieu').value = parser.parseFromString(thuonghieu, 'text/html').body.textContent;
    document.getElementById('edit_danhmuc').value = danhmuc;
    document.getElementById('edit_hinhanh_cu').value = parser.parseFromString(hinhanh, 'text/html').body.textContent;
    document.getElementById('edit_mota').value = parser.parseFromString(mota, 'text/html').body.textContent;
    new bootstrap.Modal(document.getElementById('modalSua')).show();
}

// AJAX search admin
document.addEventListener("DOMContentLoaded", function() {
    const inputSearch = document.getElementById('adminInputSearch');
    const suggestBox  = document.getElementById('adminSearchBox');
    if(inputSearch) {
        inputSearch.addEventListener('keyup', function() {
            let keyword = this.value.trim();
            if (keyword.length > 0) {
                fetch('ajax_timkiem.php?keyword=' + encodeURIComponent(keyword))
                    .then(r => r.text()).then(data => { suggestBox.innerHTML = data; suggestBox.style.display = 'block'; });
            } else { suggestBox.innerHTML = ''; suggestBox.style.display = 'none'; }
        });
    }
});
</script>

<style>.suggestion-item:hover { background-color: #f0faf0 !important; }</style>

<?php include 'footer.php'; ?>

