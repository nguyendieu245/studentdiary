// public/js/user.js - JavaScript cho quản lý người dùng

/**
 * Xác nhận xóa người dùng
 */
function confirmDelete(id, username) {
    const message = username 
        ? `Bạn có chắc chắn muốn xóa người dùng "${username}"?\n\nThao tác này không thể hoàn tác!`
        : 'Bạn có chắc chắn muốn xóa người dùng này?\n\nThao tác này không thể hoàn tác!';
    
    if (confirm(message)) {
        window.location.href = 'index.php?action=delete_user&id=' + id;
    }
}

/**
 * Toggle trạng thái kích hoạt người dùng
 */
function toggleUserStatus(id, currentStatus) {
    const action = currentStatus == 1 ? 'vô hiệu hóa' : 'kích hoạt';
    if (confirm(`Bạn có chắc chắn muốn ${action} người dùng này?`)) {
        window.location.href = 'index.php?action=toggle_user_status&id=' + id;
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
 * Search/Filter người dùng trong bảng
 */
function initUserSearch() {
    const searchInput = document.getElementById('userSearch');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('tbody tr:not(.empty-state)');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const userName = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
                const userEmail = row.querySelector('.user-email')?.textContent.toLowerCase() || '';
                const role = row.querySelector('.role-badge')?.textContent.toLowerCase() || '';
                
                if (userName.includes(searchTerm) || 
                    userEmail.includes(searchTerm) || 
                    role.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Hiển thị thông báo nếu không tìm thấy
            updateSearchResults(visibleCount);
        });
    }
}

/**
 * Cập nhật kết quả tìm kiếm
 */
function updateSearchResults(count) {
    let resultDiv = document.getElementById('searchResults');
    
    if (!resultDiv) {
        resultDiv = document.createElement('div');
        resultDiv.id = 'searchResults';
        resultDiv.style.cssText = 'padding: 12px; background: #e8f3ff; border-radius: 8px; margin-bottom: 16px; color: #1e3a5f; font-size: 14px;';
        document.querySelector('.table-container').parentNode.insertBefore(
            resultDiv, 
            document.querySelector('.table-container')
        );
    }
    
    if (document.getElementById('userSearch').value.trim() !== '') {
        resultDiv.textContent = `Tìm thấy ${count} kết quả`;
        resultDiv.style.display = 'block';
    } else {
        resultDiv.style.display = 'none';
    }
}

// Khởi chạy search
document.addEventListener('DOMContentLoaded', function() {
    initUserSearch();
});

/**
 * Filter người dùng theo vai trò
 */
function initRoleFilter() {
    const tableContainer = document.querySelector('.table-container');
    if (tableContainer && !document.querySelector('.role-filter')) {
        const filterDiv = document.createElement('div');
        filterDiv.className = 'role-filter';
        filterDiv.style.cssText = 'margin-bottom: 16px; display: flex; gap: 8px; flex-wrap: wrap;';
        
        const filters = [
            { label: 'Tất cả', value: 'all' },
            { label: 'Admin', value: 'admin' },
            { label: 'Người dùng', value: 'user' }
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
                font-size: 14px;
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
                const rows = document.querySelectorAll('tbody tr:not(.empty-state)');
                let visibleCount = 0;
                
                rows.forEach(row => {
                    const roleBadge = row.querySelector('.role-badge');
                    if (roleBadge) {
                        if (filter.value === 'all') {
                            row.style.display = '';
                            visibleCount++;
                        } else if (filter.value === 'admin') {
                            if (roleBadge.classList.contains('role-admin')) {
                                row.style.display = '';
                                visibleCount++;
                            } else {
                                row.style.display = 'none';
                            }
                        } else if (filter.value === 'user') {
                            if (roleBadge.classList.contains('role-user')) {
                                row.style.display = '';
                                visibleCount++;
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    }
                });
            });
            
            filterDiv.appendChild(btn);
        });
        
        tableContainer.parentNode.insertBefore(filterDiv, tableContainer);
    }
}

// Khởi chạy role filter
document.addEventListener('DOMContentLoaded', function() {
    initRoleFilter();
});

/**
 * Filter theo trạng thái
 */
