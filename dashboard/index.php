<?php
include '../include/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Food Management Dashboard</title>
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
            background-color: #f5f5f5;
            color: #333;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, #ff5e00, #ff9a00);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            text-align: center;
            padding: 0 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }
        
        .logo h2 {
            font-size: 24px;
            font-weight: 700;
        }
        
        .logo p {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 5px;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0 15px;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .nav-link i {
            width: 25px;
            font-size: 18px;
            margin-right: 12px;
        }
        
        .user-info {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            padding: 0 20px;
        }
        
        .user-info p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title h1 {
            font-size: 24px;
            color: #333;
        }
        
        .page-title p {
            color: #666;
            font-size: 14px;
            margin-top: 3px;
        }
        
        .date-time {
            color: #666;
            font-size: 14px;
        }
        
        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        
        .card-icon.orders {
            background: rgba(255, 94, 0, 0.1);
            color: #ff5e00;
        }
        
        .card-icon.revenue {
            background: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }
        
        .card-icon.customers {
            background: rgba(33, 150, 243, 0.1);
            color: #2196F3;
        }
        
        .card-icon.products {
            background: rgba(156, 39, 176, 0.1);
            color: #9C27B0;
        }
        
        .card h3 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .card p {
            color: #666;
            font-size: 14px;
        }
        
        /* Quick Actions */
        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            color: #ff5e00;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .action-btn {
            background: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: #333;
            display: block;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            background: #ff5e00;
            color: white;
            transform: translateY(-3px);
        }
        
        .action-btn i {
            font-size: 32px;
            margin-bottom: 15px;
            display: block;
        }
        
        .action-btn span {
            font-weight: 500;
            font-size: 16px;
        }
        
        /* Recent Orders */
        .recent-orders {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .orders-table th {
            text-align: left;
            padding: 15px 10px;
            border-bottom: 2px solid #f0f0f0;
            color: #666;
            font-weight: 500;
        }
        
        .orders-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status.completed {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .status.pending {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .status.preparing {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
            margin-top: 20px;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
            
            .main-content {
                margin-left: 220px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 20px 0;
            }
            
            .logo h2, .logo p, .nav-link span, .user-info p {
                display: none;
            }
            
            .logo {
                padding: 0 0 30px;
            }
            
            .nav-link {
                justify-content: center;
                padding: 15px;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 20px;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 480px) {
            .main-content {
                padding: 15px;
            }
            
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .stats-cards, .quick-actions {
                grid-template-columns: 1fr;
            }
            
            .orders-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2><i class="fas fa-hamburger"></i> Burger Hub</h2>
            <p>Management System</p>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-utensils"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-box"></i>
                    <span>Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../user/list_user.php" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Staff</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
        
        <div class="user-info">
            <p><i class="fas fa-user-circle"></i> Admin User</p>
            <p>Burger Hub - Main Branch</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="page-title">
                <h1>Dashboard Overview</h1>
                <p>Welcome back! <?php echo $_SESSION['username']; ?></p>
            </div>
            <div class="date-time">
                <i class="far fa-calendar"></i> May 15, 2023
                <i class="far fa-clock" style="margin-left: 15px;"></i> 2:45 PM
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>142</h3>
                        <p>Today's Orders</p>
                    </div>
                    <div class="card-icon orders">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <p><span style="color: #4CAF50;">+12%</span> from yesterday</p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>$2,845</h3>
                        <p>Today's Revenue</p>
                    </div>
                    <div class="card-icon revenue">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <p><span style="color: #4CAF50;">+8%</span> from yesterday</p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>89</h3>
                        <p>Active Customers</p>
                    </div>
                    <div class="card-icon customers">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <p><span style="color: #ff5e00;">3</span> waiting for orders</p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>24</h3>
                        <p>Low Stock Items</p>
                    </div>
                    <div class="card-icon products">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <p>Needs attention</p>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <h2 class="section-title"><i class="fas fa-bolt"></i> Quick Actions</h2>
        <div class="quick-actions">
            <a href="#" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>New Order</span>
            </a>
            
            <a href="#" class="action-btn">
                <i class="fas fa-user-plus"></i>
                <span>Add Staff</span>
            </a>
            
            <a href="#" class="action-btn">
                <i class="fas fa-box-open"></i>
                <span>Check Inventory</span>
            </a>
            
            <a href="#" class="action-btn">
                <i class="fas fa-chart-line"></i>
                <span>View Reports</span>
            </a>
        </div>
        
        <!-- Recent Orders -->
        <div class="recent-orders">
            <h2 class="section-title"><i class="fas fa-history"></i> Recent Orders</h2>
            
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#ORD-7842</td>
                        <td>John Smith</td>
                        <td>2x Burger, 1x Fries</td>
                        <td>$18.50</td>
                        <td><span class="status completed">Completed</span></td>
                        <td>2:30 PM</td>
                    </tr>
                    <tr>
                        <td>#ORD-7841</td>
                        <td>Emma Johnson</td>
                        <td>1x Pizza, 2x Drinks</td>
                        <td>$22.00</td>
                        <td><span class="status preparing">Preparing</span></td>
                        <td>2:15 PM</td>
                    </tr>
                    <tr>
                        <td>#ORD-7840</td>
                        <td>Michael Brown</td>
                        <td>3x Burgers, 2x Fries</td>
                        <td>$34.75</td>
                        <td><span class="status pending">Pending</span></td>
                        <td>2:05 PM</td>
                    </tr>
                    <tr>
                        <td>#ORD-7839</td>
                        <td>Sarah Davis</td>
                        <td>1x Chicken Meal</td>
                        <td>$12.99</td>
                        <td><span class="status completed">Completed</span></td>
                        <td>1:45 PM</td>
                    </tr>
                    <tr>
                        <td>#ORD-7838</td>
                        <td>Robert Wilson</td>
                        <td>2x Pizzas, 1x Salad</td>
                        <td>$28.50</td>
                        <td><span class="status preparing">Preparing</span></td>
                        <td>1:30 PM</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Burger Hub Management System © 2023 | Main Branch: Downtown Plaza</p>
            <p><i class="fas fa-phone"></i> (123) 456-7890 | <i class="fas fa-envelope"></i> support@burgerhub.com</p>
        </div>
    </div>
</body>
</html>