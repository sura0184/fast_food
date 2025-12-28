<?php
include '../include/db.php';
$error = "";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password , $user['hashed_pass'])){
        $_SESSION['user_id'] = $user['user_ID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location:../dashboard/index.php');
    }else{
        $error = "Invalid username or password.";
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Food Management System | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fredoka+One&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #ff9a00 0%, #ff2d00 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            padding: 20px;
        }
        
        .container {
            display: flex;
            width: 100%;
            max-width: 1100px;
            height: 650px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: relative;
        }
        
        /* Left side with animations */
        .left-side {
            flex: 1;
            background: linear-gradient(to bottom right, #ff5e00, #ff9a00);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            animation: fadeIn 1s ease-out;
        }
        
        .logo-icon {
            font-size: 42px;
            color: #fff;
            margin-right: 15px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .logo-text {
            color: white;
            font-size: 32px;
            font-weight: 700;
            font-family: 'Fredoka One', cursive;
            letter-spacing: 1px;
        }
        
        .tagline {
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            margin-bottom: 40px;
            line-height: 1.5;
            animation: fadeIn 1.2s ease-out;
        }
        
        /* Food animations */
        .food-animations {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        
        .food-item {
            position: absolute;
            font-size: 30px;
            opacity: 0.7;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }
        
        .burger {
            top: 20%;
            left: 15%;
            animation: float 8s infinite ease-in-out;
            color: #8B4513;
        }
        
        .fries {
            top: 60%;
            left: 80%;
            animation: float 7s infinite ease-in-out 1s;
            color: #FFD700;
        }
        
        .pizza {
            top: 10%;
            left: 70%;
            animation: float 9s infinite ease-in-out 2s;
            color: #FF6347;
        }
        
        .drink {
            top: 70%;
            left: 10%;
            animation: float 6s infinite ease-in-out 0.5s;
            color: #1E90FF;
        }
        
        /* Right side - login form */
        .right-side {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-header h2 {
            color: #ff5e00;
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .login-header p {
            color: #666;
            font-size: 16px;
        }
        
        .login-form {
            width: 100%;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 30px;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff5e00;
            font-size: 20px;
            z-index: 1;
        }
        
        .input-group input {
            width: 100%;
            padding: 18px 20px 18px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: #ff5e00;
            box-shadow: 0 0 0 3px rgba(255, 94, 0, 0.1);
            background-color: white;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .remember {
            display: flex;
            align-items: center;
        }
        
        .remember input {
            margin-right: 8px;
            accent-color: #ff5e00;
        }
        
        .forgot-password {
            color: #ff5e00;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(to right, #ff5e00, #ff9a00);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 94, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 94, 0, 0.4);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .login-btn i {
            margin-left: 10px;
            transition: transform 0.3s ease;
        }
        
        .login-btn:hover i {
            transform: translateX(5px);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        
        .login-footer a {
            color: #ff5e00;
            text-decoration: none;
            font-weight: 500;
        }
        
        .notification {
            position: fixed;
            top: 30px;
            right: 30px;
            padding: 15px 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            transform: translateX(150%);
            transition: transform 0.5s ease;
            z-index: 1000;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification i {
            color: #ff5e00;
            font-size: 20px;
            margin-right: 10px;
        }
        
        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        /* Responsive Design */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                height: auto;
                max-width: 500px;
            }
            
            .left-side {
                padding: 30px;
            }
            
            .right-side {
                padding: 30px;
            }
            
            .food-item {
                font-size: 24px;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                border-radius: 15px;
            }
            
            .left-side, .right-side {
                padding: 25px;
            }
            
            .logo-text {
                font-size: 26px;
            }
            
            .login-header h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left side with animations -->
        <div class="left-side">
            <div class="logo">
                <i class="fas fa-hamburger logo-icon"></i>
                <div class="logo-text">BURGER HUB</div>
            </div>
            
            <p class="tagline">Manage your fast food restaurant efficiently with our all-in-one management system. Track inventory, manage orders, and analyze sales in real-time.</p>
            
            <div class="food-animations">
                <div class="food-item burger"><i class="fas fa-hamburger"></i></div>
                <div class="food-item fries"><i class="fas fa-french-fries"></i></div>
                <div class="food-item pizza"><i class="fas fa-pizza-slice"></i></div>
                <div class="food-item drink"><i class="fas fa-glass-whiskey"></i></div>
            </div>
        </div>
        
        <!-- Right side with login form -->
        <div class="right-side">
            <div class="login-header">
                <h2>Welcome Back!</h2>
                <p>Sign in to access your dashboard</p>
            </div>

            <?php if($error): ?>
            <div class="error"><?= $error ?> </div>
            <?php endif; ?>
            
            <form class="login-form" id="loginForm" action="#" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Username or Email" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                
                <div class="remember-forgot">
                    <div class="remember">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                
                <button type="submit" class="login-btn">Login <i class="fas fa-sign-in-alt"></i></button>
                
                <div class="login-footer">
                    <p>Don't have an account? <a href="#" id="registerLink">Contact Admin</a></p>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Notification -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationText">Login successful! Redirecting...</span>
    </div>
    
   
</body>
</html>