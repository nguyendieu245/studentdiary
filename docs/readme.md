# Yêu Cầu hệ thống chia sẻ kiến thức Student Diary
## Tổng Quan
Student Diary là nền tảng cho phép người dùng đọc và thảo luận các bài viết, tài liệu học tập hoặc kỹ năng. Hệ thống hỗ trợ 3 vai trò: Admin, User đã đăng nhập, Người truy cập (Guest).
## Yêu Cầu Hệ Thống
### Yêu Cầu Kỹ Thuật
- PHP 7.4 hoặc cao hơn
- MySQL 5.7 hoặc cao hơn
- Máy chủ web (Apache/Nginx)
- PDO PHP Extension
- Trình duyệt web hiện đại có hỗ trợ JavaScript
### Cấu Hình Cơ Sở Dữ Liệu
- Host: localhost
- Tên Database: student_diary
- Tên người dùng: root
- Mật khẩu (thiết lập trong Config/db.php)
## Vai Trò Người Dùng và Quyền Truy Cập
### Quản Trị Viên

- Quản lý bài viết (xem chi tiết bài viết, thêm, sửa, xóa)
- Quản lý danh mục (xem tổng số bài viết ở từng danh mục)
- Quản lý người dùng (kích hoạt tài khoản, vô hiệu hóa tài khoản)
- Quản lý bình luận (phản hồi, ẩn/hiển thị, xóa)

### Người truy cập(Guest)

- Xem bài viết
- Xem bình luận

### Người dùng đã đăng nhập

- Xem bài viết
- Xem bình luận
- Bình luận bài viết

## Use Cases (Trường Hợp Sử Dụng)

### Use Cases Xác Thực

1. **Đăng Nhập**

   - **Tác nhân:** Quản trị viên, Người dùng
   - **Mô tả:** Người dùng đăng nhập vào hệ thống bằng tên đăng nhập và mật khẩu
   - **Luồng chính:**
     1. Người dùng truy cập trang đăng nhập
     2. Điền tên đăng nhập và mật khẩu
     3. Hệ thống xác thực thông tin
     4. Chuyển hướng đến trang chính tương ứng với vai trò

2. **Đăng Ký**

   - **Tác nhân:** Người dùng mới
   - **Mô tả:** Người dùng tạo tài khoản mới trong hệ thống
   - **Luồng chính:**
     1. Người dùng truy cập trang đăng ký
     2. Điền thông tin cá nhân, tên đăng nhập, mật khẩu
     3. Hệ thống xác thực và lưu thông tin
     4. Chuyển hướng đến trang đăng nhập

3. **Đăng Xuất**
   - **Tác nhân:** Người dùng đã đăng nhập
   - **Mô tả:** Người dùng đăng xuất khỏi hệ thống
   - **Luồng chính:**
     1. Người dùng nhấn nút đăng xuất
     2. Hệ thống xóa phiên đăng nhập
     3. Chuyển hướng đến trang đăng nhập

### Use Cases Quản Trị Viên

1. **Quản Lý Người Dùng**

   - **Tác nhân:** Quản trị viên
   - **Mô tả:** Quản lý thông tin người dùng trong hệ thống
   - **Luồng chính:**
     1. Quản trị viên truy cập trang quản lý người dùng
     2. Xem danh sách người dùng hiện có
     3. Kích hoạt/vô hiệu hóa người dùng

2. **Quản Lý bài viết**

   - **Tác nhân:** Quản trị viên
   - **Mô tả:** Quản lý thông tin bài viết
   - **Luồng chính:**
     1. Quản trị viên truy cập trang quản lý bài viết
     2. Xem danh sách bài viết hiện có
     3. Xem chi tiết bài viết
     4. Thêm bài viết mới
     5. Chỉnh sửa thông tin bài viết
     6. Xóa bài viết khỏi hệ thống

3. **Quản Lý danh mục**

   - **Tác nhân:** Quản trị viên
   - **Mô tả:** Quản lý thông tin danh mục
   - **Luồng chính:**
     1. Quản trị viên truy cập trang quản lý loại phòng
     2. Xem danh sách danh mục hiện có cùng với số bài viết trong danh mục đó

4. **Quản Lý bình luận**

   - **Tác nhân:** Quản trị viên
   - **Mô tả:** Quản lý thông tin bình luận
   - **Luồng chính:**
     1. Quản trị viên truy cập trang quản lý bình luận
     2. Xem danh sách bình luận hiện có
     3. Phản hồi bình luận
     4. Ẩn/Hiển thị bình luận
     5. Xóa bình luận khỏi hệ thống

