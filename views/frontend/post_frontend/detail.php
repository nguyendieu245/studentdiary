<?php 
// views/frontend/post_frontend/detail_view.php
// View không có logic CSDL, chỉ hiển thị dữ liệu từ Controller
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $post ? safe_html($post['title']) : 'Chi tiết bài viết'; ?></title>
    
      <link rel="stylesheet" href="/studentdiary/public/css/style.css">

    <link rel="stylesheet" href="/studentdiary/public/css/detail.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <?php if ($post): ?>
        <meta property="og:title" content="<?php echo safe_html($post['title']); ?>">
        <meta property="og:description" content="<?php echo safe_html(mb_substr(strip_tags($post['content']), 0, 200, 'UTF-8') . '...'); ?>">
        <meta property="og:image" content="<?php echo safe_html($fullDisplayImageUrl); ?>">
        <meta property="og:url" content="<?php echo safe_html($current_url); ?>">
        <meta property="og:type" content="article">
        <meta property="og:site_name" content="Student Diary">
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo safe_html($post['title']); ?>">
        <meta name="twitter:description" content="<?php echo safe_html(mb_substr(strip_tags($post['content']), 0, 200, 'UTF-8') . '...'); ?>">
        <meta name="twitter:image" content="<?php echo safe_html($fullDisplayImageUrl); ?>">
    <?php endif; ?>

</head>
<body>
<?php 
// Đường dẫn include header.php cần được điều chỉnh tùy theo vị trí thực của View
include __DIR__ . '/../../layouts/header.php'; 
?>

<div class="container">
    <?php if ($post): ?>
        <div class="post-detail-header">
            <h1><?php echo safe_html($post['title']); ?></h1>
            <div class="post-meta">
                <span><i class="far fa-user"></i> <?php echo safe_html($post['author']); ?></span>
                <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                </div>
        </div>
        
        <?php if (!empty($fullDisplayImageUrl)): ?>
            <img src="<?php echo safe_html($fullDisplayImageUrl); ?>" alt="<?php echo safe_html($post['title']); ?>" class="post-image">
        <?php endif; ?>

        <div class="post-content-body">
            <?php echo $post['content']; ?>
        </div>

        <div class="share-box">
            <span class="share-label">Chia sẻ bài viết này:</span>
            <div class="share-icons">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_url); ?>" target="_blank" class="share-circle facebook-share">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($current_url); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" class="share-circle twitter-share">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="mailto:?subject=<?php echo urlencode($post['title']); ?>&body=Xem bài viết này: <?php echo urlencode($current_url); ?>" class="share-circle email-share">
                    <i class="far fa-envelope"></i>
                </a>
                <a href="https://t.me/share/url?url=<?php echo urlencode($current_url); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" class="share-circle telegram-share">
                    <i class="fab fa-telegram-plane"></i>
                </a>
            </div>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: #888; margin-top: 50px;">Bài viết không tồn tại hoặc đã bị xóa.</p>
    <?php endif; ?>

    <div class="comment-section" id="comments"> <h2>Bình luận</h2>
        <?php if ($post): ?>
            <?php if ($logged_in_user_id): // Nếu đã đăng nhập ?>
                <form action="index.php?action=comment&post_id=<?php echo safe_html($post['id']); ?>" method="POST" class="comment-form">
                    <textarea name="comment" placeholder="Viết bình luận của bạn..." required></textarea>
                    <button type="submit">Gửi bình luận</button>
                </form>
            <?php else: // Nếu chưa đăng nhập ?>
                <p style="text-align: center; color: #888;">Bạn cần <a href="<?php echo $base_url; ?>/Frontend/auth/user_login.php">đăng nhập</a> hoặc <a href="<?php echo $base_url; ?>/Frontend/auth/register_user.php">đăng ký</a> để bình luận.</p>
            <?php endif; ?>
        <?php else: ?>
            <p style="text-align: left; color: #888;">Bạn không thể bình luận vì bài viết không tồn tại.</p>
        <?php endif; ?>

        <div class="comments-list">
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment-block" id="comment-<?php echo $comment['id']; ?>">
                <div class="comment-header">
                    <span class="comment-author">
                        <?php echo safe_html($comment['ten_nguoi_binh_luan'] ?? ''); ?>
                        <?php if (isset($comment['is_admin']) && $comment['is_admin'] == 1): ?>
                            <span class="badge bg-primary">Admin</span>
                        <?php endif; ?>
                    </span>
                    <span class="comment-time"><?php echo date('H:i d/m/Y', strtotime($comment['created_at'])); ?></span>
                </div>
                <div class="comment-content" id="comment-content-<?php echo $comment['id']; ?>">
                    <?php echo nl2br(safe_html($comment['comment'] ?? '')); ?>
                </div>
                <div class="comment-actions">
                    <button class="reply-btn">Phản hồi</button>
                    <?php if ($logged_in_user_id && $comment['user_id'] == $logged_in_user_id): // Nếu là bình luận của người dùng hiện tại ?>
                        <div class="edit-delete-buttons">
                            <button class="edit-btn" data-comment-id="<?php echo $comment['id']; ?>">Sửa</button>
                            <button class="delete-btn" data-comment-id="<?php echo $comment['id']; ?>">Xóa</button>
                        </div>
                    <?php endif; ?>
                </div>
                
                <form action="index.php?action=comment&post_id=<?php echo safe_html($post['id']); ?>" method="POST" class="reply-form">
                    <input type="hidden" name="parent_id" value="<?php echo safe_html($comment['id']); ?>">
                    <textarea name="comment" placeholder="Viết phản hồi của bạn..." required></textarea>
                    <button type="submit">Gửi phản hồi</button>
                </form>

                <?php if (isset($replies[$comment['id']])): ?>
                    <?php foreach ($replies[$comment['id']] as $rep): ?>
                        <div class="reply-block" id="comment-<?php echo $rep['id']; ?>">
                            <div class="reply-author">
                                <?php echo safe_html($rep['ten_nguoi_binh_luan'] ?? ''); ?> 
                                <?php if (isset($rep['is_admin']) && $rep['is_admin'] == 1): ?>
                                    <span class="badge bg-secondary">Admin</span>
                                <?php endif; ?>
                                <span class="reply-time"><?php echo date('H:i d/m/Y', strtotime($rep['created_at'])); ?></span>
                            </div>
                            <div class="reply-content" id="comment-content-<?php echo $rep['id']; ?>" style="margin-top: 5px;">
                                <?php echo nl2br(safe_html($rep['comment'] ?? '')); ?>
                            </div>
                            <div class="comment-actions">
                                <?php if ($logged_in_user_id && $rep['user_id'] == $logged_in_user_id): ?>
                                    <div class="edit-delete-buttons">
                                        <button class="edit-btn" data-comment-id="<?php echo $rep['id']; ?>">Sửa</button>
                                        <button class="delete-btn" data-comment-id="<?php echo $rep['id']; ?>">Xóa</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (empty($comments) && $post): ?>
        <p style="text-align: left; color: #888;">Chưa có bình luận nào được hiển thị cho bài viết này.</p>
    <?php elseif (empty($comments) && !$post): ?>
        <p style="text-align: left; color: #888;">Bài viết không tồn tại. Không thể hiển thị bình luận.</p>
    <?php endif; ?>
