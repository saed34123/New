<?php
require_once 'config.php';  // This has PDO connection as $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input data
        $first_name = clean_input($_POST['first_name']);
        $last_name = clean_input($_POST['last_name']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $phone = clean_input($_POST['phone']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validate required fields
        if (!$first_name || !$last_name || !$email || !$phone || !$password || !$confirm_password) {
            throw new Exception('All fields are required.');
        }

        // Validate passwords match
        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }
        
        // Validate password strength
        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters long');
        }
        
        // Check if email exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('Email already registered');
        }
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $pdo->prepare('
            INSERT INTO users (first_name, last_name, email, phone, password, created_at) 
            VALUES (:first_name, :last_name, :email, :phone, :password, NOW())
        ');
        
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password_hash);
        
        if ($stmt->execute()) {
            // Retrieve the user's ID
            $user_id = $pdo->lastInsertId();
            
            // Set session variables to log in the user
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $first_name . ' ' . $last_name;
            $_SESSION['email'] = $email;
            
            // Redirect to dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            throw new Exception('Registration failed. Please try again.');
        }
        
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Investment Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            padding: 2rem 0;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            max-width: 500px;
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
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
        .login-link a {
            color: #3498db;
            text-decoration: none;
        }
        .login-link a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-home">
        <i class="fas fa-arrow-left me-2"></i> Back to Home
    </a>
    
    <div class="register-card">
        <div class="logo">
            <i class="fas fa-user-plus"></i>
            <h2>Create Account</h2>
        </div>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo htmlspecialchars($_SESSION['error_message']); 
                    unset($_SESSION['error_message']); 
                ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="register.php">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                </div>
            </div>
            
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            
            <div class="mb-3">
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
            </div>
            
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <div class="form-text">Password must be at least 8 characters long and include numbers and special characters</div>
            </div>
            
            <div class="mb-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>
            
            <button type="submit" class="btn btn-custom">Create Account</button>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
