<?php
class Comment
{
    private $conn;
    private $table = "comments";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ===============================
    // Lấy tất cả bình luận cho admin
    // ===============================
    public function all()
    {
        $sql = "
            SELECT 
                c.id,
                c.post_id,
                c.user_id,
                c.parent_id,
                c.name,
                c.comment,
                c.is_admin,
                c.status,
                c.created_at,
                p.title AS post_title,
                u.fullname AS user_name,
                CASE 
                    WHEN c.is_admin = 1 THEN 'Admin'
                    WHEN c.user_id IS NOT NULL THEN u.fullname
                    ELSE c.name
                END AS commenter_name
            FROM {$this->table} c
            LEFT JOIN posts p ON c.post_id = p.id
            LEFT JOIN users u ON c.user_id = u.id
            ORDER BY c.created_at DESC
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===============================
    // Lấy comment theo post (status = 1)
    // ===============================
    public function allByPost($post_id)
    {
        $sql = "
            SELECT 
                c.id,
                c.post_id,
                c.user_id,
                c.parent_id,
                c.name,
                c.comment,
                c.is_admin,
                c.status,
                c.created_at,
                u.fullname AS user_name
            FROM {$this->table} c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.post_id = ? AND c.status = 1
            ORDER BY c.created_at ASC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===============================
    // Tạo bình luận mới 
    // ===============================
    public function create($post_id, $user_id, $name, $comment, $parent_id = 0, $is_admin = 0, $status = 1)
    {
        $sql = "
            INSERT INTO {$this->table} 
            (post_id, user_id, parent_id, name, comment, is_admin, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $post_id,
            $user_id,
            $parent_id,
            $name,
            $comment,
            $is_admin,
            $status
        ]);
    }

    // ===============================
    // Cập nhật trạng thái comment
    // ===============================
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // ===============================
    // Xóa comment
    // ===============================
    public function delete($id)
    {
        // Xóa tất cả reply 
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE parent_id = ?");
        $stmt->execute([$id]);

        // Xóa comment cha
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ===============================
    // Lấy chi tiết comment
    // ===============================
    public function getById($id)
    {
        $sql = "
            SELECT 
                c.id,
                c.post_id,
                c.user_id,
                c.parent_id,
                c.name,
                c.comment,
                c.is_admin,
                c.status,
                c.created_at,
                p.title AS post_title,
                u.fullname AS user_name
            FROM {$this->table} c
            LEFT JOIN posts p ON c.post_id = p.id
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
