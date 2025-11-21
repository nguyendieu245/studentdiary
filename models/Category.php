<?php
// models/Category.php
class Category
{
    private $conn;
    private $table = "categories";

    public $id;
    public $name;
    public $slug;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả danh mục
    public function all()
    {
        $stmt = $this->conn->query("
            SELECT c.*, COUNT(p.id) as post_count
            FROM {$this->table} c
            LEFT JOIN posts p ON c.id = p.category_id
            GROUP BY c.id
            ORDER BY c.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục theo ID 
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo danh mục mới
    public function create()
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (name, slug, created_at)
            VALUES (?, ?, NOW())
        ");
        return $stmt->execute([$this->name, $this->slug]);
    }

    // Cập nhật danh mục
    public function update()
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET name = ?, slug = ?
            WHERE id = ?
        ");
        return $stmt->execute([$this->name, $this->slug, $this->id]);
    }

    // Xóa danh mục
    public function delete()
    {
        // Kiểm tra xem có bài viết nào thuộc danh mục này không
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM posts WHERE category_id = ?");
        $stmt->execute([$this->id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return false; // Không cho xóa nếu còn bài viết
        }

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    // Tạo slug từ tên
    public function createSlug($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        
        // Chuyển đổi ký tự có dấu
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        );
        
        foreach($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        
        $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
        $str = preg_replace('/[\s-]+/', '-', $str);
        $str = trim($str, '-');
        
        return $str;
    }
}
?>