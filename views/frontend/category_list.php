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
    <h2>
        <?php 
            echo ($currentPage=='skill') ? 'Kỹ năng' : 
                 (($currentPage=='study') ? 'Học tập' : 'Đời sống'); 
        ?>
    </h2>

    <div class="row">
        <?php if($posts): ?>
            <?php foreach($posts as $post): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="public/uploads/<?= htmlspecialchars($post['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text"><small class="text-muted"><?= date('d/m/Y', strtotime($post['created_at'])) ?></small></p>
                            <a href="index.php?action=<?= ($currentPage=='skill')?'skill_detail':(($currentPage=='study')?'study_detail':'social_detail') ?>&id=<?= $post['id'] ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Hiện chưa có bài viết nào.</p>
        <?php endif; ?>
    </div>
</div>


