// ==========================================
// FILE 1: Danh sách bình luận (comments list)
// ==========================================

// Hàm xác nhận xóa bình luận
function confirmDelete(id) {
    if(confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
        window.location.href = 'index.php?action=delete_comment&id=' + id;
    }
}

// Hàm chuyển đổi trạng thái hiển thị/ẩn
function toggleStatus(id) {
    window.location.href = 'index.php?action=toggle_comment&id=' + id;
}

// ==========================================
// FILE 2: Chi tiết bình luận (comment detail)
// ==========================================
// (Sử dụng chung các hàm trên)

// ==========================================
// CHUNG: Tự động ẩn thông báo
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    if(alerts.length > 0) {
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