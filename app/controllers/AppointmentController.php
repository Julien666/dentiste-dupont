<?php
/**
 * CancelAppointmentController.php
 * Ce fichier est appelé par l'index.php via require_once
 */

// 1. Sécurité : Vérifier si l'utilisateur est bien connecté
// (La session est déjà active grâce à l'index)
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$id_rdv = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

if ($id_rdv) {
    // 2. Préparation de la requête de suppression
    // $pdo est déjà disponible car chargé par l'index
    
    if ($user_role === 'patient') {
        // Un patient ne peut supprimer que son propre RDV
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
        $stmt->execute([$id_rdv, $user_id]);
    } 
    else if ($user_role === 'admin') {
        // Un admin peut supprimer n'importe quel RDV
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$id_rdv]);
    }

    // 3. Redirection intelligente selon le rôle
    $redirect = ($user_role === 'admin') ? 'dashboard' : 'mes-rdv';
    header("Location: index.php?page=$redirect&success=cancelled");
    exit();
} else {
    // Si pas d'ID, on renvoie à l'accueil
    header('Location: index.php?page=home');
    exit();
}