<?php 
// Bắt đầu session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 include __DIR__ . '/../layouts/header.php'; 
 
// Lấy tên người dùng
$username = $_SESSION['user']['username'] ?? 'Người dùng';
?>

<div class="container mt-4">
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p class="text-muted">Tác giả: <?= htmlspecialchars($post['author_name']) ?> | Ngày: <?= date('d/m/Y', strtotime($post['created_at'])) ?> 
    
    <?php if($post['image']): ?>
        <img src="public/uploads/<?= htmlspecialchars($post['image']) ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($post['title']) ?>">
    <?php endif; ?>

    <div class="content mb-4"><?= nl2br(htmlspecialchars($post['content'])) ?></div>

    <hr>
    <h3>Bình luận</h3>

    <form action="index.php?action=store_comment&post_id=<?= $post['id'] ?>" method="POST" class="mb-4">
        <div class="mb-3">
            <label for="comment_content" class="form-label">Viết bình luận:</label>
            <textarea name="content" id="comment_content" rows="3" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Gửi</button>
    </form>

    <?php if($comments): ?>
        <?php foreach($comments as $cmt): ?>
            <div class="mb-3 border p-2 rounded">
                <p><strong><?= htmlspecialchars($cmt['user_name']) ?></strong> <small class="text-muted"><?= date('d/m/Y H:i', strtotime($cmt['created_at'])) ?></small></p>
                <p><?= nl2br(htmlspecialchars($cmt['content'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có bình luận nào.</p>
    <?php endif; ?>
</div>
<?php 
// Include footer chung
include __DIR__ . '/../layouts/footer.php'; 
?>


