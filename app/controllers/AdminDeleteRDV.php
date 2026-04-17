<?php
session_start();
require_once '../../config/db.php';

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header('Location: ../views/back/dashboard.php');
exit();