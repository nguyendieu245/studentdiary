// public/js/user.js

/**
 * Xác nhận toggle trạng thái người dùng
 */
function confirmToggle(id) {
    return confirm('Bạn có chắc chắn muốn thay đổi trạng thái user này?');
}

/**
 * Search/Filter người dùng trong bảng (nếu muốn thêm sau này)
 */
function initUserSearch() {
    const searchInput = document.getElementById('userSearch');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const username = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const fullname = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const email = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
            if (username.includes(searchTerm) || fullname.includes(searchTerm) || email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

/**
 * Animation load bảng
 */
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
