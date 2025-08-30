<?php

namespace App\Models;

class Booking extends Model {
    protected $table = 'bookings';
    protected $fillable = [
        'check_in',
        'check_out',
        'email',
        'phone_number',
        'full_name',
        'resort_accom_name',
        'room_name',
        'status',
        'payment',
        'user_id'
    ];

    public function getUserBookings($userId) {
        return $this->where(['user_id' => $userId]);
    }

    public function getPendingBookings() {
        return $this->where(['status' => 'pending']);
    }

    public function confirmBooking($bookingId) {
        return $this->update($bookingId, ['status' => 'confirmed']);
    }

    public function cancelBooking($bookingId) {
        return $this->update($bookingId, ['status' => 'cancelled']);
    }

    public function getBookingDetails($bookingId) {
        $sql = "SELECT b.*, r.name as room_name, r.price, u.username 
                FROM bookings b 
                JOIN rooms r ON b.room_id = r.id 
                JOIN users u ON b.user_id = u.id 
                WHERE b.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $bookingId]);
        return $stmt->fetch();
    }
}
