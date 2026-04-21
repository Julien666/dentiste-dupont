<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') exit();

$id = $_GET['id'] ?? null;
if ($id) {
    // 1. Supprimer ses RDV d'abord (intégrité)
    $pdo->prepare("DELETE FROM appointments WHERE user_id = ?")->execute([$id]);
    // 2. Supprimer le patient
    $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'patient'")->execute([$id]);
}
header('Location: index.php?page=patients&success=deleted');
exit();