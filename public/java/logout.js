
function navigateTo(url) { 
    window.location.href = url; 
}

function handleLogout() { 
    if (confirm('Bạn có chắc chắn muốn đăng xuất không?')) {
        window.location.href = "/studentdiary/views/admin/login.php";
    }
}