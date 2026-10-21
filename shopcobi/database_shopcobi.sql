-- ============================================
-- DATABASE: shopcobi
-- Shop Cơ Bi - CueMaster
-- ============================================

CREATE DATABASE IF NOT EXISTS shopcobi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopcobi;

-- BẢNG DANH MỤC
CREATE TABLE IF NOT EXISTS DanhMuc (
    ID_DanhMuc INT AUTO_INCREMENT PRIMARY KEY,
    TenDanhMuc VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO DanhMuc (TenDanhMuc) VALUES
('Cơ Bi Thi Đấu'),
('Cơ Bi Tập Luyện'),
('Phụ Kiện Billiards'),
('Bàn Bi & Thiết Bị');

-- BẢNG SẢN PHẨM
CREATE TABLE IF NOT EXISTS SanPham (
    ID_SanPham  INT AUTO_INCREMENT PRIMARY KEY,
    TenSanPham  VARCHAR(255) NOT NULL,
    GiaNhap     DECIMAL(15,0) DEFAULT 0,
    Gia         DECIMAL(15,0) NOT NULL,
    SoLuongTon  INT DEFAULT 0,
    LoaiDa      VARCHAR(100),   -- Dùng để lưu "Phân loại" (VD: Cơ một mảnh, cơ 2 mảnh...)
    ThuongHieu  VARCHAR(100),
    ID_DanhMuc  INT,
    HinhAnh     VARCHAR(255),
    MoTa        TEXT,
    FOREIGN KEY (ID_DanhMuc) REFERENCES DanhMuc(ID_DanhMuc) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SẢN PHẨM MẪU
INSERT INTO SanPham (TenSanPham, GiaNhap, Gia, SoLuongTon, LoaiDa, ThuongHieu, ID_DanhMuc, HinhAnh, MoTa) VALUES
-- Mezz
('Cơ Mezz EC7-WH Trắng', 3500000, 5800000, 10, 'Cơ 2 mảnh - Shaft Maple', 'Mezz', 1, '', 'Cơ bi Mezz EC7-WH được làm từ gỗ maple Bắc Mỹ cao cấp, khớp nối Uni-Loc chắc chắn. Phù hợp thi đấu chuyên nghiệp.'),
('Cơ Mezz AXI Advance', 5500000, 9200000, 5, 'Cơ 2 mảnh - Shaft Carbon', 'Mezz', 1, '', 'Shaft AXI kết hợp công nghệ carbon fiber thế hệ mới, giảm cong vênh tối đa, cảm giác đánh cứng và chính xác tuyệt đối.'),
('Cơ Mezz WX700 Tập Luyện', 1200000, 2200000, 20, 'Cơ 2 mảnh - Shaft Maple', 'Mezz', 2, '', 'Lựa chọn hoàn hảo cho người mới bắt đầu muốn sử dụng thương hiệu Mezz chất lượng với ngân sách hợp lý.'),
-- Predator
('Cơ Predator REVO 12.4 Carbon', 8000000, 13500000, 4, 'Cơ 2 mảnh - Shaft Carbon Fiber', 'Predator', 1, '', 'Shaft carbon fiber REVO 12.4 - đỉnh cao công nghệ Predator. Độ thẳng vĩnh cửu, spin cực tốt, giảm deflection tối đa.'),
('Cơ Predator P3 Rosewood', 4500000, 7800000, 8, 'Cơ 2 mảnh - Shaft Maple', 'Predator', 1, '', 'Butt P3 thiết kế theo công nghệ kỹ thuật số, cân bằng hoàn hảo. Gỗ Rosewood sang trọng, điểm nhấn thẩm mỹ cao cấp.'),
-- Viking
('Cơ Viking A775 Maplewood', 900000, 1600000, 25, 'Cơ 2 mảnh - Shaft Maple', 'Viking', 2, '', 'Cơ Viking A775 là lựa chọn phổ biến cho người mới và cấp độ trung. Chất gỗ maple chuẩn, tín hiệu đánh nhạy, giá tốt.'),
('Cơ Viking Valhalla VA481', 1500000, 2800000, 15, 'Cơ 2 mảnh - Shaft Maple', 'Viking', 2, '', 'Serie Valhalla của Viking nổi tiếng với độ bền cao và khả năng kiểm soát bi tốt. Thích hợp tập luyện nâng cao.'),
-- McDermott
('Cơ McDermott G228 Handcrafted', 6500000, 11000000, 3, 'Cơ 2 mảnh - Shaft Maple', 'McDermott', 1, '', 'Được thủ công tại Wisconsin, USA. Gỗ North American Hard Rock Maple, khảm trai, điêu khắc tinh xảo. Biểu tượng đẳng cấp.'),
('Cơ McDermott Lucky L55', 1800000, 3200000, 12, 'Cơ 2 mảnh - Shaft Maple', 'McDermott', 2, '', 'Serie Lucky - Cơ McDermott phổ thông với chất lượng kiểm soát chặt chẽ từ nhà máy Mỹ. Giá tốt nhất trong dòng McDermott.'),
-- Phụ kiện
('Phấn Bi Triangle Xanh (12 viên)', 35000, 75000, 100, 'Phụ kiện - Phấn bi', 'Khác', 3, '', 'Phấn bi Triangle nổi tiếng, tiêu chuẩn thi đấu quốc tế. Hộp 12 viên, màu xanh chuẩn.'),
('Phấn Bi Master Chalk (12 viên)', 45000, 95000, 80, 'Phụ kiện - Phấn bi', 'Khác', 3, '', 'Phấn bi Master - thương hiệu Mỹ được các pro player ưa chuộng. Độ bám tốt, ít bụi phấn.'),
('Bao Đựng Cơ 2 Tầng Cao Cấp', 250000, 480000, 30, 'Phụ kiện - Bao cơ', 'Khác', 3, '', 'Bao cơ 2 tầng chống sốc, chống thấm nước. Đựng được 2 cơ + phụ kiện. Dây đeo vai tiện lợi.'),
('Găng Tay Billiards (size M/L)', 80000, 150000, 50, 'Phụ kiện - Găng tay', 'Khác', 3, '', 'Găng tay billiards chuyên dụng giúp bi trơn mượt, tránh mồ hôi tay ảnh hưởng đến thành tích. Có size M và L.');

-- BẢNG NGƯỜI DÙNG
CREATE TABLE IF NOT EXISTS NguoiDung (
    ID_User  INT AUTO_INCREMENT PRIMARY KEY,
    HoTen    VARCHAR(100) NOT NULL,
    Email    VARCHAR(100) UNIQUE NOT NULL,
    MatKhau  VARCHAR(255) NOT NULL,
    VaiTro   ENUM('Admin','KhachHang') DEFAULT 'KhachHang',
    NgayTao  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TÀI KHOẢN ADMIN MẶC ĐỊNH (mật khẩu: admin123)
INSERT INTO NguoiDung (HoTen, Email, MatKhau, VaiTro) VALUES
('Admin CueMaster', 'admin@cuemaster.vn', 'admin123', 'Admin'),
('Nguyễn Văn Test', 'test@gmail.com', '123456', 'KhachHang');

-- BẢNG ĐƠN HÀNG
CREATE TABLE IF NOT EXISTS DonHang (
    ID_DonHang          INT AUTO_INCREMENT PRIMARY KEY,
    ID_User             INT,
    HoTenGiaoHang       VARCHAR(100),
    SDTGiaoHang         VARCHAR(20),
    DiaChiGiaoHang      VARCHAR(255),
    GhiChu              TEXT,
    PhuongThucThanhToan VARCHAR(100),
    TongTien            DECIMAL(15,0),
    TrangThai           VARCHAR(50) DEFAULT 'Chờ xử lý',
    NgayDat             TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_User) REFERENCES NguoiDung(ID_User) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BẢNG CHI TIẾT ĐƠN HÀNG
CREATE TABLE IF NOT EXISTS ChiTietDonHang (
    ID_ChiTiet INT AUTO_INCREMENT PRIMARY KEY,
    ID_DonHang INT,
    ID_SanPham INT,
    SoLuong    INT,
    GiaBan     DECIMAL(15,0),
    FOREIGN KEY (ID_DonHang) REFERENCES DonHang(ID_DonHang) ON DELETE CASCADE,
    FOREIGN KEY (ID_SanPham) REFERENCES SanPham(ID_SanPham) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

