<?php 
include 'header.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten   = $_POST['hoten'];
    $email   = $_POST['email'];
    $matkhau = $_POST['matkhau'];
    $xacnhan = $_POST['xacnhan'];

    if ($matkhau != $xacnhan) {
        $error = "Mật khẩu xác nhận không khớp. Vui lòng nhập lại!";
    } else {
        $check_email = "SELECT * FROM NguoiDung WHERE Email = '$email'";
        $rs_check = $conn->query($check_email);
        
        if ($rs_check->num_rows > 0) {
            $error = "Email này đã được đăng ký. Vui lòng dùng email khác!";
        } else {
            $sql_insert = "INSERT INTO NguoiDung (HoTen, Email, MatKhau, VaiTro) VALUES ('$hoten', '$email', '$matkhau', 'KhachHang')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "<script>alert('Đăng ký thành công! Vui lòng đăng nhập.'); window.location.href='dangnhap.php';</script>";
                exit();
            } else {
                $error = "Có lỗi xảy ra: " . $conn->error;
            }
        }
    }
}
?>

<div class="container my-5 pt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h2 class="text-center mb-4 brand-text" style="font-size: 2rem;">Đăng Ký Tài Khoản</h2>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="dangky.php" method="POST" class="p-4 border rounded shadow-sm bg-light">
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và Tên</label>
                    <input type="text" name="hoten" class="form-control" required placeholder="Ví dụ: Nguyễn Văn A">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Địa chỉ Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="email@gmail.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu</label>
                    <input type="password" name="matkhau" class="form-control" required placeholder="Nhập mật khẩu...">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Xác nhận mật khẩu</label>
                    <input type="password" name="xacnhan" class="form-control" required placeholder="Nhập lại mật khẩu...">
                </div>
                <button type="submit" class="btn w-100 mb-3 text-white fw-bold py-2" style="background-color: #1a3a2a; letter-spacing: 1px;">ĐĂNG KÝ MỚI</button>
                <p class="text-center small mb-0">
                    Đã có tài khoản? <a href="dangnhap.php" class="text-decoration-none fw-bold" style="color: #2d6a4f;">Đăng nhập ngay</a>
                </p>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