</div>
</div>

    <script>
        // Helper function for nl2br in JavaScript
        function nl2br(str) {
            if (typeof str !== 'string' || str === null) return '';
            return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
        }
        // Helper function for htmlspecialchars in JavaScript
        function htmlspecialchars(str) {
            if (typeof str !== 'string' || str === null) return '';
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return str.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // 1. Hiện/ẩn form phản hồi khi bấm nút "Phản hồi"
        document.querySelectorAll('.reply-btn').forEach(btn => {
            btn.onclick = function() {
                const block = this.closest('.comment-block');
                const form = block.querySelector('.reply-form');
                
                if (form.style.display === 'block') {
                    form.style.display = 'none';
                } else {
                    document.querySelectorAll('.reply-form').forEach(otherForm => {
                        if (otherForm !== form) {
                            otherForm.style.display = 'none';
                        }
                    });
                    form.style.display = 'block';
                }
            };
        });

        // 2. Xử lý Sửa bình luận bằng AJAX
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.dataset.commentId;
                const currentCommentDiv = document.getElementById(`comment-content-${commentId}`);
                const currentCommentText = currentCommentDiv.innerHTML.replace(/<br\s*\/?>/gi, '\n').trim(); 

                const textarea = document.createElement('textarea');
                textarea.value = currentCommentText;
                textarea.style.cssText = 'width: 100%; min-height: 80px; margin-bottom: 10px; padding: 10px; border: 1px solid #c7b299; border-radius: 8px; font-size: 1.05rem; resize: vertical; box-sizing: border-box;';

                const saveBtn = document.createElement('button');
                saveBtn.textContent = 'Lưu';
                saveBtn.type = 'button'; 
                saveBtn.style.cssText = 'background: #7b4f24; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; margin-right: 10px;';

                const cancelBtn = document.createElement('button');
                cancelBtn.textContent = 'Hủy';
                cancelBtn.type = 'button'; 
                cancelBtn.style.cssText = 'background: #ccc; color: #333; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;';

                currentCommentDiv.innerHTML = '';
                currentCommentDiv.appendChild(textarea);
                currentCommentDiv.appendChild(saveBtn);
                currentCommentDiv.appendChild(cancelBtn);

                cancelBtn.onclick = function() {
                    currentCommentDiv.innerHTML = nl2br(htmlspecialchars(currentCommentText)); 
                };

                saveBtn.onclick = function() {
                    const newCommentText = textarea.value.trim();
                    if (newCommentText === '') {
                        alert('Nội dung bình luận không được để trống.');
                        return;
                    }

                    // ĐƯỜNG DẪN AJAX CẦN ĐƯỢC ĐỊNH NGHĨA CHÍNH XÁC TỪ GỐC WEBSITE
                    fetch('../../Backend/api/edit_comment.php', { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            comment_id: commentId,
                            new_content: newCommentText,
                            user_id: <?php echo json_encode($logged_in_user_id); ?>
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            currentCommentDiv.innerHTML = nl2br(htmlspecialchars(newCommentText));
                        } else {
                            alert(data.message || "Đã xảy ra lỗi khi sửa bình luận.");
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi AJAX:', error);
                        alert("Không thể kết nối đến máy chủ để sửa bình luận.");
                    });
                };
            });
        });

        // 3. Xử lý Xóa bình luận bằng AJAX
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.dataset.commentId;
                if (confirm("Bạn có chắc chắn muốn xóa bình luận này?")) {
                    fetch('../../Backend/api/delete_comment.php', { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            comment_id: commentId,
                            user_id: <?php echo json_encode($logged_in_user_id); ?>
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const commentBlock = document.getElementById(`comment-${commentId}`);
                            if (commentBlock) {
                                commentBlock.remove();
                            }
                        } else {
                            alert(data.message || "Đã xảy ra lỗi khi xóa bình luận.");
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi AJAX:', error);
                        alert("Không thể kết nối đến máy chủ để xóa bình luận.");
                    });
                }
            });
        });
   </script>
</body>
</html>