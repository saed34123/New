<?php
require_once 'config.php';  // يحتوي على اتصال PDO و session_start()

$logged_in = isset($_SESSION['user_id']);
$username = $logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fasolinemarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .hero {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            min-height: 100vh;
            color: white;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            padding: 150px 0;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.8) !important;
            backdrop-filter: blur(10px);
        }

        .package-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .package-card:hover {
            transform: translateY(-10px);
        }

        .package-header {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }

        .btn-custom {
            background: linear-gradient(45deg, var(--secondary-color), var(--accent-color));
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .features-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .feature-card {
            padding: 30px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: 100%;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .user-welcome {
            color: #fff;
            margin-right: 15px;
            font-weight: 500;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">fasolinemarket</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#packages">Packages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    
                    <?php if (!$logged_in): ?>
                        <li class="nav-item">
                            <a class="nav-link btn-custom ms-2" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-custom ms-2" href="register.php">Register</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <span class="user-welcome">Welcome, <?php echo htmlspecialchars($username); ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-custom ms-2" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-custom ms-2" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-3 mb-4 animate__animated animate__fadeIn">Invest in Your Future</h1>
                <p class="lead mb-4 animate__animated animate__fadeIn">Choose from our premium investment packages and start growing your wealth today</p>
                <a href="#packages" class="btn btn-custom btn-lg animate__animated animate__fadeIn">Explore Packages</a>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Investment Packages</h2>
            <div class="row g-4">
                <!-- Starter Package -->
                <div class="col-md-4">
                    <div class="package-card">
                        <div class="package-header text-center">
                            <h3>Starter Package</h3>
                            <h4>$100</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>30% Monthly Return</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>3 Month Lock Period</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>24/7 Support</li>
                            </ul>
                            <div class="text-center">
                                <a href="register.php" class="btn btn-custom">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premium Package -->
                <div class="col-md-4">
                    <div class="package-card">
                        <div class="package-header text-center">
                            <h3>Premium</h3>
                            <h4>$500</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>40% Monthly Return</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>6 Month Lock Period</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>Priority Support</li>
                            </ul>
                            <div class="text-center">
                                <a href="register.php" class="btn btn-custom">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Elite Package -->
                <div class="col-md-4">
                    <div class="package-card">
                        <div class="package-header text-center">
                            <h3>Elite</h3>
                            <h4>$1,000</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>50% Monthly Return</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>12 Month Lock Period</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>VIP Support</li>
                            </ul>
                            <div class="text-center">
                                <a href="register.php" class="btn btn-custom">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <h2 class="text-center mb-5">Why Choose Us</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h4>Secure Investment</h4>
                        <p>Your investments are protected with state-of-the-art security measures</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4>High Returns</h4>
                        <p>Competitive returns on your investments with transparent terms</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-headset feature-icon"></i>
                        <h4>24/7 Support</h4>
                        <p>Professional support team available round the clock</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Contact Us</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="contact-form">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom"> Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>About Us</h3>
                    <p>We provide exclusive investment packages to help you grow your wealth with confidence.</p>
                </div>
                <div class="col-md-4">
                    <h3>Quick Links</h3>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-white">Home</a></li>
                        <li><a href="#packages" class="text-white">Packages</a></li>
                        <li><a href="#features" class="text-white">Features</a></li>
                        <li><a href="#contact" class="text-white">Contact</a></li>
                    </ul>
                    <?php if ($logged_in): ?>
                        <ul class="list-unstyled">
                            <li class="nav-item">
                                <a class="nav-link btn-custom ms-2 text-white" href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-custom ms-2 text-white" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <ul class="list-unstyled">
                            <li class="nav-item">
                                <a class="nav-link btn-custom ms-2 text-white" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-custom ms-2 text-white" href="register.php">Register</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-envelope me-2"></i>support@fasolinemarket.com</p>
                    <p><i class="fas fa-phone me-2"></i>+15174485590</p>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>&copy; 2025 fasolinemarket. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
