<?php
/**
 * CompleteAppointmentController.php
 * Ce fichier est inclus par l'index.php. 
 * $pdo et $_SESSION sont déjà disponibles.
 */

// 1. Sécurité : on vérifie que c'est bien une requête POST et que l'utilisateur est admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    
    // On récupère les données du formulaire (le name dans ton HTML doit correspondre)
    $id = $_POST['id_rdv']; 
    $notes = htmlspecialchars($_POST['notes_soin']);

    try {
        // 2. Mise à jour du statut et ajout de la note
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'effectué', notes_soin = ? WHERE id = ?");
        
        if ($stmt->execute([$notes, $id])) {
            // 3. Redirection vers la ROUTE dashboard de l'index
            header('Location: index.php?page=dashboard&success=complete');
            exit();
        } else {
            echo "Erreur lors de l'exécution de la requête.";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }

} else {
    // Si accès non autorisé, retour à la page de connexion via l'index
    header('Location: index.php?page=login');
    exit();
}