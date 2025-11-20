<?php
include __DIR__ . '/../../layouts/header.php'; 
if (!isset($comments)) {
    $comments = [];
}
?>

<div class="main-content-area"> 
    <?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="content-header">
        <h1>Quản lý bình luận</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: rgb(241, 191, 157);">
                            <th>STT</th>
                            <th>Bài viết</th>
                            <th>Người bình luận</th>
                            <th>Nội dung</th>
                            <th>Loại bình luận</th> 
                            <th>Ngày</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stt = 1;
                        if (empty($comments)):
                        ?>
                            <tr>
                                <td colspan="8" style="text-align: center; color: #777;">Không có bình luận nào.</td>
                            </tr>
                        <?php 
                        else:
                            foreach ($comments as $comment): 
                                $is_admin_reply = ($comment['is_admin'] == 1);
                                $comment_type = '';

                                if ($comment['parent_id'] == 0) {
                                    $comment_type = "Bình luận gốc";
                                } else {
                                    if ($is_admin_reply) {
                                        $comment_type = "Phản hồi của Admin";
                                    } else {
                                        $comment_type = "Phản hồi bình luận";
                                    }
                                }
                        ?>
                        <tr <?php echo ($is_admin_reply ? 'class="admin-reply-row"' : ''); ?>>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo htmlspecialchars($comment['title']); ?></td>
                            <td>
                                <?php 
                                echo htmlspecialchars($comment['name']);
                                if ($is_admin_reply) {
                                    echo ' <strong>(Admin)</strong> <i class="fas fa-crown" style="color: gold;"></i>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                // Hiển thị nội dung bình luận phản hồi rõ ràng hơn
                                if ($comment['parent_id'] != 0) { 
                                    echo '<p style="font-style: italic; color: #666; margin-bottom: 5px;">';
                                    echo 'Phản hồi cho <strong>' . htmlspecialchars($comment['parent_comment_name']) . '</strong>: ';
                                    echo '"' . nl2br(htmlspecialchars(mb_substr($comment['parent_comment_content'], 0, 50, 'UTF-8'))) . (mb_strlen($comment['parent_comment_content'], 'UTF-8') > 50 ? '...' : '') . '"';
                                    echo '</p>';
                                }
                                echo nl2br(htmlspecialchars($comment['comment'])); 
                                ?>
                            </td>
                            <td><?php echo $comment_type; ?></td>
                            <td><?php echo date("d/m/Y H:i", strtotime($comment['created_at'])); ?></td>
                            <td>
                                <?php if ($comment['status'] == 1): ?>
                                    <span class="status-badge status-published">Hiển thị</span>
                                <?php else: ?>
                                    <span class="status-badge status-hidden">Ẩn</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                // Nút "Phản hồi" chỉ hiển thị cho bình luận của người dùng (is_admin = 0)
                                if ($comment['is_admin'] == 0): 
                                ?>
                                    <button class="action-btn reply-btn" data-id="<?php echo $comment['id']; ?>" data-post-id="<?php echo $comment['post_id']; ?>">
                                        <i class="fas fa-reply"></i> Phản hồi
                                    </button>
                                <?php endif; ?>

                                <a href="/studentdiary/public/index.php?action=toggle_comment_status&id=<?php echo $comment['id']; ?>" 
                                   class="action-btn edit-btn" title="Ẩn/Hiện">
                                    <?php if ($comment['status'] == 1): ?>
                                        <i class="fas fa-eye-slash"></i>
                                    <?php else: ?>
                                        <i class="fas fa-eye"></i>
                                    <?php endif; ?>
                                </a>
                                <a href="/studentdiary/public/index.php?action=delete_comment&id=<?php echo $comment['id']; ?>" 
                                   class="action-btn delete-btn" title="Xóa" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này VÀ TẤT CẢ PHẢN HỒI của nó?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="replyModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Phản hồi bình luận</h2>
            <form id="replyForm" action="../../process_comment.php" method="post"> 
                <input type="hidden" name="parent_comment_id" id="modalParentCommentId">
                <input type="hidden" name="post_id_for_reply" id="modalPostIdForReply"> 
                <div class="form-group">
                    <label for="reply_content">Nội dung phản hồi:</label>
                    <textarea name="reply_content" id="reply_content" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-submit-reply">Gửi phản hồi</button>
            </form>
        </div>
    </div>

</div>

<style>
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1000; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.4); 
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        width: 80%;
        max-width: 500px;
        position: relative;
    }
    .close-button {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 20px;
    }
    .close-button:hover,
    .close-button:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .modal-content h2 {
        margin-top: 0;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }
    .modal-content label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }
    .modal-content textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box; 
        font-family: inherit;
    }
    .btn-submit-reply {
        background-color: #8d6e63;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }
    .btn-submit-reply:hover {
        background-color: #6d4c41;
    }

    /* Styles for the main content area */
    .main-content-area {
        margin-left: 20px;
        padding-right: 20px;
        margin-top: 20px;
    }

    .content-header h1 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 8px;
    }

    /* Styles for the table and badges */
    .table-responsive {
        overflow-x: auto;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        vertical-align: top;
    }
    .table th {
        background-color: rgb(224, 185, 153); 
        font-weight: bold;
        color: #555;
    }
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9em;
        font-weight: bold;
        color: white;
        text-align: center;
    }
    .status-published {
        background-color: #28a745; /* Green */
    }
    .status-hidden {
        background-color: #dc3545; /* Red */
    }
    .action-btn {
        display: inline-block;
        padding: 8px 12px;
        margin: 2px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        text-decoration: none;
        color: white;
        text-align: center;
    }
    .reply-btn {
        background-color: rgb(134, 111, 235); 
    }
    .reply-btn:hover {
        background-color: #0056b3;
    }
    .edit-btn {
        background-color: #ffc107; /* Yellow */
        color: #333;
    }
    .edit-btn:hover {
        background-color: #e0a800;
    }
    .delete-btn {
        background-color: #dc3545; /* Red */
    }
    .delete-btn:hover {
        background-color: #c82333;
    }

    /* Style for admin reply rows */
    .admin-reply-row {
        background-color: rgb(247, 221, 193); 
        font-style: italic;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const replyModal = document.getElementById('replyModal');
    const closeButton = document.querySelector('.close-button');
    const replyButtons = document.querySelectorAll('.reply-btn');
    const modalParentCommentId = document.getElementById('modalParentCommentId');
    const modalPostIdForReply = document.getElementById('modalPostIdForReply'); 

    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-id');
            const postId = this.getAttribute('data-post-id'); 
            modalParentCommentId.value = commentId;
            modalPostIdForReply.value = postId; 
            replyModal.style.display = 'flex'; 
        });
    });

    closeButton.addEventListener('click', function() {
        replyModal.style.display = 'none';
        document.getElementById('reply_content').value = ''; 
    });

    window.addEventListener('click', function(event) {
        if (event.target == replyModal) {
            replyModal.style.display = 'none';
            document.getElementById('reply_content').value = ''; 
        }
    });
});
</script>