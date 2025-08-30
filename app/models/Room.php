<?php

namespace App\Models;

class Room extends Model {
    protected $table = 'rooms';
    protected $fillable = [
        'name',
        'price',
        'num_persons',
        'num_beds',
        'size',
        'resort_accom_id',
        'image',
        'status'
    ];

    public function getAvailableRooms($checkIn, $checkOut) {
        $sql = "SELECT r.* FROM rooms r 
                WHERE r.status = 1 
                AND r.id NOT IN (
                    SELECT b.room_id 
                    FROM bookings b 
                    WHERE (b.check_in <= :check_out AND b.check_out >= :check_in)
                    AND b.status != 'cancelled'
                )";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'check_in' => $checkIn,
            'check_out' => $checkOut
        ]);
        
        return $stmt->fetchAll();
    }

    public function getWithUtilities($roomId) {
        $sql = "SELECT r.*, GROUP_CONCAT(u.name) as utilities 
                FROM rooms r 
                LEFT JOIN utilities u ON r.id = u.room_id 
                WHERE r.id = :id 
                GROUP BY r.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $roomId]);
        return $stmt->fetch();
    }
}
