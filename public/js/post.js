// ==========================================
// FILE: post.js - Quản lý bài viết
// ==========================================

// Preview ảnh khi chọn file
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    
    if (imageInput && imagePreview && preview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Kiểm tra loại file
                if (!file.type.startsWith('image/')) {
                    alert('Vui lòng chọn file ảnh!');
                    imageInput.value = '';
                    return;
                }
                
                // Kiểm tra kích thước file (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Kích thước ảnh không được vượt quá 5MB!');
                    imageInput.value = '';
                    return;
                }
                
                // Hiển thị preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    }
    
    // Validation form trước khi submit
    const forms = document.querySelectorAll('form[action*="store"], form[action*="update"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const title = document.getElementById('title');
            const content = document.getElementById('content');
            const categoryId = document.getElementById('category_id');
            
            // Kiểm tra tiêu đề
            if (title && title.value.trim().length < 5) {
                e.preventDefault();
                alert('Tiêu đề phải có ít nhất 5 ký tự!');
                title.focus();
                return false;
            }
            
            // Kiểm tra nội dung
            if (content && content.value.trim().length < 20) {
                e.preventDefault();
                alert('Nội dung phải có ít nhất 20 ký tự!');
                content.focus();
                return false;
            }
            
            // Kiểm tra danh mục
            if (categoryId && !categoryId.value) {
                e.preventDefault();
                alert('Vui lòng chọn danh mục!');
                categoryId.focus();
                return false;
            }
        });
    });
    
    // Tự động ẩn thông báo sau 3 giây
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(function() {
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 3000);
    }
});

// Hàm xác nhận xóa bài viết
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
        window.location.href = 'index.php?action=delete_post&id=' + id;
    }
}