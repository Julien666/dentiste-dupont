<?php
/**
 * AdminDeleteRDV.php
 * Ce contrôleur supprime un rendez-vous (Action réservée à l'admin)
 */

// 1. Vérification de sécurité : Seul un admin connecté peut supprimer
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit();
}

// 2. Récupération de l'ID du rendez-vous
$id_rdv = $_GET['id'] ?? null;

if ($id_rdv) {
    // 3. Préparation et exécution de la suppression
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
    
    if ($stmt->execute([$id_rdv])) {
        // Succès : Redirection vers le dashboard avec un message
        header('Location: index.php?page=dashboard&success=deleted');
        exit();
    } else {
        // Erreur technique
        echo "Erreur lors de la suppression du rendez-vous.";
    }
} else {
    // Si l'ID est manquant
    header('Location: index.php?page=dashboard');
    exit();
}