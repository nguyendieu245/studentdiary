<?php  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../layouts/header.php'; 
echo '<link rel="stylesheet" href="/studentdiary/public/css/style.css">';

$username = $_SESSION['user']['username'] ?? 'Người dùng';
?>

<div class="container mt-4">
    <h2>
        <?php 
            // Hiển thị tiêu đề dựa trên category_name của các bài viết đầu tiên
            if (!empty($posts)) {
                echo htmlspecialchars($posts[0]['category_name']);
            } else {
                // fallback theo $currentPage
                echo ($currentPage=='skill') ? 'Kỹ năng' : 
                     (($currentPage=='study') ? 'Học tập' : 'Đời sống'); 
            }
        ?>
    </h2>

    <div class="row">
        <?php if($posts): ?>
            <?php foreach($posts as $post): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <?php if($post['image']): ?>
                            <img src="/studentdiary/public/uploads/<?= htmlspecialchars($post['image']) ?>" 
                                 alt="<?= htmlspecialchars($post['title']) ?>" 
                                 class="post-image">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/80x60?text=No+Image" 
                                 alt="No image" 
                                 class="post-image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text"><small class="text-muted"><?= date('d/m/Y', strtotime($post['created_at'])) ?></small></p>

                            <?php
                                // Chọn action dựa trên category_id
                                switch($post['category_id']) {
                                    case 1: $detailAction = 'skill_detail'; break;
                                    case 2: $detailAction = 'social_detail'; break;
                                    case 3: $detailAction = 'study_detail'; break;
                                    default: $detailAction = 'post_detail';
                                }
                            ?>
                            <a href="index.php?action=<?= $detailAction ?>&id=<?= $post['id'] ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Hiện chưa có bài viết nào.</p>
        <?php endif; ?>
    </div>
</div>
