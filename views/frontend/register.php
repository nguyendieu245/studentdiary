<?php
?>

<head>
    <meta charset="UTF-8">
    <title>Đăng ký User</title>
    <link rel="stylesheet" href="/studentdiary/public/css/register.css">
</head>

<div class="register-container">
    <h2> Đăng ký </h2>

    <?php
        // Hiển thị thông báo nếu biến $message được Controller truyền vào
        if (!empty($message)):
    ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="/studentdiary/public/index.php?action=register">
        <div class="form-group">
            <label for="fullname">Họ tên:</label>
            <input type="text" name="fullname" id="fullname" required placeholder="Nhập họ tên...">
        </div>
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" id="username" required placeholder="Nhập tên đăng nhập...">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required placeholder="Nhập email...">
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required placeholder="••••••••">
        </div>
        <div class="form-group">
            <button type="submit" class="btn-submit">Đăng ký</button>
        </div>
    </form>

    <p>Đã có tài khoản? <a href="/studentdiary/public/index.php?action=user_login">Đăng nhập</a></p>
</div>