### Use Cases Người truy cập (Guest)

1. **Xem bài viết**

   - **Tác nhân:** Guest
   - **Mô tả:** Xem bài viết có sẵn trên hệ thống
   - **Luồng chính:**
     1. Guest truy cập trang chủ
     2. Xem bài viết

2. **Xem bình luận**

   - **Tác nhân:** Guest
   - **Mô tả:**  Xem bình luận chi tiết về phòng học
   - **Luồng chính:**
     1. Guest chọn một bài viết từ danh sách
     2. Hệ thống hiển thị bài viết chi tiết
     3. Xem danh sách bình luận có trong bài viết

### Use Cases Người dùng đã đăng nhập

1. **Xem bài viết**

   - **Tác nhân:** Người dùng đã đăng nhập
   - **Mô tả:** Xem bài viết có sẵn trên hệ thống
   - **Luồng chính:**
     1. Người dùng truy cập trang chủ
     2. Xem bài viết

2. **Xem bình luận**

   - **Tác nhân:** Người dùng đã đăng nhập
   - **Mô tả:**  Xem bình luận chi tiết về phòng học
   - **Luồng chính:**
     1. Người dùng chọn một bài viết từ danh sách
     2. Hệ thống hiển thị bài viết chi tiết
     3. Xem danh sách bình luận có trong bài viết

3. **Bình luận bài viết**

   - **Tác nhân:** Người dùng đã đăng nhập
   - **Mô tả:** Người dùng muốn bình luận về bài 
   - **Luồng chính:**
     1. Người dùng truy cập trang bài viết chi tiết
     2. Chọn bình luận
     3. Nhập bình luận của mình

## Tính Năng Chính

### Hệ Thống Xác Thực

- Đăng nhập người dùng với tên đăng nhập và mật khẩu
- Đăng ký người dùng 
- Quản lý phiên làm việc

### Quản Lý bài viết

- Thêm bài viết mới 
- Sửa thông tin bài viết 
- Xóa bài viết

### Quản lý danh mục

- Xem danh mục với số bài viết tương ứng

### Quản Lý người dùng

- Xem danh sách người dùng
- Kích hoạt/Vô hiệu hóa người dùng

### Bình luận

- Hỗ trợ bình luận theo từng bài 

## Mô Hình Dữ Liệu

### admins

- id 
- username 
- password 
- fullname 
- role 

### categories

- id 
- name 
- slug 
- created_at 

### comments

- id
- post_id
- parent_id
- name 
- comment
- created_at
- status
- is_admin

### posts

- id 
- title
- content
- author
- created_at
- updated_at
- image
- status
- category_id

### users

- id 
- username
- password
- fullname
- email
- created_at


## Yêu Cầu Giao Diện Người Dùng

- Thiết kế đáp ứng tương thích với máy tính để bàn và thiết bị di động
- Điều hướng trực quan
- Giao diện thân thiện với người dùng
- Hỗ trợ tiếng Việt

## Yêu Cầu Bảo Mật

- Quản lý phiên làm việc
- Xác thực đầu vào
- Bảo vệ CSRF
- Kiểm soát truy cập dựa trên vai trò

## Cấu Trúc Dự Án

- `/public` - Điểm vào và các file có thể truy cập công khai
- `/src/Config` - Các file cấu hình cho cơ sở dữ liệu và cài đặt hệ thống
- `/src/Controllers` - Các bộ điều khiển ứng dụng để xử lý yêu cầu
- `/src/Models` - Các mô hình dữ liệu cho tương tác cơ sở dữ liệu
- `/src/Views` - Các mẫu giao diện được tổ chức theo vai trò người dùng

## Chi Tiết Triển Khai

- Kiến trúc MVC (Model-View-Controller)
- PDO cho tương tác cơ sở dữ liệu
- Định tuyến URL sạch thông qua .htaccess
- Tách biệt logic nghiệp vụ khỏi giao diện

## Các Tuyến Đường (Routes) Chính

### Tuyến Đường Quản Trị Viên

- `/admin/posts` - Quản lý bài viết
- `/admin/categories` - Quản lý danh mục
- `/admin/manage_user` - Quản lý người dùng
- `/admin/comments` - Quản lý bình luận

### Tuyến Đường Guest

- - `/frontend/category_list` - Xem bài viết

### Tuyến Đường User

- `/frontend/category_detail` - Bình luận
- `/frontend/category_list` - Xem bài viết

## Hướng Dẫn Sử Dụng

Tài liệu hướng dẫn chi tiết cách sử dụng hệ thống có thể được tìm thấy trong thư mục `/docs`.
