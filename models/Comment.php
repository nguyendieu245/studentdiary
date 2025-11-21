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

    // ===============================
    // Lấy tất cả bình luận cho admin
    // ===============================
    public function all()
    {
        $sql = "
            SELECT 
                c.*,
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

    // ======================================
    // Lấy comment theo post (chỉ comment duyệt)
    // ======================================
    public function allByPost($post_id)
    {
        $sql = "
            SELECT 
                c.*, 
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
    public function create($post_id, $user_id, $name, $email, $comment, $parent_id = 0, $is_admin = 0)
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;

        $sql = "
            INSERT INTO {$this->table} 
            (post_id, user_id, parent_id, name, email, ip_address, comment, is_admin, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())
        ";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $post_id,
            $user_id,
            $parent_id,
            $name,
            $email,
            $ip,
            $comment,
            $is_admin
        ]);
    }

    // ===============================
    // Cập nhật trạng thái duyệt
    // ===============================
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} SET status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // ===============================
    // Xóa comment
    // ===============================
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // ===============================
    // Lấy chi tiết comment
    // ===============================
    public function getById($id)
    {
        $sql = "
            SELECT 
                c.*,
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
