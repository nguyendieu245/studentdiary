<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/styleadmin.css"> 
    <title>Danh sách người dùng - Student Diary Admin</title>
</head>
<body>

    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <div class="main-content">
        <a href="/studentdiary/public/index.php?action=dashboard" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại trang chính
        </a>

        <div class="user-table-container">
            <h2>Danh sách người dùng</h2>

            <?php if (!empty($users)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Họ & Tên</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u['id']) ?></td>
                                <td><?= htmlspecialchars($u['username']) ?></td>
                                <td><?= htmlspecialchars($u['fullname']) ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td>
                                    <?php if ($u['status'] == 1): ?>
                                        <span class="status-badge status-active">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge status-inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a class="btn btn-toggle"
                                       href="index.php?action=user_list&toggle_id=<?= $u['id'] ?>"
                                       onclick="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái user này?');">
                                        <?= $u['status'] == 1 ? 'Vô hiệu hóa' : 'Kích hoạt' ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <p>Chưa có người dùng nào.</p>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>
