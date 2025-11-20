<?php
// Chặn truy cập nếu chưa login hoặc không phải admin
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /studentdiary/public/index.php?action=user_login");
    exit;
}
?>

<link rel="stylesheet" href="assets/css/admin.css">

<div class="admin-wrapper">
    <h2>Danh sách người dùng</h2>

    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['id']) ?></td>
                        <td><?= htmlspecialchars($u['fullname']) ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        
                        <td>
                            <?php if ($u['status'] == 1): ?>
                                <span class="status-active">Hoạt động</span>
                            <?php else: ?>
                                <span class="status-inactive">Vô hiệu hóa</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['status'] == 1): ?>
                                <a href="?action=deactivate&id=<?= $u['id'] ?>" class="btn-deactivate" onclick="return confirm('Bạn có chắc muốn vô hiệu hóa người dùng này?');">Vô hiệu hóa</a>
                            <?php else: ?>
                                <a href="?action=activate&id=<?= $u['id'] ?>" class="btn-activate" onclick="return confirm('Bạn có chắc muốn kích hoạt người dùng này?');">Kích hoạt</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Chưa có người dùng nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.admin-wrapper {
    padding: 20px;
    font-family: Poppins, sans-serif;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.user-table th, .user-table td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: center;
}

.user-table th {
    background-color: #f5f5f5;
    color: #333;
}

.status-active {
    color: green;
    font-weight: bold;
}

.status-inactive {
    color: red;
    font-weight: bold;
}

.btn-activate, .btn-deactivate {
    padding: 4px 8px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 0.9rem;
}

.btn-activate {
    background-color: green;
}

.btn-deactivate {
    background-color: red;
}
</style>
