<?php
include '../include/db.php';


    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List - Fast Food System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(to right, #ff5e00, #ff9a00);
            color: white;
            padding: 20px 30px;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .header h1 i {
            margin-right: 12px;
            font-size: 26px;
        }
        
        .table-container {
            padding: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background-color: #f8f9fa;
        }
        
        th {
            padding: 16px 15px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #eee;
        }
        
        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
        }
        
        tr:hover {
            background-color: #fff9f2;
        }
        
        .role-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
        }
        
        .manager {
            background-color: rgba(255, 94, 0, 0.12);
            color: #ff5e00;
        }
        
        .cashier {
            background-color: rgba(33, 150, 243, 0.12);
            color: #2196F3;
        }
        
        .admin {
            background-color: rgba(76, 175, 80, 0.12);
            color: #4CAF50;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s ease;
        }
        
        .edit-btn {
            background-color: #e3f2fd;
            color: #2196F3;
        }
        
        .edit-btn:hover {
            background-color: #2196F3;
            color: white;
        }
        
        .delete-btn {
            background-color: #ffebee;
            color: #f44336;
        }
        
        .delete-btn:hover {
            background-color: #f44336;
            color: white;
        }
        
        .add-user {
            margin-top: 25px;
            text-align: right;
        }
        
        .add-btn {
            background: linear-gradient(to right, #ff5e00, #ff9a00);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 94, 0, 0.3);
        }
        
        .add-btn i {
            margin-right: 8px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            .container {
                max-width: 100%;
            }
            
            .table-container {
                padding: 15px;
                overflow-x: auto;
            }
            
            table {
                min-width: 600px;
            }
            
            th, td {
                padding: 14px 12px;
            }
        }
        
        @media (max-width: 480px) {
            .header {
                padding: 18px 20px;
            }
            
            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-users"></i> User List</h1>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user['username'] ?></td>
                        <td><span class="role-badge admin"><?php echo $user['role'] ;?></span></td>
                        <td>
                            <div class="actions">
                                <button class="btn edit-btn" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn delete-btn" title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    
                </tbody>
            </table>
            
            <div class="add-user">
                <a href="add_user.php" class="add-btn">
                     Add New User
                </a>
            </div>
        </div>
    </div>
</body>
</html>