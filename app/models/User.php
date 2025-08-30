<?php

namespace App\Models;

class User extends Model {
    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'mypassword'
    ];

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function create($data) {
        // Hash password before saving
        if (isset($data['mypassword'])) {
            $data['mypassword'] = password_hash($data['mypassword'], PASSWORD_DEFAULT);
        }
        return parent::create($data);
    }

    public function getBookings($userId) {
        $sql = "SELECT b.*, r.name as room_name, r.price 
                FROM bookings b 
                JOIN rooms r ON b.room_id = r.id 
                WHERE b.user_id = :user_id 
                ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
