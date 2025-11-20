<?php
include __DIR__ . '/../../layouts/header.php'; 


// Giả định biến $users được truyền vào từ UserController
$users = $users ?? [];
?>

<style>
    /* Phần này có thể được chuyển sang tệp CSS riêng */
    .container { padding: 20px; }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .data-table th, .data-table td {
        border: 1px solid #e0e0e0ff;
        padding: 12px 10px;
        text-align: left;
    }
    .data-table th {
        background-color: #e5c4c4ff; 
        color: #333;
        font-weight: bold;
        text-transform: uppercase;
    }
    .data-table tbody tr:nth-child(even) {
        background-color: #f9f9f9; 
    }
    .action-cell {
        white-space: nowrap;
        text-align: center;
        width: 100px;
    }
    .action-cell .btn {
        padding: 8px 10px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        color: white;
        font-size: 14px;
        margin: 2px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        text-decoration: none; 
    }
    .btn-delete {
        background-color: #dc3545; 
        font-family: 'Font Awesome 5 Free', 'Arial'; 
        font-weight: 900; 
    }
    .btn-delete:before {
        content: "\f2ed"; 
    }
    .stt-cell {
        text-align: center;
        width: 5%;
    }
    h2 { color: #333; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
</style>


<div class="container">
    <h2>Quản lý Tài khoản Người dùng</h2>

    <table class="data-table">
        <thead>
            <tr>
                <th class="stt-cell">STT</th>
                <th>ID</th>
                <th>Tên đăng nhập</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th class="action-cell">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $stt = 1;
            foreach ($users as $user): 
            ?>
                <tr>
                    <td class="stt-cell"><?= $stt++ ?></td>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['fullname']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td class="action-cell">
                        <a href="/studentdiary/public/index.php?action=delete_user&id=<?= htmlspecialchars($user['id']) ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản <?= htmlspecialchars($user['username']) ?> không?')"
                           class="btn btn-delete" 
                           title="Xóa người dùng">
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #777;">Chưa có người dùng nào được tạo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
