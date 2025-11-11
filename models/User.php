<?php
class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function all()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $password, $fullname, $email)
    {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (username, password, fullname, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $password, $fullname, $email]);
    }

    public function update($id, $fullname, $email)
    {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET fullname=?, email=? WHERE id=?");
        return $stmt->execute([$fullname, $email, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
