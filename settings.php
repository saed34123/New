<?php
class Settings {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function get($key) {
        $stmt = $this->pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['setting_value'] : null;
    }
    
    public function set($key, $value, $description = null) {
        try {
            $this->pdo->beginTransaction();
            
            $stmt = $this->pdo->prepare("
                INSERT INTO settings (setting_key, setting_value, description)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    setting_value = VALUES(setting_value),
                    description = COALESCE(VALUES(description), description)
            ");
            
            $result = $stmt->execute([$key, $value, $description]);
            $this->pdo->commit();
            return $result;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM settings");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>