<?php
/**
 * Contrôleur de suppression de service (Admin uniquement)
 */

// 1. Vérification de sécurité
// On vérifie les deux variables au cas où
$role = $_SESSION['role'] ?? $_SESSION['user_role'] ?? null;

if (!isset($_SESSION['user_id']) || $role !== 'admin') {
    // Si pas admin, on redirige vers le login ou le dashboard
    header('Location: index.php?page=login');
    exit();
}

// 2. Traitement de la suppression
if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        $query = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $query->execute([$id]);

        header('Location: index.php?page=gestion-services&success=deleted');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
}