<?php
/**
 * CancelAppointmentController.php
 * Ce fichier est inclus par l'index.php, donc $pdo et la session sont déjà là.
 */

// 1. On vérifie si l'ID est présent et si l'utilisateur est connecté
if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // 2. Sécurité : Un patient ne supprime que SES RDV, un admin supprime TOUT
    if ($user_role === 'admin') {
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $params = [$id];
    } else {
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
        $params = [$id, $user_id];
    }
    
    if ($stmt->execute($params)) {
        // 3. Redirection via les routes de l'index
        $page_retour = ($user_role === 'admin') ? 'dashboard' : 'mes-rdv';
        header("Location: index.php?page=$page_retour&success=1");
        exit();
    } else {
        echo "Erreur lors de l'annulation.";
    }
} else {
    // Si on arrive ici sans ID ou sans session, retour accueil
    header('Location: index.php');
    exit();
}