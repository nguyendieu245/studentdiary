<?php
// models/Comment.php
class Comment
{
    private $conn;
    private $table = "comments";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả comments với thông tin bài viết, user và parent comment
    public function getAllWithDetails()
    {
        $stmt = $this->conn->prepare("
            SELECT 
                c.id,
                c.post_id,
                c.user_id,
                c.parent_id,
                c.name,
                c.email,
                c.comment,
                c.status,
                c.is_admin,
                c.created_at,
                c.updated_at,
                p.title AS post_title,
                p.category_id,
                CASE 
                    WHEN c.is_admin = 1 THEN 'Student Diary (Admin)'
                    WHEN c.user_id IS NOT NULL THEN u.fullname
                    ELSE c.name
                END AS commenter_name,
                CASE 
                    WHEN c.parent_id > 0 THEN 'Phản hồi của Admin'
                    ELSE 'Bình luận gốc'
                END AS comment_type,
                parent.name AS parent_commenter_name,
                parent.comment AS parent_comment
            FROM {$this->table} c
            LEFT JOIN posts p ON c.post_id = p.id
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN {$this->table} parent ON c.parent_id = parent.id
            ORDER BY c.post_id DESC, c.parent_id ASC, c.created_at ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy comments theo bài viết (bao gồm cả reply)
    public function allByPost($post_id)
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, 
                   CASE 
                       WHEN c.is_admin = 1 THEN 'Admin'
                       WHEN c.user_id IS NOT NULL THEN u.fullname
                       ELSE c.name
                   END AS user_name
            FROM {$this->table} c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.post_id = ? AND c.status = 1
            ORDER BY c.parent_id ASC, c.created_at ASC
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy comment theo ID
    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, p.title AS post_title
            FROM {$this->table} c
            LEFT JOIN posts p ON c.post_id = p.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo comment mới
    public function create($post_id, $user_id, $name, $email, $comment, $parent_id = 0, $is_admin = 0)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} 
            (post_id, user_id, parent_id, name, email, comment, status, is_admin, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, 1, ?, NOW(), NOW())
        ");
        return $stmt->execute([$post_id, $user_id, $parent_id, $name, $email, $comment, $is_admin]);
    }

    // Cập nhật trạng thái comment
    public function updateStatus($id, $status)
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table} 
            SET status = ?, updated_at = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$status, $id]);
    }

    // Ẩn comment
    public function hide($id)
    {
        return $this->updateStatus($id, 0);
    }

    // Hiện comment
    public function show($id)
    {
        return $this->updateStatus($id, 1);
    }

    // Xóa comment và các reply của nó
    public function delete($id)
    {
        // Xóa các reply trước
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE parent_id = ?");
        $stmt->execute([$id]);
        
        // Xóa comment chính
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Đếm tổng số comments
    public function count()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Kiểm tra comment đã có reply chưa
    public function hasReply($comment_id)
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM {$this->table} 
            WHERE parent_id = ?
        ");
        $stmt->execute([$comment_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }
}