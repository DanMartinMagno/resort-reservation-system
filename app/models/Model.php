<?php

namespace App\Models;

use App\Helpers\Database;

abstract class Model {
    protected $db;
    protected $table;
    protected $fillable = [];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function create($data) {
        $filtered = array_intersect_key($data, array_flip($this->fillable));
        $columns = implode(', ', array_keys($filtered));
        $values = implode(', ', array_map(function($item) { return ":$item"; }, array_keys($filtered)));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($filtered);
    }

    public function update($id, $data) {
        $filtered = array_intersect_key($data, array_flip($this->fillable));
        $set = implode(', ', array_map(function($item) { return "$item = :$item"; }, array_keys($filtered)));
        
        $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        $filtered['id'] = $id;
        return $stmt->execute($filtered);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function where($conditions) {
        $where = implode(' AND ', array_map(function($item) { return "$item = :$item"; }, array_keys($conditions)));
        $sql = "SELECT * FROM {$this->table} WHERE $where";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll();
    }
}
