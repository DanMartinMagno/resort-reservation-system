<?php

namespace App\Controllers;

use App\Models\Room;

class RoomController extends Controller {
    private $room;

    public function __construct() {
        parent::__construct();
        $this->room = new Room();
    }

    public function index() {
        try {
            $rooms = $this->room->all();
            return $this->view('rooms/index', ['rooms' => $rooms]);
        } catch (\Exception $e) {
            error_log("Error in RoomController::index: " . $e->getMessage());
            return $this->view('error', ['message' => 'Unable to fetch rooms']);
        }
    }

    public function show($id) {
        try {
            $room = $this->room->getWithUtilities($id);
            if (!$room) {
                return $this->view('error', ['message' => 'Room not found']);
            }
            return $this->view('rooms/show', ['room' => $room]);
        } catch (\Exception $e) {
            error_log("Error in RoomController::show: " . $e->getMessage());
            return $this->view('error', ['message' => 'Unable to fetch room details']);
        }
    }

    public function create() {
        // Check CSRF token
        if (!$this->security->verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            return $this->json(['error' => 'Invalid token']);
        }

        // Validate input
        $rules = [
            'name' => ['required' => true],
            'price' => ['required' => true],
            'num_persons' => ['required' => true, 'range' => [1, 10]],
            'num_beds' => ['required' => true, 'range' => [1, 5]],
            'size' => ['required' => true]
        ];

        if (!$this->validateRequest($rules)) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        try {
            // Sanitize input
            $input = $this->security->sanitizeInput($_POST);
            
            // Handle file upload if present
            if (isset($_FILES['image'])) {
                $input['image'] = $this->handleImageUpload($_FILES['image']);
            }

            $this->room->create($input);
            return $this->redirect('/admin/rooms');
        } catch (\Exception $e) {
            error_log("Error in RoomController::create: " . $e->getMessage());
            return $this->json(['error' => 'Unable to create room']);
        }
    }

    private function handleImageUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            throw new \Exception('Invalid file type');
        }
        
        if ($file['size'] > $maxSize) {
            throw new \Exception('File too large');
        }
        
        $filename = uniqid() . '_' . basename($file['name']);
        $uploadPath = __DIR__ . '/../../public/uploads/rooms/' . $filename;
        
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new \Exception('Failed to upload file');
        }
        
        return $filename;
    }
}
