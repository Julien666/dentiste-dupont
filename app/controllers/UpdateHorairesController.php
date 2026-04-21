<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['ouvertures'] as $id => $ouverture) {
        $fermeture = $_POST['fermetures'][$id];
        $est_ferme = isset($_POST['fermes'][$id]) ? 1 : 0;

        $stmt = $pdo->prepare("UPDATE horaires SET ouverture = ?, fermeture = ?, est_ferme = ? WHERE id = ?");
        $stmt->execute([$ouverture, $fermeture, $est_ferme, $id]);
    }
    header('Location: index.php?page=gestion-horaires&success=1');
    exit();
}