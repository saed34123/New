<?php
// بدء الجلسة إذا لم تكن قد بدأت بالفعل
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {
    // دالة لتسجيل الدخول
    public function login($username, $password) {
        // هنا يمكنك إضافة التحقق من اسم المستخدم وكلمة المرور في قاعدة البيانات
        // هذا مثال بسيط للتوضيح
        $validUsername = 'admin'; // اسم المستخدم الصحيح
        $validPassword = 'password'; // كلمة المرور الصحيحة

        if ($username === $validUsername && $password === $validPassword) {
            $_SESSION['user_id'] = 1; // حفظ معرف المستخدم في الجلسة
            $_SESSION['username'] = $username; // حفظ اسم المستخدم في الجلسة
            return true;
        }
        return false;
    }

    // دالة لتسجيل الخروج
    public function logout() {
        // إزالة جميع بيانات الجلسة
        session_unset();
        session_destroy();
    }

    // دالة للتحقق من حالة تسجيل الدخول
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // دالة للحصول على اسم المستخدم الحالي
    public function getUsername() {
        return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }

    // دالة للحصول على معرف المستخدم الحالي
    public function getUserId() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }
}

// إنشاء كائن من الفئة Auth
$auth = new Auth();
