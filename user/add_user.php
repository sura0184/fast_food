<?php
include '../include/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $role = htmlspecialchars(trim($_POST['role']));

    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, hashed_pass , role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
    } catch (PDOException $e) {
        die('Error adding user: ' . $e->getMessage());
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Fast Food System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }
        
        .header {
            background: linear-gradient(to right, #ff5e00, #ff9a00);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 15px;
        }
        
        .form-label i {
            color: #ff5e00;
            margin-right: 8px;
            width: 20px;
        }
        
        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #ff5e00;
            box-shadow: 0 0 0 3px rgba(255, 94, 0, 0.1);
            background-color: white;
        }
        
        .role-options {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        .role-option {
            flex: 1;
            text-align: center;
        }
        
        .role-input {
            display: none;
        }
        
        .role-label {
            display: block;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
            font-weight: 500;
        }
        
        .role-label i {
            display: block;
            font-size: 24px;
            margin-bottom: 8px;
            color: #666;
        }
        
        .role-input:checked + .role-label {
            border-color: #ff5e00;
            background-color: rgba(255, 94, 0, 0.05);
            color: #ff5e00;
        }
        
        .role-input:checked + .role-label i {
            color: #ff5e00;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            flex: 1;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-submit {
            background: linear-gradient(to right, #ff5e00, #ff9a00);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 94, 0, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 94, 0, 0.4);
        }
        
        .btn-reset {
            background: #f0f0f0;
            color: #666;
        }
        
        .btn-reset:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }
        
        .message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            transform: translateX(150%);
            transition: transform 0.5s ease;
            z-index: 100;
            border-left: 4px solid #ff5e00;
        }
        
        .message.show {
            transform: translateX(0);
        }
        
        .message i {
            color: #ff5e00;
            margin-right: 10px;
            font-size: 20px;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 18px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 0.3s ease-in-out;
        }
        
        /* Responsive */
        @media (max-width: 500px) {
            .container {
                max-width: 100%;
            }
            
            .form-container {
                padding: 25px;
            }
            
            .role-options {
                flex-direction: column;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-plus"></i> Add New User</h1>
            <p>Create a new user account for the system</p>
        </div>
        <a href="../auth/login.php">logout</a>
        <div class="form-container">
            <form id="userForm" method="POST" >
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" class="form-input" id="username" placeholder="Enter username" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" class="form-input" id="password" placeholder="Enter password" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user-tag"></i> User Role</label>
                    <div class="role-options">
                        <div class="role-option">
                            <input type="radio" name="role" id="manager" value="manager" class="role-input" checked>
                            <label for="manager" class="role-label">
                                <i class="fas fa-user-tie"></i>
                                Manager
                            </label>
                        </div>
                        
                        <div class="role-option">
                            <input type="radio" name="role" id="cashier" value="cashier" class="role-input">
                            <label for="cashier" class="role-label">
                                <i class="fas fa-cash-register"></i>
                                Cashier
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="reset" class="btn btn-reset">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-user-plus"></i> Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="message" id="message">
        <i class="fas fa-check-circle"></i>
        <span id="messageText">User added successfully!</span>
    </div>
    
    
</body>
</html>