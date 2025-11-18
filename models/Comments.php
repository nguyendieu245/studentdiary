<?php
class Comment
{
    private $conn;
    private $table = "comments";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function allByPost($post_id)
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, u.fullname AS user_name
            FROM {$this->table} c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.post_id = ? AND c.status = 1
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($post_id, $user_id, $name, $email, $comment)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (post_id, user_id, name, email, comment)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$post_id, $user_id, $name, $email, $comment]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
