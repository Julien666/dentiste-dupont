<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_rdv'];
    $notes = htmlspecialchars($_POST['notes_soin']);

    $stmt = $pdo->prepare("UPDATE appointments SET status = 'effectué', notes_soin = ? WHERE id = ?");
    $stmt->execute([$notes, $id]);

    header('Location: index.php?page=dashboard&success=soin-valide');
    exit();
}