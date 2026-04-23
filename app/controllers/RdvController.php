<?php
// Sécurité : Vérification de la session
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

// --- CAS 1 : ANNULATION PAR LE PATIENT ---
if (isset($_GET['page']) && $_GET['page'] === 'rdv-cancel' && isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        // On utilise la table 'rendez_vous' et la colonne 'statut'
        $query = $pdo->prepare("UPDATE rendez_vous SET statut = 'annulé' WHERE id = ?");
        $query->execute([$id]);

        header('Location: index.php?page=mes-rdv&cancelled=1');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'annulation : " . $e->getMessage());
    }
}

// --- CAS 2 : ENREGISTREMENT D'UN NOUVEAU RDV (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date_rdv'])) {
    $id_patient = $_SESSION['user_id'];
    $date_rdv   = $_POST['date_rdv'];
    $heure_rdv  = $_POST['heure_rdv'];
    $motif      = $_POST['motif'] ?? 'Consultation';
    
    // Formatage pour la colonne 'date' (DATETIME)
    $datetime_complet = $date_rdv . ' ' . $heure_rdv . ':00';

    try {
        // Insertion dans la table 'rendez_vous' pour être visible partout
        $sql = "INSERT INTO rendez_vous (id_patient, date, id_acte, statut) 
                VALUES (?, ?, ?, 'confirmé')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_patient, $datetime_complet, $motif]);

        header('Location: index.php?page=mes-rdv&success=1');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'enregistrement : " . $e->getMessage());
    }
}

// --- CAS 3 : SUPPRESSION PAR L'ADMIN ---
if (isset($_GET['page']) && $_GET['page'] === 'delete-rdv' && isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        $query = $pdo->prepare("DELETE FROM rendez_vous WHERE id = ?");
        $query->execute([$id]);

        header('Location: index.php?page=dashboard&deleted=1');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
}