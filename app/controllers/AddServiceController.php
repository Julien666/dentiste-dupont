<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom_service'] ?? '');
    
    // Si le prix est vide ou non numérique, on met NULL pour la base de données
    $prix = (!empty($_POST['prix'])) ? floatval($_POST['prix']) : null;
    
    $description = htmlspecialchars($_POST['description'] ?? '');
    $duree = intval($_POST['duree'] ?? 30);

    // MODIFICATION ICI : On n'exige plus que le prix soit > 0
    if (!empty($nom)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO services (nom, prix, description, duree_minutes) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $prix, $description, $duree]);

            header('Location: index.php?page=gestion-services&success=1');
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de l'ajout : " . $e->getMessage());
        }
    } else {
        header('Location: index.php?page=gestion-services&error=invalid');
        exit();
    }
}

require_once ROOT_PATH . '/app/views/back/add-service.php';