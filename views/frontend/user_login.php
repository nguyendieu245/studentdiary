<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="CSS/style.css"> 
    <link rel="stylesheet" href="../../public/css/user_login.css"> 
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=user_login">
            <div class="form-group">
                <label for="username">Tên đăng nhập hoặc Email:</label>
                <input type="text" name="username" id="username" required 
                       placeholder="Nhập tên đăng nhập hoặc email..." 
                       value="<?php echo htmlspecialchars($username ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
            </div>
            <button type="submit">Đăng nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="/studentdiary/views/frontend/register.php">Đăng ký ngay</a></p>
    </div>
</body>
</html>
