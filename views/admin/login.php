
<body>

    <div class="login-box">
        <h2>Đăng nhập Admin</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/Studentdiary/public/index.php?action=admin_login">
    <label>Tên đăng nhập:</label>
    <input type="text" name="username" required>

    <label>Mật khẩu:</label>
    <input type="password" name="password" required>

    <button type="submit">Đăng nhập</button>
</form>

    </div>

</body>
</html>
