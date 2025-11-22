// public/js/post.js - JavaScript cho quản lý bài viết

/**
 * Xác nhận xóa bài viết
 */
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
        window.location.href = 'index.php?action=delete_post&id=' + id;
    }
}

/**
 * Preview ảnh trước khi upload
 */
function previewImage(event) {
    const file = event.target.files[0];
    
    if (file) {
        // Kiểm tra kích thước file (max 5MB)
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            alert('Kích thước file quá lớn! Vui lòng chọn ảnh nhỏ hơn 5MB.');
            event.target.value = '';
            return;
        }
        
        // Kiểm tra định dạng file
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Định dạng file không hợp lệ! Vui lòng chọn ảnh JPG, PNG, GIF hoặc WebP.');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('imagePreview');
            
            if (preview && imagePreview) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
        }
        reader.readAsDataURL(file);
    }
}

/**
 * Auto-hide alerts sau 5 giây
 */
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

/**
 * Đếm số ký tự trong textarea
 */
function initCharacterCount() {
    const contentTextarea = document.getElementById('content');
    
    if (contentTextarea) {
        const charCountDiv = document.createElement('div');
        charCountDiv.style.cssText = 'text-align: right; color: #6c757d; font-size: 13px; margin-top: 4px;';
        charCountDiv.id = 'charCount';
        
        contentTextarea.parentNode.appendChild(charCountDiv);
        
        function updateCount() {
            const count = contentTextarea.value.length;
            charCountDiv.textContent = `${count} ký tự`;
        }
        
        contentTextarea.addEventListener('input', updateCount);
        updateCount();
    }
}

// Khởi chạy khi DOM load xong
document.addEventListener('DOMContentLoaded', function() {
    initCharacterCount();
});

/**
 * Xác nhận trước khi rời trang nếu có thay đổi trong form
 */
function initFormChangeDetection() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        let formChanged = false;
        
        // Lắng nghe sự thay đổi
        form.addEventListener('change', function() {
            formChanged = true;
        });
        
        form.addEventListener('input', function() {
            formChanged = true;
        });
        
        // Reset khi submit
        form.addEventListener('submit', function() {
            formChanged = false;
        });
        
        // Cảnh báo khi rời trang
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
                return '';
            }
        });
    });
}

// Khởi chạy form change detection
document.addEventListener('DOMContentLoaded', function() {
    initFormChangeDetection();
});

/**
 * Tự động tạo slug từ title (nếu cần)
 */
function generateSlug() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            // Chỉ tự động tạo slug nếu slug đang trống
            if (slugInput.value === '') {
                const slug = this.value
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/đ/g, 'd')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                
                slugInput.value = slug;
            }
        });
    }
}

// Khởi chạy slug generator
document.addEventListener('DOMContentLoaded', function() {
    generateSlug();
});

/**
 * Xác thực form trước khi submit
 */
function validateForm() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const title = document.getElementById('title');
            const content = document.getElementById('content');
            const category = document.getElementById('category_id');
            
            // Kiểm tra tiêu đề
            if (title && title.value.trim().length < 10) {
                e.preventDefault();
                alert('Tiêu đề phải có ít nhất 10 ký tự!');
                title.focus();
                return false;
            }
            
            // Kiểm tra nội dung
            if (content && content.value.trim().length < 50) {
                e.preventDefault();
                alert('Nội dung phải có ít nhất 50 ký tự!');
                content.focus();
                return false;
            }
            
            // Kiểm tra danh mục
            if (category && category.value === '') {
                e.preventDefault();
                alert('Vui lòng chọn danh mục!');
                category.focus();
                return false;
            }
            
            return true;
        });
    });
}

// Khởi chạy form validation
document.addEventListener('DOMContentLoaded', function() {
    validateForm();
});

/**
 * Smooth scroll về form khi có lỗi
 */
function scrollToError() {
    const alerts = document.querySelectorAll('.alert-error');
    
    if (alerts.length > 0) {
        alerts[0].scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    }
}

// Khởi chạy scroll to error
document.addEventListener('DOMContentLoaded', function() {
    scrollToError();
});

/**
 * Toggle preview/edit mode cho form
 */
function initPreviewMode() {
    const contentTextarea = document.getElementById('content');
    
    if (contentTextarea) {
        const previewBtn = document.createElement('button');
        previewBtn.type = 'button';
        previewBtn.className = 'btn btn-secondary';
        previewBtn.innerHTML = '<i class="fas fa-eye"></i> Xem trước';
        previewBtn.style.marginTop = '8px';
        
        const previewDiv = document.createElement('div');
        previewDiv.id = 'contentPreview';
        previewDiv.className = 'content-box';
        previewDiv.style.display = 'none';
        previewDiv.style.marginTop = '12px';
        
        contentTextarea.parentNode.appendChild(previewBtn);
        contentTextarea.parentNode.appendChild(previewDiv);
        
        let isPreview = false;
        
        previewBtn.addEventListener('click', function() {
            if (!isPreview) {
                // Show preview
                previewDiv.textContent = contentTextarea.value;
                previewDiv.style.display = 'block';
                contentTextarea.style.display = 'none';
                previewBtn.innerHTML = '<i class="fas fa-edit"></i> Chỉnh sửa';
                isPreview = true;
            } else {
                // Show edit
                previewDiv.style.display = 'none';
                contentTextarea.style.display = 'block';
                previewBtn.innerHTML = '<i class="fas fa-eye"></i> Xem trước';
                isPreview = false;
            }
        });
    }
}

// Khởi chạy preview mode
document.addEventListener('DOMContentLoaded', function() {
    initPreviewMode();
});