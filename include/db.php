<?php
session_start();
$host = 'localhost';
$db   = 'fast_food';
$user = 'root';
$pass = '';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $conn = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>