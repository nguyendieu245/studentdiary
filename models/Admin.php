<?php
class Admin
{
    private $conn;
    private $table = "admins";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function all()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table} ORDER BY fullname");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $password, $fullname, $role = 'admin')
    {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (username, password, fullname, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $password, $fullname, $role]);
    }

    public function update($id, $fullname, $role)
    {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET fullname=?, role=? WHERE id=?");
        return $stmt->execute([$fullname, $role, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
