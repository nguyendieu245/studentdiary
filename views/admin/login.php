  

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="/studentdiary/public/css/admin_login.css">

</head>

<div class="login-container">
    <h2> Đăng nhập </h2>

    <?php
        // Hiển thị thông báo lỗi nếu biến $error được Controller truyền vào
        if (!empty($error)):
    ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/studentdiary/public/index.php?action=admin_login">
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" id="username" required placeholder="Nhập tên đăng nhập...">
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required placeholder="••••••••">
        </div>
        <div class="form-group">
            <button type="submit" class="btn-submit">Đăng nhập</button>
        </div>
    </form>
</div>

