Tài liệu hướng dẫn sử dụng hệ thống Website Chia sẻ Kiến Thức Student Diary
1. Giới thiệu
Hệ thống Website Chia sẻ Kiến Thức Student Diary là nền tảng web hỗ trợ người dùng xem thông tin các bài viết ở từng danh mục Đời sống, Kỹ năng, Học tập, từ đó để lại ý kiến thông qua bình luận.
Đồng thời, hệ thống cho phép quản trị viên quản lý bài viết, quản lý danh mục, bình luận và người dùng
Hệ thống gồm hai vai trò chính:
•	Người dùng
•	Quản trị viên

2. Chức năng theo vai trò
2.1. Người dùng
Đăng ký 
Đường dẫn: /frontend/register
Chức năng:
• Người dùng tạo tài khoản mới
• Nhập thông tin: Tên đăng nhập - Họ và tên – Email – Mật khẩu - Xác nhận mật khẩu
• Hệ thống kiểm tra định dạng thông tin
• Lưu thông tin vào cơ sở dữ liệu
• Sau khi đăng ký thành công, chuyển sang trang đăng nhập
Đăng nhập
Đường dẫn: /frontend/user_login
Chức năng:
• Người dùng nhập tên đăng nhập và mật khẩu
• Hệ thống kiểm tra thông tin đăng nhập
• Chuyển hướng sang trang chủ nếu thành công
• Nếu sai mật khẩu thì hiển thị thông báo lỗi
• Nếu chưa có tài khoản thì chuyển sang trang đăng ký
Xem trang chủ
Đường dẫn: /view/frontend
Chức năng:
•	Xem banner giới thiệu
•	Xem menu danh mục: Kỹ năng, Đời sống, Học Tập
•	Xem mô tả ngắn gọn
Xem trang các danh mục
Đường dẫn: /frontend/category_list
Chức năng:
•	Xem các bài viết hiển thị theo từng danh mục
•	Xem ảnh, ngày đăng trên từng bài
Xem bài viết chi tiết
Đường dẫn: /frontend/category_detail
Chức năng:
•	Xem bài viết chi tiết của từng danh mục 
•	Bài viết gồm ngày đăng, ảnh và mô tả bài viết
•	Bên dưới mỗi bài viết là phần bình luận của người dùng bao gồm khung bình luận của người dùng trước và phản hồi của quản trị viên (nếu có). Và phần nhập nội dung gửi bình luận. Nếu chưa có tài khoản hoặc chưa đăng nhập thì không thể bình luận
•	Bình luận người dùng sẽ hiển thị theo tên, ngày giờ và nội dung bình luận
2.2.Quản trị viên
Đăng nhập
Đường dẫn: /admin/login
Chức năng:
•	Quản trị viên nhập tên đăng nhập và mật khẩu
•	Hệ thống kiểm tra thông tin đăng nhập
•	Chuyển sang giao diện admin nếu đăng nhập thành công
•	Nếu sai thông tin đăng nhập thì hiển thị thông báo lỗi
Quản lý bài viết
Đường dẫn: /admin/posts
Chức năng:
•	Xem danh sách bài viết
•	Xem bài viết chi tiết
•	Sửa thông tin bài viết
•	Xóa thông tin bài viết
•	Thêm bài viết mới
Quản lý danh mục
Đường dẫn: /admin/categories
Chức năng:
•	Xem danh sách danh mục bao gồm: id danh mục, tên danh mục, slug, ngày tạo và số lượng bài viết hiển thị cho từng danh mục
Quản lý người dùng
Đường dẫn: /admin/manage_user
Chức năng:
•	Xem danh sách người dùng
•	Kích hoạt trạng thái tài khoản người dùng : active/inactive. Người dùng khi đăng kí tài khoản đều mặc định trạng thái "active"(có thể đăng nhập trang user và để lại bình luận). Tuy nhiên, khi admin phát hiện người dùng có nội dung spam thì admin có thể vô hiệu hóa tài khoản người dùng, trạng thái tài khoản người dùng sẽ hiện "inactive" và người dùng không được phép đăng nhập vào tài khoản đó nữa.
Quản lý bình luận
Đường dẫn: /admin/comments
Chức năng:
•	Xem danh sách bình luận người dùng
•	Ẩn/Hiển thị bình luận
•	Xóa bình luận
•	Trả lời bình luận

