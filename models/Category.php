<?php
class Category
{
    private $conn;
    private $table = "categories";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function all()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table} ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $slug)
    {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name, slug) VALUES (?, ?)");
        return $stmt->execute([$name, $slug]);
    }

    public function update($id, $name, $slug)
    {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET name=?, slug=? WHERE id=?");
        return $stmt->execute([$name, $slug, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
