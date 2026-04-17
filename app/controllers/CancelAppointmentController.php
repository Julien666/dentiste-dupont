<?php
session_start();
require_once '../../config/db.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // On vérifie que le RDV appartient bien à l'utilisateur connecté (Sécurité !)
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    
    if ($stmt->execute([$id, $user_id])) {
        header('Location: ../views/front/mes-rdv.php?success=cancel=1');
    } else {
        echo "Erreur lors de l'annulation.";
    }
}