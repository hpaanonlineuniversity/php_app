<?php
require_once __DIR__ . '/Database.php';

class Model {
    protected $db;

    public function __construct() {
        // Singleton Instance မှတစ်ဆင့် PDO Connection ကို ရယူခြင်း
        $this->db = Database::getInstance()->getConnection();
    }
}
