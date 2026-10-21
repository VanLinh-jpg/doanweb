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
?>

<div class="container my-5 pt-4 pb-5" style="min-height: 60vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-family:'Oswald',sans-serif; color: #1a1a2e; font-size: 1.8rem; letter-spacing: 1px;">👥 Tài Khoản Hệ Thống</h2>
        
        <?php $sg_tk = $conn->query("SELECT DISTINCT HoTen, Email FROM NguoiDung"); ?>
        <datalist id="suggestTK">
            <?php 
            if($sg_tk) {
                while($r = $sg_tk->fetch_assoc()) {
                    echo "<option value='".htmlspecialchars($r['HoTen'])."'>"; 
                    echo "<option value='".htmlspecialchars($r['Email'])."'>"; 
                }
            }
            ?>
        </datalist>

        <form action="admin_taikhoan.php" method="GET" class="d-flex w-25">
            <input type="text" name="search" list="suggestTK" autocomplete="off" class="form-control me-2" 
                   placeholder="Tìm tên KH hoặc Email..." 
                   value="<?php echo $search_query; ?>">
            <button type="submit" class="btn btn-outline-dark">Tìm</button>
        </form>

        <a href="admin.php" class="btn btn-outline-dark" style="border-radius:0; font-family:'Oswald',sans-serif;">← Dashboard</a>
    </div>

    <div class="table-responsive shadow-sm bg-white p-3 rounded border">
        <table class="table table-hover align-middle text-center mb-0">
            <thead style="background-color: #1a1a2e; color: #f0b429;">
                <tr>
                    <th>ID</th>
                    <th class="text-start">Họ và Tên</th>
                    <th>Email Đăng Nhập</th>
                    <th>Phân Quyền</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM NguoiDung";
                if (!empty($search_query)) {
                    $sql .= " WHERE HoTen LIKE '%$search_query%' OR Email LIKE '%$search_query%'";
                }
                $sql .= " ORDER BY ID_User DESC";

                $result = $conn->query($sql);
                if($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $role_badge = ($row['VaiTro'] == 'Admin') ? 'bg-danger' : 'bg-primary';
                ?>
                <tr>
                    <td class="fw-bold"><?php echo $row['ID_User']; ?></td>
                    <td class="text-start fw-bold"><?php echo $row['HoTen']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><span class="badge <?php echo $role_badge; ?> px-3 py-1"><?php echo $row['VaiTro']; ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger" style="border-radius: 0;" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">Khóa</button>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center py-4 text-danger fw-bold'>Không tìm thấy tài khoản nào!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
