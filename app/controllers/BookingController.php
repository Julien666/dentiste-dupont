<?php
// On vérifie que l'utilisateur est connecté pour prendre RDV
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login&error=auth_required');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Récupération des données du formulaire
    $user_id = $_SESSION['user_id'];
    $service_id = intval($_POST['service_id']);
    $date_rdv = $_POST['date_rdv'];
    $heure_rdv = $_POST['heure_rdv'];
    $description = htmlspecialchars($_POST['description'] ?? '');

    // 2. Validation simple
    if (empty($date_rdv) || empty($heure_rdv) || empty($service_id)) {
        header('Location: index.php?page=prendre-rdv&error=missing_fields');
        exit();
    }

    try {
        // 3. VÉRIFICATION DE DISPONIBILITÉ (Le "Verrou")
        $check = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE date_rdv = ? AND heure_rdv = ? AND status != 'annulé'");
        $check->execute([$date_rdv, $heure_rdv]);
        
        if ($check->fetchColumn() > 0) {
            // Créneau déjà pris !
            header('Location: index.php?page=prendre-rdv&error=deja_pris');
            exit();
        }

        // 4. INSERTION SI TOUT EST OK
        $stmt = $pdo->prepare("INSERT INTO appointments (user_id, service_id, date_rdv, heure_rdv, description, status) VALUES (?, ?, ?, ?, ?, 'prévu')");
        $stmt->execute([$user_id, $service_id, $date_rdv, $heure_rdv, $description]);

        // 5. REDIRECTION VERS LE RÉCAPITULATIF
        header('Location: index.php?page=mes-rdv&success=booked');
        exit();

    } catch (PDOException $e) {
        // En cas d'erreur SQL (ex: violation de la clé unique que nous avons créée)
        header('Location: index.php?page=prendre-rdv&error=sql_error');
        exit();
    }
}