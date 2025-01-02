<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        
        if (!$email) {
            throw new Exception('Invalid email format');
        }
        
        $stmt = $conn->prepare('SELECT id, username, email, password FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('Invalid credentials');
        }
        
        $user = $result->fetch_assoc();
        
        if (!password_verify($password, $user['password'])) {
            throw new Exception('Invalid credentials');
        }
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        
        header('Location: dashboard.php');
        exit;
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Investment Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            max-width: 400px;
            width: 90%;
            margin: auto;
        }
        .btn-custom {
            background: linear-gradient(45deg, #3498db, #e74c3c);
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .form-control {
            border-radius: 25px;
            padding: 10px 20px;
            border: 1px solid #ddd;
            margin-bottom: 1rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            border-color: #3498db;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
        }
        .logo i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .back-home {
            color: white;
            text-decoration: none;
            position: absolute;
            top: 20px;
            left: 20px;
            transition: all 0.3s ease;
        }
        .back-home:hover {
            color: #fdbb2d;
        }
        .register-link {
            text-align: center;
            margin-top: 1rem;
        }
        .register-link a {
            color: #3498db;
            text-decoration: none;
        }
        .register-link a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-home">
        <i class="fas fa-arrow-left me-2"></i> Back to Home
    </a>
    
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-user-circle"></i>
            <h2>Login</h2>
        </div>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            
            <button type="submit" class="btn btn-custom">Login</button>
            
            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>