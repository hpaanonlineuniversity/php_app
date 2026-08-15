<?php
require_once __DIR__ . '/../../core/Model.php';

class User extends Model {
    // User အားလုံးကို ဆွဲထုတ်ခြင်း
    public function getAllUsers() {
        $stmt = $this->db->prepare("SELECT id, name, email FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Single User ကို ID ဖြင့် ရှာခြင်း (Prepared Statement)
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
