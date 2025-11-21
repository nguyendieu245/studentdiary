<?php
// controllers/CommentController.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Comment.php';

class CommentController
{
    private $db;
    private $comment;

    public function __construct($db)
    {
        $this->db = $db;
        $this->comment = new Comment($db);
    }

    // Hiển thị danh sách bình luận
    public function index()
    {
        $comments = $this->comment->all();
        $currentPage = 'comments';
        require_once __DIR__ . '/../views/admin/comments/list.php';
    }

    // Xem chi tiết và phản hồi bình luận
    public function show($id)
    {
        $comment = $this->comment->getById($id);
        if ($comment) {
            $currentPage = 'comments';
            require_once __DIR__ . '/../views/admin/comments/reply.php';
        } else {
            header('Location: index.php?action=comments&error=notfound');
            exit();
        }
    }

    // Ẩn/Hiện bình luận
    public function toggleStatus($id)
    {
        $comment = $this->comment->getById($id);
        if ($comment) {
            $new_status = $comment['status'] == 1 ? 0 : 1;
            if ($this->comment->updateStatus($id, $new_status)) {
                header('Location: index.php?action=comments&success=status_updated');
                exit();
            }
        }
        header('Location: index.php?action=comments&error=update_failed');
        exit();
    }

    // Xóa bình luận
    public function delete($id)
    {
        if ($this->comment->delete($id)) {
            header('Location: index.php?action=comments&success=deleted');
            exit();
        }
        header('Location: index.php?action=comments&error=delete_failed');
        exit();
    }

    // Phản hồi bình luận (Admin)
    public function reply($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parent_comment = $this->comment->getById($id);
            if ($parent_comment) {
                $reply_content = htmlspecialchars($_POST['reply_content']);
                $post_id = $parent_comment['post_id'];
                
                // Tạo reply với is_admin = 1
                $stmt = $this->db->prepare("
                    INSERT INTO comments (post_id, parent_id, name, comment, is_admin, created_at, status)
                    VALUES (?, ?, 'Student Diary', ?, 1, NOW(), 1)
                ");
                
                if ($stmt->execute([$post_id, $id, $reply_content])) {
                    header('Location: index.php?action=show_comment&id=' . $id . '&success=replied');
                    exit();
                }
            }
        }
        header('Location: index.php?action=comments&error=reply_failed');
        exit();
    }
}
?>