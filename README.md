# 🌿 Living Healthy Natural

Dự án quản trị sản phẩm thiên nhiên hỗ trợ người dùng sống khỏe mạnh. Xây dựng bằng **Laravel 12**, sử dụng **Filament Admin Panel** cho quản lý backend.

---

## 🚀 Công nghệ sử dụng

- PHP 8.2+
- Laravel 12
- Filament v3+
- Livewire
- Tailwind CSS
- Alpine.js
- Laravel Breeze (đăng nhập / đăng ký)
- MySQL / MariaDB

---

## 📦 Cài đặt

### 1. Clone project
```bash
git clone https://github.com/tenban/Living_Healthy_Natural.git
cd Living_Healthy_Natural
```

### 2. Cài đặt package
```bash
composer install
npm install && npm run build
```

### 3. Thiết lập `.env`
```bash
cp .env.example .env
php artisan key:generate
```

Cấu hình `.env`:

```env
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Chạy migration và seed
```bash
php artisan migrate --seed
```

---

## 🛡️ Xác thực & Quản trị

### Cài Laravel Breeze (nếu chưa)
```bash
php artisan breeze:install livewire
npm install && npm run build
php artisan migrate
```

### Cài Filament
```bash
composer require filament/filament
php artisan filament:install
```

### Tạo user quản trị:
```bash
php artisan make:filament-user
```

---

## 🖥️ Truy cập

- Trang người dùng: `http://localhost:8000`
- Admin panel: `http://localhost:8000/admin`

---

## 📁 Cấu trúc thư mục chính

```
app/
├── Filament/            # Tùy chỉnh layout, pages, resources của filament
├── Http/
│   ├── Controllers/
│   ├── Livewire/
├── Models/
resources/
├── views/
routes/
├── web.php
├── filament.php
```

---

## ✅ Tính năng hiện có

- [x] Đăng nhập / Đăng ký người dùng
- [x] Quản lý sản phẩm (tên, mô tả, hình ảnh)
- [x] Giao diện quản trị Filament
- [x] Phân quyền user (admin / user)
- [ ] Trang blog & bài viết (đang phát triển)
- [ ] Đặt hàng trực tuyến (sắp tới)

---

## 💡 Gợi ý phát triển tiếp

- Tích hợp thanh toán (VNPay, Momo)
- Thêm tính năng đa ngôn ngữ (Laravel Localization)
- Sử dụng Laravel Scout cho tìm kiếm nhanh
- Tích hợp thống kê doanh thu với Filament Charts

---

## 📚 Tài liệu tham khảo

- [Laravel Docs](https://laravel.com/docs)
- [Filament Docs](https://filamentphp.com/docs/3.x/panels/installation)
- [Tailwind CSS](https://tailwindcss.com/)
