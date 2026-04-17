<?php
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $date_rdv = $_POST['date_rdv'];
    $heure_rdv = $_POST['heure_rdv'];
    $description = htmlspecialchars($_POST['description']);

    // Insertion en base de données
    $sql = "INSERT INTO appointments (user_id, date_rdv, heure_rdv, description) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$user_id, $date_rdv, $heure_rdv, $description])) {
        // Redirection vers la liste des RDV avec un message de succès
        header('Location: ../views/front/mes-rdv.php?success=rdv');
        exit();
    } else {
        echo "Erreur lors de la prise de rendez-vous.";
    }
} else {
    header('Location: ../views/login.php');
    exit();
}