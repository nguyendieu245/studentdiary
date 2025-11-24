// ==========================================
// FILE: category.js - Quản lý danh mục
// ==========================================

// Chuyển đổi tiếng Việt có dấu sang không dấu cho slug
function removeVietnameseTones(str) {
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/\s+/g, "-");
    str = str.replace(/[^a-z0-9\-]/g, "");
    str = str.replace(/-+/g, "-");
    str = str.replace(/^-+|-+$/g, "");
    return str;
}

// Tự động tạo slug từ tên danh mục
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        let userEditedSlug = slugInput.value.trim() !== '';
        
        // Đánh dấu nếu người dùng tự chỉnh sửa slug
        slugInput.addEventListener('input', function() {
            userEditedSlug = true;
        });
        
        // Tự động tạo slug khi nhập tên (nếu chưa tự chỉnh sửa)
        nameInput.addEventListener('input', function() {
            if (!userEditedSlug) {
                const slug = removeVietnameseTones(this.value);
                slugInput.value = slug;
            }
        });
    }
    
    // Tự động ẩn thông báo sau 3 giây
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(function() {
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 3000);
    }
});