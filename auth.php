<?php
require_once 'config.php';
session_start();

class Auth {
    public static function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }
    
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            http_response_code(401);
            echo json_encode(['error' => 'Authentication required']);
            exit;
        }
    }
    
    public static function getCurrentUser() {
        if (!self::isAuthenticated()) {
            return null;
        }
        
        global $conn;
        $stmt = $conn->prepare('SELECT id, username, email, balance FROM users WHERE id = ?');
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    public static function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }
}

// Handle logout request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    header('Content-Type: application/json');
    echo json_encode(Auth::logout());
    exit;
}