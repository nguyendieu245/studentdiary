<?php
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

    // ==========================
    // ADMIN: Danh sách comment
    // ==========================
    public function index()
    {
        $comments = $this->comment->all();
        $currentPage = 'comments';
        require_once __DIR__ . '/../views/admin/comments/list.php';
    }

    // ==========================
    // ADMIN: Chi tiết + Reply
    // ==========================
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

    // ==========================
    // ADMIN: bật/tắt trạng thái
    // ==========================
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

    // ==========================
    // ADMIN: xóa comment
    // ==========================
    public function delete($id)
    {
        if ($this->comment->delete($id)) {
            header('Location: index.php?action=comments&success=deleted');
            exit();
        }
        header('Location: index.php?action=comments&error=delete_failed');
        exit();
    }

    // ==========================
    // ADMIN: Reply comment
    // ==========================
    public function reply($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parent_comment = $this->comment->getById($id);
            if ($parent_comment) {

                $reply_content = $_POST['reply_content'];
                $post_id = $parent_comment['post_id'];

                // Admin reply, status = 1 tự duyệt
                $sql = "
                    INSERT INTO comments (post_id, parent_id, name, comment, is_admin, status, created_at)
                    VALUES (?, ?, 'Admin', ?, 1, 1, NOW())
                ";
                $stmt = $this->db->prepare($sql);

                if ($stmt->execute([$post_id, $id, $reply_content])) {
                    header('Location: index.php?action=show_comment&id=' . $id . '&success=replied');
                    exit();
                }
            }
        }
        header('Location: index.php?action=comments&error=reply_failed');
        exit();
    }

    // ==========================
    // Lấy comment frontend
    // ==========================
    public function getCommentsByPost($post_id)
    {
        $comments = $this->comment->allByPost($post_id); // chỉ lấy status = 1

        $tree = [];
        foreach ($comments as $c) {
            if ($c['parent_id'] == 0) {
                $tree[$c['id']] = $c;
                $tree[$c['id']]['replies'] = [];
            }
        }

        foreach ($comments as $c) {
            if ($c['parent_id'] != 0 && isset($tree[$c['parent_id']])) {
                $tree[$c['parent_id']]['replies'][] = $c;
            }
        }

        return $tree;
    }

    // ==========================
    // USER: Gửi bình luận
    // ==========================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        // YÊU CẦU ĐĂNG NHẬP
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=post_detail&id={$_POST['post_id']}&error=login_required");
            exit();
        }

        $user_id = $_SESSION['user']['id'];
        $name = $_SESSION['user']['fullname'];

        $post_id   = $_POST['post_id'];
        $comment   = $_POST['comment'] ?? '';
        $parent_id = $_POST['parent_id'] ?? 0;

        if (!$post_id || trim($comment) === '') {
            header("Location: index.php?action=post_detail&id=$post_id&error=missing_data");
            exit();
        }

        // Status = 1 → bình luận hiển thị ngay
        $sql = "
            INSERT INTO comments (post_id, user_id, parent_id, name, comment, is_admin, status, created_at)
            VALUES (?, ?, ?, ?, ?, 0, 1, NOW())
        ";

        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$post_id, $user_id, $parent_id, $name, $comment])) {
            header("Location: index.php?action=post_detail&id=$post_id&success=comment_added");
            exit();
        }

        header("Location: index.php?action=post_detail&id=$post_id&error=insert_failed");
        exit();
    }
}
?>
