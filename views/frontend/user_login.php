<<<<<<< HEAD
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
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
    </div>
</body>
</html>
=======
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
        // Hiển thị thông báo lỗi nếu biến $error được Controller truyền vào
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

    <p>Chưa có tài khoản? <a href="/studentdiary/public/index.php?action=user_register">Đăng ký</a></p>
</div>
>>>>>>> fc4a7dd55049805b98259254292d1b2fd193c8d2
