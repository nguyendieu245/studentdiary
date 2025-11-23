<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo '<link rel="stylesheet" href="/studentdiary/public/css/style.css">';
include __DIR__ . '/../layouts/header.php';

// Kiểm tra đăng nhập
$user_logged_in = isset($_SESSION['user']);
$username = $user_logged_in ? $_SESSION['user']['username'] : '';

// Lấy danh sách comment theo post 
$post_id = $post['id'] ?? 0;
$comments = $commentCtrl->getCommentsByPost($post_id);
?>

<div class="post-detail-container">

    <!-- Tiêu đề bài viết -->
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p class="text-muted">
        Tác giả: <?= htmlspecialchars($post['author_name']) ?> |
        Ngày: <?= date('d/m/Y', strtotime($post['created_at'])) ?>
    </p>

    <!-- Ảnh bài viết -->
    <?php if (!empty($post['image'])): ?>
        <img src="/studentdiary/public/uploads/<?= htmlspecialchars($post['image']) ?>" 
             alt="<?= htmlspecialchars($post['title']) ?>" class="post-image mb-3">
    <?php else: ?>
        <img src="https://via.placeholder.com/800x400?text=No+Image" 
             alt="No image" class="post-image mb-3">
    <?php endif; ?>

    <!-- Nội dung bài viết -->
    <div class="content mb-4">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>

    <hr>

    <!-- Bình luận -->
    <h3 class="mt-4">Bình luận</h3>

    <div class="comments-box">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $c): ?>
                
                <?php if ($c['status'] == 1): ?>
                <div class="comment-item mb-3 p-2 border rounded">
                    <b><?= htmlspecialchars($c['name']) ?></b>
                    <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
                    <small class="text-muted"><?= $c['created_at'] ?></small>

                    <!-- Reply -->
                    <?php if (!empty($c['replies'])): ?>
                        <div class="comment-replies mt-2">
                            <?php foreach ($c['replies'] as $r): ?>
                                <?php if ($r['status'] == 1): ?>
                                    <div class="reply-item mb-2 p-2" 
                                         style="margin-left: 25px; border-left: 2px solid #9d7863ff;">
                                        <b style="color: #9d7863ff;">
                                            <?= $r['is_admin'] ? 'Admin' : htmlspecialchars($r['name']) ?>
                                        </b>
                                        <p><?= nl2br(htmlspecialchars($r['comment'])) ?></p>
                                        <small class="text-muted"><?= $r['created_at'] ?></small>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có bình luận nào.</p>
        <?php endif; ?>
    </div>

    <hr>

    <!-- Form bình luận -->
    <h4 class="mt-4">Gửi bình luận của bạn</h4>

    <?php if ($user_logged_in): ?>
        <form action="index.php?action=add_comment" method="POST" class="comment-form">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">

            <div class="mb-2">
                <label>Bình luận:</label>
                <textarea name="comment" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
        </form>
    <?php else: ?>
        <p class="text-danger">
            Bạn phải <a href="/studentdiary/public/index.php?action=user_login">đăng nhập</a> mới có thể bình luận.
        </p>
    <?php endif; ?>

</div>

<?php 
include __DIR__ . '/../layouts/footer.php'; 
?>
