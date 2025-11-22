// public/js/comment.js - JavaScript cho quản lý bình luận

/**
 * Xác nhận xóa bình luận
 */
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa bình luận này?\n\nLưu ý: Nếu đây là bình luận gốc, tất cả phản hồi cũng sẽ bị xóa.')) {
        window.location.href = 'index.php?action=delete_comment&id=' + id;
    }
}

/**
 * Toggle trạng thái hiển thị/ẩn bình luận
 */
function toggleStatus(id) {
    window.location.href = 'index.php?action=toggle_comment&id=' + id;
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
 * Đếm số ký tự trong textarea phản hồi
 */
function initCharacterCount() {
    const replyTextarea = document.querySelector('textarea[name="reply_content"]');
    
    if (replyTextarea) {
        const charCountDiv = document.createElement('div');
        charCountDiv.style.cssText = 'text-align: right; color: #6c757d; font-size: 13px; margin-top: 4px;';
        charCountDiv.id = 'replyCharCount';
        
        replyTextarea.parentNode.insertBefore(charCountDiv, replyTextarea.nextSibling);
        
        function updateCount() {
            const count = replyTextarea.value.length;
            const maxLength = 1000;
            charCountDiv.textContent = `${count}/${maxLength} ký tự`;
            
            if (count > maxLength) {
                charCountDiv.style.color = '#dc3545';
            } else if (count > maxLength * 0.9) {
                charCountDiv.style.color = '#ffa726';
            } else {
                charCountDiv.style.color = '#6c757d';
            }
        }
        
        replyTextarea.addEventListener('input', updateCount);
        updateCount();
    }
}

// Khởi chạy khi DOM load xong
document.addEventListener('DOMContentLoaded', function() {
    initCharacterCount();
});

/**
 * Xác thực form phản hồi trước khi submit
 */
function validateReplyForm() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const replyContent = document.querySelector('textarea[name="reply_content"]');
            
            if (replyContent) {
                const content = replyContent.value.trim();
                
                // Kiểm tra nội dung không được để trống
                if (content.length === 0) {
                    e.preventDefault();
                    alert('Vui lòng nhập nội dung phản hồi!');
                    replyContent.focus();
                    return false;
                }
                
                
            }
            
            return true;
        });
    });
}

// Khởi chạy form validation
document.addEventListener('DOMContentLoaded', function() {
    validateReplyForm();
});

/**
 * Highlight bình luận khi hover vào phản hồi tương ứng
 */
function initCommentHighlight() {
    const replyRows = document.querySelectorAll('.reply-row');
    
    replyRows.forEach(replyRow => {
        replyRow.addEventListener('mouseenter', function() {
            // Tìm bình luận gốc phía trên
            let prevRow = this.previousElementSibling;
            while (prevRow && prevRow.classList.contains('reply-row')) {
                prevRow = prevRow.previousElementSibling;
            }
            
            if (prevRow && !prevRow.classList.contains('reply-row')) {
                prevRow.style.backgroundColor = '#e3f2fd';
            }
        });
        
        replyRow.addEventListener('mouseleave', function() {
            let prevRow = this.previousElementSibling;
            while (prevRow && prevRow.classList.contains('reply-row')) {
                prevRow = prevRow.previousElementSibling;
            }
            
            if (prevRow && !prevRow.classList.contains('reply-row')) {
                prevRow.style.backgroundColor = '';
            }
        });
    });
}

// Khởi chạy comment highlight
document.addEventListener('DOMContentLoaded', function() {
    initCommentHighlight();
});

/**
 * Thêm tooltip cho các nút action
 */
function initTooltips() {
    const buttons = document.querySelectorAll('.btn-icon[title]');
    
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = this.getAttribute('title');
            tooltip.style.cssText = `
                position: absolute;
                background: #1e3a5f;
                color: white;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 12px;
                white-space: nowrap;
                z-index: 1000;
                pointer-events: none;
                box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            `;
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
            tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
            
            this._tooltip = tooltip;
        });
        
        button.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                delete this._tooltip;
            }
        });
    });
}

// Khởi chạy tooltips
document.addEventListener('DOMContentLoaded', function() {
    initTooltips();
});

/**
 * Thêm animation khi load trang
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

// Khởi chạy table animation
document.addEventListener('DOMContentLoaded', function() {
    initTableAnimation();
});

/**
 * Xác nhận trước khi rời trang nếu đang soạn phản hồi
 */
function initFormChangeDetection() {
    const replyTextarea = document.querySelector('textarea[name="reply_content"]');
    
    if (replyTextarea) {
        let hasContent = false;
        
        replyTextarea.addEventListener('input', function() {
            hasContent = this.value.trim().length > 0;
        });
        
        const form = replyTextarea.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                hasContent = false;
            });
        }
        
        window.addEventListener('beforeunload', function(e) {
            if (hasContent) {
                e.preventDefault();
                e.returnValue = '';
                return '';
            }
        });
    }
}

// Khởi chạy form change detection
document.addEventListener('DOMContentLoaded', function() {
    initFormChangeDetection();
});

/**
 * Filter bình luận theo trạng thái
 */
function initStatusFilter() {
    // Tạo filter buttons nếu chưa có
    const tableContainer = document.querySelector('.table-container');
    if (tableContainer && !document.querySelector('.filter-buttons')) {
        const filterDiv = document.createElement('div');
        filterDiv.className = 'filter-buttons';
        filterDiv.style.cssText = 'margin-bottom: 16px; display: flex; gap: 8px;';
        
        const filters = [
            { label: 'Tất cả', value: 'all' },
            { label: 'Hiển thị', value: 'active' },
            { label: 'Ẩn', value: 'hidden' }
        ];
        
        filters.forEach(filter => {
            const btn = document.createElement('button');
            btn.textContent = filter.label;
            btn.className = 'filter-btn';
            btn.dataset.filter = filter.value;
            btn.style.cssText = `
                padding: 8px 16px;
                border: 2px solid #d0e1f0;
                background: white;
                border-radius: 6px;
                cursor: pointer;
                font-weight: 500;
                transition: 0.3s;
            `;
            
            if (filter.value === 'all') {
                btn.style.background = '#2c5f8d';
                btn.style.color = 'white';
                btn.style.borderColor = '#2c5f8d';
            }
            
            btn.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.style.background = 'white';
                    b.style.color = '#1e3a5f';
                    b.style.borderColor = '#d0e1f0';
                });
                
                this.style.background = '#2c5f8d';
                this.style.color = 'white';
                this.style.borderColor = '#2c5f8d';
                
                // Filter rows
                const rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const statusBadge = row.querySelector('.status-badge');
                    if (statusBadge) {
                        if (filter.value === 'all') {
                            row.style.display = '';
                        } else if (filter.value === 'active') {
                            row.style.display = statusBadge.classList.contains('status-active') ? '' : 'none';
                        } else if (filter.value === 'hidden') {
                            row.style.display = statusBadge.classList.contains('status-hidden') ? '' : 'none';
                        }
                    }
                });
            });
            
            filterDiv.appendChild(btn);
        });
        
        tableContainer.parentNode.insertBefore(filterDiv, tableContainer);
    }
}

// Khởi chạy status filter
document.addEventListener('DOMContentLoaded', function() {
    initStatusFilter();
});