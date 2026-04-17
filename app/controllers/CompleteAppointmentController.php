<?php
session_start();
require_once '../../config/db.php';

// Sécurité : on vérifie que c'est bien une requête POST et que l'utilisateur est admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    
    $id = $_POST['appointment_id'];
    $notes = htmlspecialchars($_POST['notes_soin']);

    try {
        // On met à jour le statut et on ajoute la note
        // IMPORTANT : Vérifie que ta base a bien 'effectué' avec l'accent
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'effectué', notes_soin = ? WHERE id = ?");
        
        if ($stmt->execute([$notes, $id])) {
            // Redirection vers le dashboard avec un message de succès
            header('Location: /dentiste-dupont/app/views/back/dashboard.php?success=complete');
            exit();
        } else {
            echo "Erreur lors de l'exécution de la requête.";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }

} else {
    // Si quelqu'un essaie d'accéder au fichier directement sans formulaire
    header('Location: /dentiste-dupont/app/views/login.php');
    exit();
}