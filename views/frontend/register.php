<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="../../public/css/register.css"> 
</head>

<body>
    <div class="register-container">
        <h2>Đăng ký tài khoản</h2>

        <?php if (!empty($registrationError)): ?>
            <div class="message error"><?= htmlspecialchars($registrationError); ?></div>
        <?php elseif (!empty($registrationSuccess)): ?>
            <div class="message success"><?= $registrationSuccess; ?></div>
        <?php endif; ?>

        <form action="register_user.php" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" name="username" required value="<?= htmlspecialchars($username ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" name="fullname" required value="<?= htmlspecialchars($fullname ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($email ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu:</label>
                <input type="password" name="confirm_password" required>
            </div>

            <button type="submit">Đăng ký</button>
        </form>

        <div class="login-link">
            Đã có tài khoản? <a href="user_login.php">Đăng nhập ngay</a>
        </div>
    </div>
</body>
</html>