<?php
// Vérification de sécurité (Admin uniquement)
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?page=home');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // On récupère tous les IDs de jours existants pour boucler dessus
        $stmt = $pdo->query("SELECT id FROM horaires");
        $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $updateStmt = $pdo->prepare("
            UPDATE horaires 
            SET ouverture = ?, fermeture = ?, est_ferme = ? 
            WHERE id = ?
        ");

        foreach ($ids as $id) {
            $ouv = $_POST['ouverture'][$id] ?? '09:00';
            $fer = $_POST['fermeture'][$id] ?? '18:00';
            // Si la checkbox n'est pas cochée, elle n'est pas envoyée en POST
            $ferme = isset($_POST['est_ferme'][$id]) ? 1 : 0;

            $updateStmt->execute([$ouv, $fer, $ferme, $id]);
        }

        header('Location: index.php?page=gestion-horaires&status=success');
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour des horaires : " . $e->getMessage());
    }
}