# Create test_connection.php
test_connection = """<?php
require_once 'config.php';

try {
    // Already connected through config.php, just test if connection is alive
    $query = $pdo->query('SELECT 1');
    echo "Connection successful!";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>"""

with open('test_connection.php', 'w') as file:
    file.write(test_connection)

print("تم إنشاء ملف test_connection.php للتحقق من الاتصال بقاعدة البيانات")
print("\
يمكنك تجربة الملف على السيرفر للتأكد من الاتصال")