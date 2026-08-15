<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = require __DIR__ . '/../config/database.php';

        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['db_name'] . ";charset=" . $config['charset'];
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    // Clone လုပ်ခြင်းကို တားဆီးရန်
    private function __clone() {}

    // Singleton Instance ကို ယူရန် Method
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // PDO Object အား ပြန်ထုတ်ပေးရန် Method
    public function getConnection() {
        return $this->pdo;
    }
}
