// public/js/user.js

/**
 * Xác nhận toggle trạng thái người dùng
 */
function confirmToggle(id) {
    return confirm('Bạn có chắc chắn muốn thay đổi trạng thái user này?');
}

/*
 * Animation load bảng*/
function initTableAnimation() {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
}

// Khởi chạy JS khi DOM load xong
document.addEventListener('DOMContentLoaded', function() {
    initUserSearch();
    initTableAnimation();
});