function initStatusFilter() {
    const tableContainer = document.querySelector('.table-container');
    const existingFilter = document.querySelector('.role-filter');
    
    if (tableContainer && existingFilter && !document.querySelector('.status-filter')) {
        const filterDiv = document.createElement('div');
        filterDiv.className = 'status-filter';
        filterDiv.style.cssText = 'margin-bottom: 16px; display: flex; gap: 8px; flex-wrap: wrap;';
        
        const label = document.createElement('span');
        label.textContent = 'Trạng thái:';
        label.style.cssText = 'padding: 8px 0; font-weight: 600; color: #1e3a5f;';
        filterDiv.appendChild(label);
        
        const filters = [
            { label: 'Tất cả', value: 'all' },
            { label: 'Hoạt động', value: 'active' },
            { label: 'Vô hiệu', value: 'inactive' }
        ];
        
        filters.forEach(filter => {
            const btn = document.createElement('button');
            btn.textContent = filter.label;
            btn.className = 'status-filter-btn';
            btn.dataset.filter = filter.value;
            btn.style.cssText = `
                padding: 8px 16px;
                border: 2px solid #d0e1f0;
                background: white;
                border-radius: 6px;
                cursor: pointer;
                font-weight: 500;
                transition: 0.3s;
                font-size: 14px;
            `;
            
            if (filter.value === 'all') {
                btn.style.background = '#3a7ca5';
                btn.style.color = 'white';
                btn.style.borderColor = '#3a7ca5';
            }
            
            btn.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.status-filter-btn').forEach(b => {
                    b.style.background = 'white';
                    b.style.color = '#1e3a5f';
                    b.style.borderColor = '#d0e1f0';
                });
                
                this.style.background = '#3a7ca5';
                this.style.color = 'white';
                this.style.borderColor = '#3a7ca5';
                
                // Filter rows
                const rows = document.querySelectorAll('tbody tr:not(.empty-state)');
                
                rows.forEach(row => {
                    const statusBadge = row.querySelector('.status-badge');
                    if (statusBadge) {
                        if (filter.value === 'all') {
                            row.style.display = '';
                        } else if (filter.value === 'active') {
                            row.style.display = statusBadge.classList.contains('status-active') ? '' : 'none';
                        } else if (filter.value === 'inactive') {
                            row.style.display = statusBadge.classList.contains('status-inactive') ? '' : 'none';
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

/**
 * Xác thực form tạo/sửa người dùng
 */
function validateUserForm() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            
            // Kiểm tra username
            if (username && username.value.trim().length < 3) {
                e.preventDefault();
                alert('Tên đăng nhập phải có ít nhất 3 ký tự!');
                username.focus();
                return false;
            }
            
            // Kiểm tra email
            if (email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value)) {
                    e.preventDefault();
                    alert('Email không hợp lệ!');
                    email.focus();
                    return false;
                }
            }
            
            // Kiểm tra password (chỉ khi tạo mới hoặc có nhập password)
            if (password && password.value.trim() !== '') {
                if (password.value.length < 6) {
                    e.preventDefault();
                    alert('Mật khẩu phải có ít nhất 6 ký tự!');
                    password.focus();
                    return false;
                }
                
                // Kiểm tra confirm password
                if (confirmPassword && password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Mật khẩu xác nhận không khớp!');
                    confirmPassword.focus();
                    return false;
                }
            }
            
            return true;
        });
    });
}

// Khởi chạy form validation
document.addEventListener('DOMContentLoaded', function() {
    validateUserForm();
});

/**
 * Preview avatar trước khi upload
 */
function previewAvatar(event) {
    const file = event.target.files[0];
    
    if (file) {
        // Kiểm tra kích thước file (max 2MB)
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Kích thước ảnh quá lớn! Vui lòng chọn ảnh nhỏ hơn 2MB.');
            event.target.value = '';
            return;
        }
        
        // Kiểm tra định dạng
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Định dạng ảnh không hợp lệ! Vui lòng chọn JPG, PNG, GIF hoặc WebP.');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        }
        reader.readAsDataURL(file);
    }
}

/**
 * Toggle hiển thị password
 */
function initPasswordToggle() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    
    passwordInputs.forEach(input => {
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        toggleBtn.style.cssText = `
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 8px;
        `;
        
        toggleBtn.addEventListener('click', function() {
            if (input.type === 'password') {
                input.type = 'text';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                input.type = 'password';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
        
        wrapper.appendChild(toggleBtn);
        
        // Adjust input padding
        input.style.paddingRight = '40px';
    });
}

// Khởi chạy password toggle
document.addEventListener('DOMContentLoaded', function() {
    initPasswordToggle();
});

/**
 * Animation khi load bảng
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

// Khởi chạy animation
document.addEventListener('DOMContentLoaded', function() {
    initTableAnimation();
});

/**
 * Cập nhật stats real-time (nếu cần)
 */
function updateUserStats() {
    const statCards = document.querySelectorAll('.stat-number');
    
    statCards.forEach(card => {
        const finalValue = parseInt(card.textContent);
        let currentValue = 0;
        const increment = Math.ceil(finalValue / 30);
        
        card.textContent = '0';
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                card.textContent = finalValue;
                clearInterval(timer);
            } else {
                card.textContent = currentValue;
            }
        }, 30);
    });
}

// Khởi chạy stats animation
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.stats-container')) {
        updateUserStats();
    }
});