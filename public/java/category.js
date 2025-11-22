// public/js/category.js - JavaScript cho quản lý danh mục

/**
 * Xác nhận xóa danh mục
 * @param {number} id - ID của danh mục cần xóa
 * @param {number} postCount - Số lượng bài viết trong danh mục
 */
function confirmDelete(id, postCount) {
    if (postCount > 0) {
        alert('Không thể xóa danh mục này vì còn ' + postCount + ' bài viết!\n\nVui lòng di chuyển hoặc xóa các bài viết trước khi xóa danh mục.');
        return;
    }
    
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này?\n\nHành động này không thể hoàn tác!')) {
        window.location.href = 'index.php?action=delete_category&id=' + id;
    }
}

/**
 * Tự động tạo slug từ tên danh mục
 */
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        // Chỉ tự động tạo slug khi thêm mới (slug trống)
        let isManualEdit = slugInput.value !== '';
        
        slugInput.addEventListener('input', function() {
            isManualEdit = true;
        });
        
        nameInput.addEventListener('input', function() {
            if (!isManualEdit) {
                slugInput.value = createSlug(this.value);
            }
        });
    }
});

/**
 * Tạo slug từ chuỗi tiếng Việt
 * @param {string} str - Chuỗi cần chuyển đổi
 * @returns {string} - Slug
 */
function createSlug(str) {
    str = str.toLowerCase().trim();
    
    // Chuyển đổi ký tự có dấu
    const from = 'àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ·/_,:;';
    const to = 'aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd------';
    
    for (let i = 0; i < from.length; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    
    // Loại bỏ ký tự đặc biệt
    str = str.replace(/[^a-z0-9 -]/g, '')
             .replace(/\s+/g, '-')
             .replace(/-+/g, '-')
             .replace(/^-+/, '')
             .replace(/-+$/, '');
    
    return str;
}

/**
 * Auto-hide alerts sau 5 giây
 */
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

/**
 * Highlight row khi hover
 */
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});