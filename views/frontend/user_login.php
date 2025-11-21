

<?php
?>
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập User</title>
    <link rel="stylesheet" href="/studentdiary/public/css/user_login.css">
</head>

<div class="login-container">
    <h2> Đăng nhập </h2>

    <?php
        if (!empty($error)):
    ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/studentdiary/public/index.php?action=user_login">
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
<div class="login-link">
        <span>Bạn chưa có tài khoản? </span>
        <a href="/studentdiary/public/index.php?action=register">Đăng ký ngay</a>
    </div>

