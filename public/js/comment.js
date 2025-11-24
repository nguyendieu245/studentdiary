// ==========================================
// FILE: comment.js - Quản lý bình luận
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

// Tự động ẩn thông báo sau 3 giây
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    if(alerts.length > 0) {
        setTimeout(function() {
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 3000);
    }
});

// Đếm số ký tự trong textarea phản hồi
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

// Xác thực form phản hồi trước khi submit
function validateReplyForm() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const replyContent = document.querySelector('textarea[name="reply_content"]');
            
            if (replyContent) {
                const content = replyContent.value.trim();
                
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

// Highlight bình luận khi hover vào phản hồi
function initCommentHighlight() {
    const replyRows = document.querySelectorAll('.reply-row');
    
    replyRows.forEach(replyRow => {
        replyRow.addEventListener('mouseenter', function() {
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

// Thêm animation khi load trang
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

// Xác nhận trước khi rời trang nếu đang soạn phản hồi
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

// Khởi chạy tất cả các tính năng khi DOM load xong
document.addEventListener('DOMContentLoaded', function() {
    initCharacterCount();
    validateReplyForm();
    initCommentHighlight();
    initTableAnimation();
    initFormChangeDetection();
});