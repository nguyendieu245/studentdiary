<?php
// models/Post.php

class Post
{
    private $conn;
    private $table = "posts";

    public $id;
    public $title;
    public $content;
    public $author;
    public $author_name;
    public $image;
    public $status;
    public $category_id;
    public $views;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /* ============================================================
        BASE QUERY — HÀM DÙNG CHUNG
    ============================================================ */
    private function baseQuery()
    {
        return "
            SELECT 
                p.*, 
                c.name AS category_name,
                u.username AS author_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id
        ";
    }

    /* ============================================================
        LẤY TẤT CẢ BÀI VIẾT
    ============================================================ */
    public function all()
    {
        $stmt = $this->conn->prepare($this->baseQuery() . " ORDER BY p.created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
        LẤY BÀI VIẾT PUBLIC
    ============================================================ */
    public function getAllPublishedPosts()
    {
        $stmt = $this->conn->prepare(
            $this->baseQuery() . "
            WHERE p.status = 'published'
            ORDER BY p.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
        LẤY BÀI VIẾT THEO CATEGORY_ID
    ============================================================ */
    public function getByCategory($categoryId)
    {
        $stmt = $this->conn->prepare(
            $this->baseQuery() . "
            WHERE p.category_id = ? AND p.status = 'published'
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
        SHORTCUT: CATEGORY CỤ THỂ
    ============================================================ */
    public function getAllSkillPosts()
    {
        return $this->getByCategory(1);
    }

    public function getAllStudyPosts()
    {
        return $this->getByCategory(3);
    }

    public function getAllSocialPosts()
    {
        return $this->getByCategory(2);
    }

    /* ============================================================
        TÌM BÀI VIẾT THEO ID
    ============================================================ */
    public function find($id)
    {
        $stmt = $this->conn->prepare(
            $this->baseQuery() . " WHERE p.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Alias để controller không lỗi
    public function getById($id)
    {
        return $this->find($id);
    }

    /* ============================================================
        TĂNG LƯỢT XEM
    ============================================================ */
    public function incrementViews($id)
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET views = COALESCE(views, 0) + 1
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    /* ============================================================
        DANH MỤC (LỠ EM CÓ DÙNG)
    ============================================================ */
    public function getAllCategories()
    {
        $stmt = $this->conn->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
        UPLOAD ẢNH
    ============================================================ */
    public function uploadImage($file, $id = null)
    {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];

        if (!in_array($file['type'], $allowed_types)) {
            return false;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '_' . time() . '.' . $ext;
        $new_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $new_path)) {
            // Xóa ảnh cũ nếu cập nhật
            if ($id) {
                $old = $this->find($id);
                if ($old && $old['image'] && file_exists($upload_dir . $old['image'])) {
                    unlink($upload_dir . $old['image']);
                }
            }

            $this->image = $new_filename;
            return true;
        }

        return false;
    }

    /* ============================================================
        THÊM BÀI VIẾT
    ============================================================ */
    public function create()
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} 
            (title, content, author, image, status, category_id, views, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 0, NOW())
        ");

        return $stmt->execute([
            $this->title,
            $this->content,
            $this->author,
            $this->image,
            $this->status,
            $this->category_id
        ]);
    }

    /* ============================================================
        CẬP NHẬT BÀI VIẾT
    ============================================================ */
    public function update()
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table} 
            SET title=?, content=?, image=?, status=?, category_id=?, views=? 
            WHERE id=?
        ");

        return $stmt->execute([
            $this->title,
            $this->content,
            $this->image,
            $this->status,
            $this->category_id,
            $this->views,
            $this->id
        ]);
    }

    /* ============================================================
        XÓA BÀI VIẾT
    ============================================================ */
    public function deleteById($id)
    {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
        $post = $this->find($id);

        if ($post && $post['image'] && file_exists($upload_dir . $post['image'])) {
            unlink($upload_dir . $post['image']);
        }

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Alias delete() để controller không lỗi
    public function delete()
    {
        return $this->deleteById($this->id);
    }
}