3. Hướng dẫn đăng ký, đăng nhập tài khoản 
3.1. Đăng ký tài khoản
Đường dẫn: /frontend/register
Cách sử dụng:
  1. Truy cập trang đăng ký
  2. Nhập đầy đủ thông tin cá nhân
  3. Nhấn “Đăng ký”
  4. Kiểm tra thông báo thành công
  5. Chuyển sang trang đăng nhập để tiếp tục
3.2. Đăng nhập tài khoản (user)
Đường dẫn: frontend/user_login 
Cách sử dụng:
  1. Nhập tên đăng nhập và mật khẩu
  2. Nhấn “Đăng nhập”
  3. Nếu đúng → hệ thống đưa về trang chủ /view
  4. Nếu sai → thông báo "Sai mật khẩu hoặc Sai tên đăng nhập" và người dùng nhập lại

4. Hướng dẫn xem các trang danh mục và chi tiết bài viết
4.1. Xem trang danh mục
Đường dẫn: /frontend/catgory_list
Cách sử dụng:
  1. Chọn danh mục quan tâm
  2. Xem danh sách các bài viết hiển thị trong danh mục
  3. Nhấn “Xem tiếp” để xem chi tiết bài viết (nếu cần)
4.2. Xem chi tiết bài viết và bình luận người dùng
Đường dẫn: /frontend/category_detail
Cách sử dụng:
  1. Nhấn "Xem tiếp" bài viết ở trang danh mục
  2. Xem chi tiết bài viết hiển thị
  3. Nhập nội dung bình luận vào ô "Gửi bình luận của bạn" và nhấn gửi bình luận nếu người dùng có tài khoản và đã đăng nhập
  4. Nếu chưa đăng nhập thì người dùng không thể bình luận và thấy bên dưới ô "Gửi bình luận của bạn" có ghi chú gắn kèm link "Bạn phải đăng nhập mới có thể bình luận"
  5. Người dùng ấn vào link đăng nhập ở ghi chú đó và quay trở lại form đăng nhập. Nếu có tài khoản thì nhập thông tin tài khoản để tiếp tục, nếu chưa có tài khoản thì nhấn đăng kí tài khoản để đăng nhập rồi bình luận 

5. Hướng dẫn dành cho Quản trị viên (Admin)
5.1. Đăng nhập
Đường dẫn: /admin/login 
Chức năng:
  1. Chọn đăng nhập vào trang quản trị
  2. Nhập tên tài khoản và mật khẩu
  3. Chuyển hướng vào Dashboard quản lý sau khi đăng nhập thành công
  4. Nếu thông tin sai → báo lỗi
5.2. Quản lý bài viết
Đường dẫn: /admin/posts
Thao tác:
•	Nhấn “Thêm bài viết” → nhập thông tin
•	Nhấn “Sửa” để chỉnh sửa bài viết
•	Nhấn “Xóa” để loại bỏ bài viết
• Nhấn “Xem” để xem chi tiết bài viết đã đăng
5.3. Quản lý danh mục 
Đường dẫn: /admin/categories
Thao tác:
•	Xem thông tin các danh mục kỹ năng bao gồm: id danh mục,tên danh mục, slug, ngày tạo danh mục và số lượng bài viết đã đăng hiển thị theo từng danh mục
5.4. Quản lý người dùng
Đường dẫn: /admin/manage_user
Thao tác:
•	Nhấn “Kích hoạt” → trạng thái hiển thị "active" thì tài khoản người dùng được phép đăng nhập bên giao hiện user
•	Ngược lại không ấn "Kích hoạt" → trạng thái hiển thị "inactive" thì tài khoản người dùng không được đăng nhập bên giao diện user
5.5. Quản lý bình luận
Đường dẫn: /admin/comments
Thao tác:
•	Nhấn “Trả lời” → nhập thông tin phản hồi bình luận người dùng
•	Nhấn “Xóa” để loại bỏ bình luận
• Nhấn “Xem” để hiển thị hoặc ẩn bài viết
5.6. Quản lý thông tin trang chủ (Admin)
Đường dẫn: /admin/dashboard
Cho phép cập nhật:
•	Hình ảnh giới thiệu và mô tả ngắn gọn
•	Thanh sidebar gồm các danh mục quản lý và đăng xuất
Đường dẫn: /layouts/sidebar 

6. Lưu ý quan trọng
•	Người dùng phải đăng nhập trước khi để lại bình luận
•	Người dùng chỉ có thể đăng nhập khi được admin kích hoạt tài khoản
•	Thông tin bài viết cần được cập nhật đầy đủ để hiển thị đẹp trên trang chi tiết bài viết
