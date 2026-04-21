<?php
/**
 * AppointmentController.php
 * Gère l'enregistrement d'un nouveau rendez-vous
 */

// 1. Sécurité : Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

// 2. Vérifier que le formulaire a été envoyé en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupération des données du formulaire
    $user_id     = $_SESSION['user_id'];
    $date_rdv    = $_POST['date_rdv'];
    $heure_rdv   = $_POST['heure_rdv'];
    $description = htmlspecialchars($_POST['description']); // Protection XSS
    $status      = 'prévu'; // Statut par défaut

    try {
        // 3. Préparation de la requête SQL
        // On n'insère pas created_at car MySQL le gère seul avec CURRENT_TIMESTAMP
        // On n'insère pas notes_soin car il est vide au départ (NULL)
        $sql = "INSERT INTO appointments (user_id, date_rdv, heure_rdv, description, status) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$user_id, $date_rdv, $heure_rdv, $description, $status])) {
            // Succès : redirection vers la liste des rendez-vous
            header('Location: index.php?page=mes-rdv&success=1');
            exit();
        } else {
            echo "Une erreur est survenue lors de l'enregistrement.";
        }

    } catch (PDOException $e) {
        // En cas d'erreur SQL (ex: colonne mal nommée)
        die("Erreur de base de données : " . $e->getMessage());
    }

} else {
    // Si on tente d'accéder au contrôleur sans formulaire
    header('Location: index.php?page=prendre-rdv');
    exit();
}