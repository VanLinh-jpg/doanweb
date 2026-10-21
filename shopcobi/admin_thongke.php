<?php
include 'header.php';
if (!isset($_SESSION['VaiTro']) || $_SESSION['VaiTro'] !== 'Admin') {
    echo "<script>alert('⛔ Bạn không có quyền truy cập!'); window.location.href='index.php';</script>";
    exit;
}

// 1. TỔNG DOANH THU & ĐƠN HÀNG
$sql_doanhthu = "SELECT SUM(TongTien) AS TongDoanhThu, COUNT(ID_DonHang) AS TongDon FROM DonHang WHERE TrangThai != 'Đã hủy'";
$res_doanhthu = $conn->query($sql_doanhthu);
$data_doanhthu = $res_doanhthu->fetch_assoc();
$tongDoanhThu = $data_doanhthu['TongDoanhThu'] ?? 0;
$tongDon = $data_doanhthu['TongDon'] ?? 0;

// 2. TÍNH TIỀN VỐN & LỢI NHUẬN
$tongVon = 0;
$sql_von = "SELECT ct.ID_SanPham, ct.SoLuong, ct.GiaBan, sp.GiaNhap 
            FROM ChiTietDonHang ct 
            JOIN DonHang dh ON ct.ID_DonHang = dh.ID_DonHang 
            LEFT JOIN SanPham sp ON ct.ID_SanPham = sp.ID_SanPham 
            WHERE dh.TrangThai != 'Đã hủy'";
$res_von = $conn->query($sql_von);

if($res_von && $res_von->num_rows > 0) {
    while($row = $res_von->fetch_assoc()) {
        if($row['GiaNhap'] != null) {
            $tongVon += ($row['GiaNhap'] * $row['SoLuong']);
        } else {
            $tongVon += ($row['GiaBan'] * 0.6 * $row['SoLuong']);
        }
    }
}

$loiNhuan = $tongDoanhThu - $tongVon;

// 3. TOP 5 SẢN PHẨM BÁN CHẠY
$sql_chart = "SELECT ct.ID_SanPham, SUM(ct.SoLuong) AS TongBan 
              FROM ChiTietDonHang ct 
              JOIN DonHang dh ON ct.ID_DonHang = dh.ID_DonHang 
              WHERE dh.TrangThai != 'Đã hủy'
              GROUP BY ct.ID_SanPham ORDER BY TongBan DESC LIMIT 5";
$res_chart = $conn->query($sql_chart);

$labels_array = [];
$data_array = [];

if($res_chart) {
    while($row = $res_chart->fetch_assoc()) {
        $id_sp = $row['ID_SanPham'];
        $sql_ten = "SELECT TenSanPham FROM SanPham WHERE ID_SanPham = '$id_sp'";
        $res_ten = $conn->query($sql_ten);
        if($res_ten && $res_ten->num_rows > 0) {
            $ten_sp = mb_substr($res_ten->fetch_assoc()['TenSanPham'], 0, 20) . '...';
        } else {
            $ten_sp = "SP ID: " . $id_sp;
        }
        $labels_array[] = $ten_sp;
        $data_array[] = $row['TongBan'];
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container my-5 pt-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-family:'Oswald',sans-serif; color: #1a1a2e; font-size: 1.8rem; letter-spacing: 1px;">📊 Báo Cáo Tài Chính</h2>
        <a href="admin.php" class="btn btn-outline-dark" style="border-radius:0; font-family:'Oswald',sans-serif;">← Dashboard</a>
    </div>

    <!-- 3 KHỐI BÁO CÁO TÀI CHÍNH -->
    <div class="row mb-5 text-center">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 py-4 rounded" style="border-bottom: 4px solid #2196F3 !important;">
                <div style="font-size: 2.5rem;">💰</div>
                <h5 class="mb-2 text-muted fw-bold mt-2">TỔNG DOANH THU</h5>
                <h2 class="fw-bold m-0" style="color: #2196F3; font-family:'Oswald',sans-serif;">
                    <?php echo number_format($tongDoanhThu, 0, ',', '.'); ?> đ
                </h2>
                <small class="text-muted mt-2">Từ <?php echo $tongDon; ?> đơn hàng thành công</small>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 py-4 rounded" style="border-bottom: 4px solid #ff9800 !important;">
                <div style="font-size: 2.5rem;">📦</div>
                <h5 class="mb-2 text-muted fw-bold mt-2">TỔNG TIỀN VỐN</h5>
                <h2 class="fw-bold m-0 text-secondary" style="font-family:'Oswald',sans-serif;">
                    <?php echo number_format($tongVon, 0, ',', '.'); ?> đ
                </h2>
                <small class="text-muted mt-2">Chi phí nhập hàng hóa</small>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 py-4 rounded" style="background-color: #1a1a2e; transform: scale(1.05);">
                <div style="font-size: 2.5rem;">🏆</div>
                <h5 class="mb-2 fw-bold mt-2" style="color: #f0b429;">LỢI NHUẬN RÒNG</h5>
                <h2 class="fw-bold m-0" style="color: #4ade80; font-family:'Oswald',sans-serif;">
                    + <?php echo number_format($loiNhuan, 0, ',', '.'); ?> đ
                </h2>
                <small class="mt-2" style="color: #aaa;">Lãi thực tế bỏ túi 🎱</small>
            </div>
        </div>
    </div>

    <!-- BIỂU ĐỒ -->
    <div class="card shadow-sm border-0 p-4 rounded mt-4">
        <h4 class="fw-bold mb-4 text-center" style="font-family:'Oswald',sans-serif; color: #1a1a2e;">
            🎱 Top 5 Cơ Bida / Sản Phẩm Bán Chạy Nhất
        </h4>
        <div style="height: 400px; width: 100%;">
            <canvas id="topProductChart"></canvas>
        </div>
    </div>
</div>

<script>
    const labels = <?php echo json_encode($labels_array); ?>;
    const dataValues = <?php echo json_encode($data_array); ?>;

    const ctx = document.getElementById('topProductChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Đã bán ra (cây/bộ)',
                data: dataValues,
                backgroundColor: [
                    'rgba(26,26,46,0.85)',
                    'rgba(200,150,12,0.85)',
                    'rgba(30,86,49,0.85)',
                    'rgba(54,162,235,0.85)',
                    'rgba(255,99,132,0.85)'
                ],
                borderWidth: 0,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { font: { family: 'Oswald', size: 14 } } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { font: { family: 'Oswald' } } }
            }
        }
    });
</script>

<?php include 'footer.php'; ?>
