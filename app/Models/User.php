<?php
require_once __DIR__ . '/../../core/Model.php';

class User extends Model {
    // User အားလုံးကို ဆွဲထုတ်ခြင်း
    public function getAllUsers() {
        //$stmt = $this->db->prepare("SELECT id, name, email FROM users");
        $stmt = $this->db->prepare("SELECT id, name, email, created_at FROM users ORDER BY id DESC");
	$stmt->execute();
        return $stmt->fetchAll();
    }

    // Single User ကို ID ဖြင့် ရှာခြင်း
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id, name, email FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // User သစ် ထည့်သွင်းခြင်း
    public function create($data) {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);

        // Password ကို Secure Hash ပြုလုပ်ခြင်း
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        return $stmt->execute([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $hashedPassword
        ]);
    }

    // User Data ပြန်လည် ပြင်ဆင်ခြင်း
    public function update($id, $data) {
        // Password ပါဝင်ပါက Password ပါ Update လုပ်မည်
        if (!empty($data['password'])) {
            $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $params = [
                'id'       => $id,
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $hashedPassword
            ];
        } else {
            // Password မပါပါက Name နှင့် Email သာ Update လုပ်မည်
            $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
            $params = [
                'id'    => $id,
                'name'  => $data['name'],
                'email' => $data['email']
            ];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // User အား ဖျက်ထုတ်ခြင်း
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
