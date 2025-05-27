# Ứng dụng Quản lý Công việc Cá nhân

Ứng dụng quản lý công việc cá nhân giúp bạn theo dõi, sắp xếp và hoàn thành các nhiệm vụ hàng ngày một cách hiệu quả.

## Tác dụng thực tế của ứng dụng

- **Quản lý công việc hiệu quả:** Tạo, cập nhật, xóa và theo dõi trạng thái từng công việc (Đang chờ, Đang thực hiện, Đã hoàn thành).
- **Tăng năng suất cá nhân:** Lên kế hoạch, đặt hạn hoàn thành, kiểm soát khối lượng công việc mỗi ngày.
- **Giảm stress, không quên việc:** Ghi chú rõ ràng, không bỏ sót nhiệm vụ quan trọng.
- **Theo dõi tiến độ phát triển bản thân:** Xem lại lịch sử các công việc đã hoàn thành để đánh giá hiệu quả làm việc.
- **Ứng dụng thực tế cho học tập và công việc:** Phù hợp cho sinh viên quản lý bài tập, dự án; người đi làm quản lý task công việc, dự án cá nhân hoặc nhóm nhỏ.

## Tính năng hiện có

- 🔐 **Quản lý tài khoản cơ bản**
  - Tạo tài khoản mới
  - Đăng nhập/Đăng xuất
  - Quản lý hồ sơ người dùng
    - Cập nhật thông tin cá nhân (tên, email)
    - Cập nhật mật khẩu
    - Xóa tài khoản

- 📝 **Quản lý công việc**
  - Tạo công việc mới
  - Cập nhật thông tin công việc
  - Theo dõi trạng thái công việc
  - Đặt hạn hoàn thành
  - Xóa công việc

## Tính năng đang phát triển

- 🎯 **Theo dõi tiến độ**
  - Trạng thái: Đang chờ, Đang thực hiện, Hoàn thành
  - Thời hạn hoàn thành
  - Mô tả chi tiết

## Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM

## Cài đặt

1. Clone dự án về máy:
```bash
# Clone repository về máy local của bạn
git clone <repository-url>
# Di chuyển vào thư mục dự án
cd laravel-app
```

2. Cài đặt các dependencies:
```bash
# Cài đặt các package PHP cần thiết thông qua Composer
composer install
```

3. Cấu hình database:
- Tạo file `.env` từ file `.env.example`:
```bash
# Tạo file .env để lưu trữ các biến môi trường
cp .env.example .env
```
- Cấu hình thông tin database trong file `.env`:
```
# Cấu hình kết nối database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307        # Port mặc định của MySQL, có thể thay đổi tùy cấu hình
DB_DATABASE=todo_app # Tên database bạn muốn sử dụng
DB_USERNAME=root     # Username của MySQL
DB_PASSWORD=         # Password của MySQL (để trống nếu không có)
```

4. Tạo key cho ứng dụng:
```bash
# Tạo APP_KEY để mã hóa dữ liệu trong ứng dụng
php artisan key:generate
```

5. Chạy migrations để tạo database:
```bash
# Tạo các bảng trong database dựa trên các file migration
php artisan migrate
```

6. Khởi động server:
```bash
# Khởi động server development của Laravel
php artisan serve
```

## Công nghệ sử dụng

- Laravel 10.x
- PHP 8.1+
- MySQL 5.7+
- Bootstrap 5
- jQuery

## Cấu trúc thư mục

- `app/` - Chứa các controllers, models, và business logic
- `config/` - Chứa các file cấu hình
- `database/` - Chứa migrations và seeders
- `public/` - Chứa các file public như CSS, JS, images
- `resources/` - Chứa views và các file frontend
- `routes/` - Chứa các định nghĩa routes
- `storage/` - Chứa các file được upload và logs
- `tests/` - Chứa các file test

## Lộ trình phát triển

### Giai đoạn 1: Xác thực người dùng ✅
- [x] Đăng ký tài khoản
- [x] Đăng nhập/Đăng xuất
- [x] Quản lý hồ sơ

### Giai đoạn 2: Quản lý công việc ✅
- [x] Tạo công việc mới
- [x] Cập nhật thông tin công việc
- [x] Theo dõi trạng thái
- [x] Đặt hạn hoàn thành
- [x] Xóa công việc

### Giai đoạn 3: Theo dõi tiến độ 🚧
- [ ] Hiển thị danh sách công việc
- [ ] Lọc công việc theo trạng thái
- [ ] Sắp xếp theo thời hạn
- [ ] Thống kê tiến độ

## Đóng góp

Mọi đóng góp đều được hoan nghênh! Vui lòng tạo issue hoặc pull request để đóng góp.

## Liên hệ
email: [23010507@st.phenilaa-uni.edu.vn]
